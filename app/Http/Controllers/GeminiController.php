<?php

namespace App\Http\Controllers;

use Parsedown;
use App\Models\Quiz;
use App\Models\ChatAI;
use App\Models\QuizOption;
use Google\AI\GenerativeAI;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\HitungBiayaTetap;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\DB;
use App\Models\HitungBiayaVariabel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class GeminiController extends Controller
{
    public function test(Request $request)
    {
        $result = Gemini::generativeModel('gemini-2.0-flash')->generateContent('57 dibagi 3');

        return response()->json([
            'message' => $result->text(),
        ]);
    }

    
    /**
     * Send a chat message to Gemini and store the exchange in DB.
     */
    public function chatSend(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'model' => 'nullable|string',
        ]);

        $user = Auth::user();
        $message = $request->input('message');
        $model = $request->input('model', 'gemini-2.0-flash');

        // Store user message
        $userChat = ChatAI::create([
            'user_id' => $user ? $user->id : null,
            'role' => 'user',
            'message' => $message,
            'model' => $model,
            'metadata' => null,
        ]);

        // Call Gemini
        try {
            $gen = Gemini::generativeModel($model)->generateContent($message);
            $botText = trim($gen->text());
        } catch (\Throwable $e) {
            return response()->json(['error' => 'AI request failed: ' . $e->getMessage()], 500);
        }

        // Store bot response
        $botChat = ChatAI::create([
            'user_id' => $user ? $user->id : null,
            'role' => 'bot',
            'message' => $botText,
            'model' => $model,
            'metadata' => null,
        ]);

        return response()->json([
            'status' => 'ok',
            'bot' => [
                'id' => $botChat->id,
                'message' => $botChat->message,
                'created_at' => $botChat->created_at,
            ],
        ]);
    }

    /**
     * Return recent chat history for the authenticated user (or global recent if no user).
     */
    public function chatHistory(Request $request)
    {
        $user = Auth::user();

        $query = ChatAI::query()->orderBy('created_at', 'desc');
        if ($user) {
            $query->where('user_id', $user->id);
        }

        $messages = $query->limit(50)->get()->reverse()->values();

        return response()->json(['messages' => $messages]);
    }
    
}
