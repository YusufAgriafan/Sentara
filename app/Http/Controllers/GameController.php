<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameSession;
use App\Models\GameAchievement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Display a listing of available educational games
     */
    public function index(): View
    {
        $games = Game::active()
            ->public()
            ->with(['sessions' => function($query) {
                $query->select('game_id', DB::raw('COUNT(*) as total_plays'), DB::raw('AVG(score) as avg_score'))
                    ->groupBy('game_id');
            }])
            ->paginate(12);

        // Get user's recent sessions if logged in
        $recentSessions = null;
        if (Auth::check()) {
            $recentSessions = GameSession::where('user_id', Auth::id())
                ->with('game')
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('main.game.index', compact('games', 'recentSessions'));
    }

    /**
     * Show a specific game
     */
    public function show(Game $game): View
    {
        $game->load(['sessions', 'achievements']);
        
        $userSession = null;
        $userAchievements = [];
        
        if (Auth::check()) {
            $userSession = GameSession::where('user_id', Auth::id())
                ->where('game_id', $game->id)
                ->where('status', 'in_progress')
                ->first();
                
            $userAchievements = GameAchievement::where('user_id', Auth::id())
                ->where('game_id', $game->id)
                ->get();
        }

        return view('main.game.show', compact('game', 'userSession', 'userAchievements'));
    }

    /**
     * Start or resume a game session
     */
    public function play(Game $game): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Silakan login untuk bermain game.');
        }

        $session = GameSession::firstOrCreate([
            'user_id' => Auth::id(),
            'game_id' => $game->id,
            'status' => 'in_progress'
        ], [
            'progress_data' => [
                'total_steps' => $this->getGameSteps($game),
                'completed_steps' => 0,
                'current_level' => 1,
            ],
            'started_at' => now(),
        ]);

        // Route to specific game view based on game type
        switch ($game->game_type) {
            case 'time_travel':
                return view('main.game.time_travel', compact('game', 'session'));
            case 'geography_puzzle':
                return view('main.game.geography_puzzle', compact('game', 'session'));
            case 'historical_detective':
                return view('main.game.historical_detective', compact('game', 'session'));
            case 'island_explorer':
                return view('main.game.island_explorer', compact('game', 'session'));
            case 'memory_palace':
                return view('main.game.memory_palace', compact('game', 'session'));
            default:
                return redirect()->back()->with('error', 'Tipe game tidak dikenali.');
        }
    }

    /**
     * Update game progress
     */
    public function updateProgress(Request $request, Game $game): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $session = GameSession::where('user_id', Auth::id())
            ->where('game_id', $game->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $request->validate([
            'progress_data' => 'required|array',
            'score' => 'integer|min:0',
            'time_spent' => 'integer|min:0',
        ]);

        $progressData = array_merge(
            $session->progress_data ?? [], 
            $request->progress_data
        );

        $session->update([
            'progress_data' => $progressData,
            'score' => $request->input('score', $session->score),
            'time_spent' => $request->input('time_spent', $session->time_spent),
        ]);

        return response()->json([
            'success' => true,
            'session' => $session->fresh(),
        ]);
    }

    /**
     * Complete a game session
     */
    public function complete(Request $request, Game $game): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $session = GameSession::where('user_id', Auth::id())
            ->where('game_id', $game->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $request->validate([
            'final_score' => 'required|integer|min:0',
            'final_time' => 'required|integer|min:0',
            'completion_data' => 'array',
        ]);

        $session->update([
            'status' => 'completed',
            'score' => $request->final_score,
            'time_spent' => $request->final_time,
            'progress_data' => array_merge(
                $session->progress_data ?? [], 
                $request->input('completion_data', [])
            ),
            'completed_at' => now(),
        ]);

        // Check for achievements
        $this->checkAchievements($game, $session);

        return response()->json([
            'success' => true,
            'session' => $session->fresh(),
            'achievements' => $this->getUserAchievements($game, Auth::id()),
        ]);
    }

    /**
     * Get leaderboard for a game
     */
    public function leaderboard(Game $game): JsonResponse
    {
        $leaderboard = GameSession::where('game_id', $game->id)
            ->where('status', 'completed')
            ->with('user:id,name')
            ->orderBy('score', 'desc')
            ->orderBy('time_spent', 'asc')
            ->limit(10)
            ->get();

        return response()->json($leaderboard);
    }

    /**
     * Get user's game statistics
     */
    public function stats(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();
        $gameId = $request->input('game_id');

        $query = GameSession::where('user_id', $userId);
        
        if ($gameId) {
            $query->where('game_id', $gameId);
        }

        $sessions = $query->get();
        
        $stats = [
            'total_games' => Game::count(),
            'games_played' => $sessions->unique('game_id')->count(),
            'total_sessions' => $sessions->count(),
            'completed_sessions' => $sessions->where('status', 'completed')->count(),
            'total_score' => $sessions->sum('score'),
            'average_score' => $sessions->avg('score') ?? 0,
            'best_score' => $sessions->max('score') ?? 0,
            'total_time' => $sessions->sum('time_spent'),
            'total_achievements' => GameAchievement::where('user_id', $userId)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get game-specific steps for progress calculation
     */
    private function getGameSteps(Game $game): int
    {
        switch ($game->game_type) {
            case 'time_travel':
                return count($game->settings['scenarios'] ?? []);
            case 'geography_puzzle':
                return count($game->settings['levels'] ?? []);
            case 'historical_detective':
                return count($game->settings['cases'] ?? []);
            case 'island_explorer':
                return count($game->settings['islands'] ?? []);
            case 'memory_palace':
                return count($game->settings['palace_rooms'] ?? []);
            default:
                return 10;
        }
    }

    /**
     * Check and award achievements
     */
    private function checkAchievements(Game $game, GameSession $session): void
    {
        $userId = $session->user_id;
        
        // First completion achievement
        if (!GameAchievement::where('user_id', $userId)->where('game_id', $game->id)->where('achievement_type', 'first_completion')->exists()) {
            GameAchievement::create([
                'user_id' => $userId,
                'game_id' => $game->id,
                'achievement_type' => 'first_completion',
                'achievement_name' => 'First Victory',
                'description' => 'Completed ' . $game->title . ' for the first time',
            ]);
        }

        // Perfect score achievement
        $maxScore = $this->getMaxScore($game);
        if ($session->score >= $maxScore) {
            GameAchievement::updateOrCreate(
                [
                    'user_id' => $userId,
                    'game_id' => $game->id,
                    'achievement_type' => 'perfect_score'
                ],
                [
                    'achievement_name' => 'Perfect Score',
                    'description' => 'Achieved maximum score in ' . $game->title,
                ]
            );
        }

        // Speed run achievement (completed in less than average time)
        $avgTime = GameSession::where('game_id', $game->id)->where('status', 'completed')->avg('time_spent');
        if ($avgTime && $session->time_spent < ($avgTime * 0.8)) {
            GameAchievement::updateOrCreate(
                [
                    'user_id' => $userId,
                    'game_id' => $game->id,
                    'achievement_type' => 'speed_run'
                ],
                [
                    'achievement_name' => 'Speed Runner',
                    'description' => 'Completed ' . $game->title . ' in record time',
                ]
            );
        }
    }

    /**
     * Get maximum possible score for a game
     */
    private function getMaxScore(Game $game): int
    {
        switch ($game->game_type) {
            case 'time_travel':
                return 5000;
            case 'geography_puzzle':
                return 3000;
            case 'historical_detective':
                return 4000;
            case 'island_explorer':
                return 6000;
            case 'memory_palace':
                return 10000;
            default:
                return 1000;
        }
    }

    /**
     * Get user achievements for a game
     */
    private function getUserAchievements(Game $game, int $userId): array
    {
        return GameAchievement::where('user_id', $userId)
            ->where('game_id', $game->id)
            ->get()
            ->toArray();
    }
}