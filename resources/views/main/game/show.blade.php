@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gr            <h2 class="text-xl font-bold mb-4 text-secondary">📊 Progress Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-primary/20 rounded-lg">
                    <div class="text-2xl font-bold text-primary">{{ $userSession->completion_percentage }}%</div>
                    <div class="text-sm text-red-200">Completion</div>
                </div>
                <div class="text-center p-4 bg-secondary/20 rounded-lg">
                    <div class="text-2xl font-bold text-secondary">{{ $userSession->score }}</div>
                    <div class="text-sm text-red-200">Current Score</div>
                </div>
                <div class="text-center p-4 bg-tertiary/20 rounded-lg">
                    <div class="text-2xl font-bold text-tertiary">{{ $userSession->formatted_time_spent }}</div>
                    <div class="text-sm text-orange-200">Time Played</div>
                </div>rom-primary via-secondary to-quaternary/60 text-white">
    <div class="max-w-6xl mx-auto px-4 py-4 md:py-8">
        <!-- Game Header -->
        <div class="bg-black bg-opacity-50 rounded-xl md:rounded-2xl shadow-2xl border border-gray-600 p-4 md:p-6 lg:p-8 mb-6 md:mb-8">
            <div class="flex flex-col sm:flex-row items-start justify-between mb-4 md:mb-6 space-y-4 sm:space-y-0">
                <a href="{{ route('game.index') }}" class="text-red-200 hover:text-white transition-colors text-sm sm:text-base">
                    ← Kembali ke Games
                </a>
                <div class="flex items-center space-x-4">
                    <span class="px-4 py-2 bg-{{ $game->difficulty === 'easy' ? 'green' : ($game->difficulty === 'medium' ? 'yellow' : 'red') }}-600 rounded-full text-sm font-semibold">
                        {{ ucfirst($game->difficulty) }}
                    </span>
                    @if($game->is_active)
                    <span class="px-4 py-2 bg-green-600 rounded-full text-sm font-semibold">
                        ✅ Aktif
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-col lg:flex-row items-start space-y-6 lg:space-y-0 lg:space-x-8">
                <!-- Game Icon -->
                <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br {{ $this->getGameGradient($game->game_type) }} rounded-xl md:rounded-2xl flex items-center justify-center text-3xl sm:text-4xl lg:text-5xl border-4 border-white border-opacity-20 mx-auto lg:mx-0 flex-shrink-0">
                    {{ $this->getGameIcon($game->game_type) }}
                </div>
                
                <!-- Game Info -->
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-2xl sm:text-3xl font-bold mb-4">{{ $game->title }}</h1>
                    <p class="text-gray-300 text-base sm:text-lg mb-6 leading-relaxed">{{ $game->description }}</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-3 bg-blue-600 bg-opacity-30 rounded-lg">
                            <div class="text-2xl font-bold">{{ $game->total_plays }}</div>
                            <div class="text-sm text-blue-200">Total Dimainkan</div>
                        </div>
                        <div class="text-center p-3 bg-green-600 bg-opacity-30 rounded-lg">
                            <div class="text-2xl font-bold">{{ number_format($game->average_score, 1) }}</div>
                            <div class="text-sm text-green-200">Skor Rata-rata</div>
                        </div>
                        <div class="text-center p-3 bg-purple-600 bg-opacity-30 rounded-lg">
                            <div class="text-2xl font-bold">{{ ucfirst($game->difficulty) }}</div>
                            <div class="text-sm text-purple-200">Kesulitan</div>
                        </div>
                        <div class="text-center p-3 bg-yellow-600 bg-opacity-30 rounded-lg">
                            <div class="text-2xl font-bold">{{ $game->game_type_display }}</div>
                            <div class="text-sm text-yellow-200">Tipe Game</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        @auth
                        <a href="{{ route('game.play', $game->slug) }}" 
                           class="bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 inline-block">
                            🎮 {{ $userSession ? 'Lanjutkan' : 'Mulai' }} Game
                        </a>
                        @else
                        <a href="{{ route('login') }}" 
                           class="bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 inline-block">
                            🔐 Login untuk Bermain
                        </a>
                        @endauth
                        
                        <button id="leaderboard-btn" class="bg-gray-600 hover:bg-gray-700 px-8 py-3 rounded-xl font-semibold transition-all">
                            🏆 Papan Skor
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Progress (if logged in and has played) -->
        @auth
        @if($userSession)
        <div class="bg-black bg-opacity-50 rounded-2xl shadow-2xl border border-gray-600 p-6 mb-8">
            <h2 class="text-xl font-bold mb-4 text-green-300">📊 Progress Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-600 bg-opacity-20 rounded-lg">
                    <div class="text-2xl font-bold text-blue-300">{{ $userSession->completion_percentage }}%</div>
                    <div class="text-sm text-blue-200">Completion</div>
                </div>
                <div class="text-center p-4 bg-green-600 bg-opacity-20 rounded-lg">
                    <div class="text-2xl font-bold text-green-300">{{ $userSession->score }}</div>
                    <div class="text-sm text-green-200">Current Score</div>
                </div>
                <div class="text-center p-4 bg-purple-600 bg-opacity-20 rounded-lg">
                    <div class="text-2xl font-bold text-purple-300">{{ $userSession->formatted_time_spent }}</div>
                    <div class="text-sm text-purple-200">Time Played</div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-4">
                <div class="flex justify-between text-sm text-gray-300 mb-2">
                    <span>Progress</span>
                    <span>{{ $userSession->completion_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $userSession->completion_percentage }}%"></div>
                </div>
            </div>
        </div>
        @endif
        @endauth

        <!-- User Achievements -->
        @auth
        @if($userAchievements->count() > 0)
        <div class="bg-black bg-opacity-50 rounded-2xl shadow-2xl border border-gray-600 p-6 mb-8">
            <h2 class="text-xl font-bold mb-4 text-tertiary">🏆 Achievement Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($userAchievements as $achievement)
                <div class="bg-tertiary/20 rounded-lg p-4 border border-tertiary/40">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="text-2xl">{{ $achievement->icon }}</span>
                        <h3 class="font-bold text-yellow-300">{{ $achievement->achievement_name }}</h3>
                    </div>
                    <p class="text-yellow-200 text-sm">{{ $achievement->description }}</p>
                    <p class="text-yellow-100 text-xs mt-2">{{ $achievement->created_at->format('d M Y') }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endauth

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Game Details -->
            <div class="lg:col-span-2 space-y-6 md:space-y-8">
                <div class="bg-black bg-opacity-50 rounded-2xl shadow-2xl border border-gray-600 p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-6 text-blue-300">🎯 Fitur Game</h2>
                    
                    @php
                        $features = [
                            'time_travel' => [
                                'Dialog interaktif dengan tokoh sejarah',
                                'Sistem pilihan dengan konsekuensi',
                                'Konteks sejarah yang akurat',
                                'Multiple scenarios bersejarah',
                                'Achievement untuk setiap chapter'
                            ],
                            'geography_puzzle' => [
                                'Drag-and-drop puzzle peta',
                                'Berbagai tingkat kesulitan',
                                'Informasi provinsi dan ibukota',
                                'Sistem hint terbatas',
                                'Timer challenge untuk bonus skor'
                            ],
                            'historical_detective' => [
                                'Interactive crime scenes',
                                'Evidence collection system',
                                'Witness interview mechanics',
                                'Multiple mystery cases',
                                'Deduction and reasoning challenges'
                            ],
                            'island_explorer' => [
                                'Interactive map exploration',
                                'Cultural artifact collection',
                                'Mini-games per island',
                                'Discovery mechanics',
                                'Rich cultural information'
                            ],
                            'memory_palace' => [
                                '3D memory palace visualization',
                                'Mnemonic technique guidance',
                                'Spaced repetition system',
                                'Daily challenges',
                                'Advanced memory training'
                            ]
                        ];
                    @endphp
                    
                    <ul class="space-y-3">
                        @foreach($features[$game->game_type] ?? [] as $feature)
                        <li class="flex items-center space-x-3">
                            <span class="text-green-400">✓</span>
                            <span class="text-gray-300">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- How to Play -->
                <div class="bg-black bg-opacity-50 rounded-2xl shadow-2xl border border-gray-600 p-6">
                    <h2 class="text-2xl font-bold mb-6 text-purple-300">📚 Cara Bermain</h2>
                    
                    @php
                        $instructions = [
                            'time_travel' => [
                                'Baca cerita dan konteks sejarah dengan saksama',
                                'Pilih keputusan yang menurutmu paling tepat',
                                'Setiap pilihan akan mempengaruhi skor dan alur cerita',
                                'Selesaikan semua chapter untuk achievement khusus'
                            ],
                            'geography_puzzle' => [
                                'Seret potongan peta ke posisi yang tepat',
                                'Gunakan hint jika kesulitan (terbatas)',
                                'Semakin cepat selesai, semakin tinggi skor',
                                'Pelajari informasi provinsi setelah selesai'
                            ],
                            'historical_detective' => [
                                'Investigasi TKP dan kumpulkan bukti',
                                'Wawancarai saksi untuk informasi tambahan',
                                'Analisis bukti dan buat deduksi',
                                'Pecahkan misteri dengan akurasi tinggi'
                            ],
                            'island_explorer' => [
                                'Jelajahi peta Indonesia secara interaktif',
                                'Kumpulkan artefak budaya di setiap pulau',
                                'Mainkan mini-games untuk bonus poin',
                                'Pelajari keunikan budaya setiap daerah'
                            ],
                            'memory_palace' => [
                                'Bangun istana memori virtual Anda',
                                'Gunakan teknik mnemonic yang diajarkan',
                                'Latihan rutin dengan spaced repetition',
                                'Tantang diri dengan daily challenges'
                            ]
                        ];
                    @endphp
                    
                    <ol class="space-y-3">
                        @foreach($instructions[$game->game_type] ?? [] as $index => $instruction)
                        <li class="flex items-start space-x-3">
                            <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">{{ $index + 1 }}</span>
                            <span class="text-gray-300">{{ $instruction }}</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Leaderboard -->
                <div class="bg-black bg-opacity-50 rounded-2xl shadow-2xl border border-gray-600 p-6">
                    <h3 class="text-xl font-bold mb-4 text-yellow-300">🏆 Top Players</h3>
                    <div id="leaderboard-content" class="space-y-3">
                        <div class="text-center text-gray-400">Loading...</div>
                    </div>
                </div>

                <!-- Game Stats -->
                <div class="bg-black bg-opacity-50 rounded-2xl shadow-2xl border border-gray-600 p-6">
                    <h3 class="text-xl font-bold mb-4 text-green-300">📊 Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-300">Total Players:</span>
                            <span class="font-semibold text-white">{{ $game->sessions->unique('user_id')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Completed:</span>
                            <span class="font-semibold text-green-400">{{ $game->sessions->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Average Score:</span>
                            <span class="font-semibold text-blue-400">{{ number_format($game->average_score, 1) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Difficulty:</span>
                            <span class="font-semibold text-{{ $game->difficulty === 'easy' ? 'green' : ($game->difficulty === 'medium' ? 'yellow' : 'red') }}-400">{{ ucfirst($game->difficulty) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Related Games -->
                <div class="bg-black bg-opacity-50 rounded-2xl shadow-2xl border border-gray-600 p-6">
                    <h3 class="text-xl font-bold mb-4 text-blue-300">🎮 Game Lainnya</h3>
                    <div class="space-y-3">
                        @php
                            $relatedGames = \App\Models\Game::active()->public()
                                ->where('id', '!=', $game->id)
                                ->limit(3)
                                ->get();
                        @endphp
                        
                        @foreach($relatedGames as $relatedGame)
                        <a href="{{ route('game.show', $relatedGame->slug) }}" class="block p-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">{{ $this->getGameIcon($relatedGame->game_type) }}</span>
                                <div>
                                    <div class="font-semibold text-white">{{ $relatedGame->title }}</div>
                                    <div class="text-sm text-gray-300">{{ ucfirst($relatedGame->difficulty) }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadLeaderboard();
});

async function loadLeaderboard() {
    try {
        const response = await fetch(`/game/{{ $game->slug }}/leaderboard`);
        const leaderboard = await response.json();
        
        const container = document.getElementById('leaderboard-content');
        container.innerHTML = '';
        
        if (leaderboard.length === 0) {
            container.innerHTML = '<div class="text-center text-gray-400">Belum ada pemain</div>';
            return;
        }
        
        leaderboard.slice(0, 5).forEach((entry, index) => {
            const medal = index < 3 ? ['🥇', '🥈', '🥉'][index] : `#${index + 1}`;
            const entryDiv = document.createElement('div');
            entryDiv.className = 'flex justify-between items-center p-2 bg-gray-700 rounded-lg';
            entryDiv.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span class="text-lg">${medal}</span>
                    <span class="font-semibold text-white">${entry.user.name}</span>
                </div>
                <div class="text-right">
                    <div class="font-bold text-yellow-300">${entry.score}</div>
                    <div class="text-xs text-gray-400">${formatTime(entry.time_spent)}</div>
                </div>
            `;
            container.appendChild(entryDiv);
        });
    } catch (error) {
        console.error('Error loading leaderboard:', error);
        document.getElementById('leaderboard-content').innerHTML = '<div class="text-center text-red-400">Error loading data</div>';
    }
}

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
}
</script>
@endpush
@endsection

@php
function getGameGradient($gameType) {
    $gradients = [
        'time_travel' => 'from-primary to-secondary',
        'geography_puzzle' => 'from-secondary to-tertiary',
        'historical_detective' => 'from-tertiary to-primary',
        'island_explorer' => 'from-primary to-quaternary',
        'memory_palace' => 'from-secondary to-primary',
    ];
    return $gradients[$gameType] ?? 'from-gray-400 to-gray-500';
}

function getGameIcon($gameType) {
    $icons = [
        'time_travel' => '🕰️',
        'geography_puzzle' => '🧩',
        'historical_detective' => '🔍',
        'island_explorer' => '🏝️',
        'memory_palace' => '🧠',
    ];
    return $icons[$gameType] ?? '🎮';
}
@endphp