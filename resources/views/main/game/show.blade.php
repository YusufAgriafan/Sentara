@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Mobile Menu Toggle -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button id="mobile-menu-toggle" class="bg-primary text-white p-3 rounded-xl shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Drawer -->
    <div id="mobile-drawer" class="lg:hidden fixed inset-y-0 left-0 w-80 bg-white shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out z-40">
        <div class="p-6 border-b border-quaternary">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">Game Info</h2>
                <button id="close-drawer" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-secondary p-4 rounded-xl">
                <div class="text-sm text-gray-600 mb-1">Kesulitan</div>
                <div class="text-2xl font-bold text-primary">{{ ucfirst($game->difficulty) }}</div>
            </div>
            <div class="bg-tertiary p-4 rounded-xl">
                <div class="text-sm text-gray-600 mb-1">Total Dimainkan</div>
                <div class="text-2xl font-bold text-gray-800">{{ $game->total_plays }}</div>
            </div>
            <div class="bg-quaternary p-4 rounded-xl">
                <div class="text-sm text-gray-600 mb-1">Skor Rata-rata</div>
                <div class="text-2xl font-bold text-gray-800">{{ number_format($game->average_score, 1) }}</div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8 pt-20">
        <!-- Game Header -->
        <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-8 mb-8 text-gray-800">
            <div class="flex flex-col sm:flex-row items-start justify-between mb-4 md:mb-6 space-y-4 sm:space-y-0">
                <a href="{{ route('game.index') }}" class="text-primary hover:text-secondary transition-colors text-sm sm:text-base font-medium">
                    ← Kembali ke Games
                </a>
                <div class="flex items-center space-x-4">
                    <span class="px-4 py-2 bg-{{ $game->difficulty === 'easy' ? 'green' : ($game->difficulty === 'medium' ? 'yellow' : 'red') }}-500 text-white rounded-full text-sm font-semibold">
                        {{ ucfirst($game->difficulty) }}
                    </span>
                    @if($game->is_active)
                    <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                        ✅ Aktif
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="flex flex-col lg:flex-row items-start space-y-6 lg:space-y-0 lg:space-x-8">
                <!-- Game Icon -->
                <div class="w-32 h-32 bg-secondary rounded-3xl flex items-center justify-center text-5xl border-4 border-white shadow-lg mx-auto lg:mx-0 flex-shrink-0">
                    {{ getGameIcon($game->game_type) }}
                </div>
                
                <!-- Game Info -->
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-gray-900">{{ $game->title }}</h1>
                    <p class="text-gray-700 text-base sm:text-lg mb-6 leading-relaxed">{{ $game->description }}</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-3 bg-blue-100 rounded-lg border border-blue-200">
                            <div class="text-2xl font-bold text-blue-600">{{ $game->total_plays }}</div>
                            <div class="text-sm text-blue-500">Total Dimainkan</div>
                        </div>
                        <div class="text-center p-3 bg-green-100 rounded-lg border border-green-200">
                            <div class="text-2xl font-bold text-green-600">{{ number_format($game->average_score, 1) }}</div>
                            <div class="text-sm text-green-500">Skor Rata-rata</div>
                        </div>
                        <div class="text-center p-3 bg-purple-100 rounded-lg border border-purple-200">
                            <div class="text-2xl font-bold text-purple-600">{{ ucfirst($game->difficulty) }}</div>
                            <div class="text-sm text-purple-500">Kesulitan</div>
                        </div>
                        <div class="text-center p-3 bg-orange-100 rounded-lg border border-orange-200">
                            <div class="text-2xl font-bold text-orange-600">{{ $game->game_type_display }}</div>
                            <div class="text-sm text-orange-500">Tipe Game</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        @auth
                        <a href="{{ route('game.play', $game->slug) }}" 
                           class="bg-primary hover:bg-blue-600 text-white px-8 py-4 rounded-2xl font-semibold transition-all transform hover:scale-105 text-center shadow-lg">
                            🎮 {{ $userSession ? 'Lanjutkan' : 'Mulai' }} Game
                        </a>
                        @else
                        <a href="{{ route('login') }}" 
                           class="bg-primary hover:bg-blue-600 text-white px-8 py-4 rounded-2xl font-semibold transition-all transform hover:scale-105 text-center shadow-lg">
                            🔐 Login untuk Bermain
                        </a>
                        @endauth
                        
                        <button id="leaderboard-btn" class="bg-tertiary hover:bg-yellow-400 text-gray-800 px-8 py-4 rounded-2xl font-semibold transition-all shadow-lg">
                            🏆 Papan Skor
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Progress (if logged in and has played) -->
        @auth
        @if($userSession)
        <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 text-primary flex items-center">
                <span class="text-3xl mr-3">📊</span>
                Progress Anda
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-100 rounded-lg border border-blue-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $userSession->completion_percentage }}%</div>
                    <div class="text-sm text-blue-500">Completion</div>
                </div>
                <div class="text-center p-4 bg-green-100 rounded-lg border border-green-200">
                    <div class="text-2xl font-bold text-green-600">{{ $userSession->score }}</div>
                    <div class="text-sm text-green-500">Current Score</div>
                </div>
                <div class="text-center p-4 bg-purple-100 rounded-lg border border-purple-200">
                    <div class="text-2xl font-bold text-purple-600">{{ $userSession->formatted_time_spent }}</div>
                    <div class="text-sm text-purple-500">Time Played</div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-4">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progress</span>
                    <span>{{ $userSession->completion_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
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
        <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-8 mb-8">
            <h2 class="text-2xl font-bold mb-6 text-tertiary flex items-center">
                <span class="text-3xl mr-3">🏆</span>
                Achievement Anda
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($userAchievements as $achievement)
                <div class="bg-secondary rounded-2xl p-6 border border-yellow-200 shadow-sm">
                    <div class="flex items-center space-x-4 mb-3">
                        <span class="text-3xl">{{ $achievement->icon }}</span>
                        <h3 class="font-bold text-gray-800">{{ $achievement->achievement_name }}</h3>
                    </div>
                    <p class="text-gray-700 mb-3">{{ $achievement->description }}</p>
                    <p class="text-gray-600 text-sm">{{ $achievement->created_at->format('d M Y') }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endauth

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Game Details -->
            <div class="lg:col-span-2 space-y-6 md:space-y-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 backdrop-blur-sm rounded-2xl shadow-xl border border-blue-200 p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-6 text-blue-700">🎯 Fitur Game</h2>
                    
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
                            <span class="text-green-500 text-lg">✓</span>
                            <span class="text-gray-700">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- How to Play -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 backdrop-blur-sm rounded-2xl shadow-xl border border-purple-200 p-6">
                    <h2 class="text-2xl font-bold mb-6 text-purple-700">📚 Cara Bermain</h2>
                    
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
                            <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold flex-shrink-0">{{ $index + 1 }}</span>
                            <span class="text-gray-700">{{ $instruction }}</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Leaderboard -->
                <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-6">
                    <h3 class="text-xl font-bold mb-4 text-primary flex items-center">
                        <span class="text-2xl mr-2">🏆</span>
                        Top Players
                    </h3>
                    <div id="leaderboard-content" class="space-y-3">
                        <div class="text-center text-gray-500">Loading...</div>
                    </div>
                </div>

                <!-- Game Stats -->
                <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-6">
                    <h3 class="text-xl font-bold mb-4 text-secondary flex items-center">
                        <span class="text-2xl mr-2">📊</span>
                        Statistics
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Players:</span>
                            <span class="font-semibold text-gray-800">{{ $game->sessions->unique('user_id')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Completed:</span>
                            <span class="font-semibold text-green-600">{{ $game->sessions->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Average Score:</span>
                            <span class="font-semibold text-blue-600">{{ number_format($game->average_score, 1) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Difficulty:</span>
                            <span class="font-semibold text-{{ $game->difficulty === 'easy' ? 'green' : ($game->difficulty === 'medium' ? 'yellow' : 'red') }}-600">{{ ucfirst($game->difficulty) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Related Games -->
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 backdrop-blur-sm rounded-2xl shadow-xl border border-indigo-200 p-6">
                    <h3 class="text-xl font-bold mb-4 text-indigo-700">🎮 Game Lainnya</h3>
                    <div class="space-y-3">
                        @php
                            $relatedGames = \App\Models\Game::active()->public()
                                ->where('id', '!=', $game->id)
                                ->limit(3)
                                ->get();
                        @endphp
                        
                        @foreach($relatedGames as $relatedGame)
                        <a href="{{ route('game.show', $relatedGame->slug) }}" class="block p-3 bg-white bg-opacity-60 hover:bg-opacity-80 rounded-lg transition-all border border-indigo-100 shadow-sm">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">{{ getGameIcon($relatedGame->game_type) }}</span>
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $relatedGame->title }}</div>
                                    <div class="text-sm text-gray-600">{{ ucfirst($relatedGame->difficulty) }}</div>
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
            container.innerHTML = '<div class="text-center text-gray-500">Belum ada pemain</div>';
            return;
        }
        
        leaderboard.slice(0, 5).forEach((entry, index) => {
            const medal = index < 3 ? ['🥇', '🥈', '🥉'][index] : `#${index + 1}`;
            const entryDiv = document.createElement('div');
            entryDiv.className = 'flex justify-between items-center p-2 bg-white bg-opacity-60 rounded-lg border border-yellow-200';
            entryDiv.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span class="text-lg">${medal}</span>
                    <span class="font-semibold text-gray-800">${entry.user.name}</span>
                </div>
                <div class="text-right">
                    <div class="font-bold text-yellow-600">${entry.score}</div>
                    <div class="text-xs text-gray-500">${formatTime(entry.time_spent)}</div>
                </div>
            `;
            container.appendChild(entryDiv);
        });
    } catch (error) {
        console.error('Error loading leaderboard:', error);
        document.getElementById('leaderboard-content').innerHTML = '<div class="text-center text-red-500">Error loading data</div>';
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