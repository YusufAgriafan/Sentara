@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-quaternary/20 to-quaternary/40 py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center my-8 md:my-12">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">🎮 Permainan Edukatif</h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                Jelajahi sejarah dan geografi Indonesia melalui permainan interaktif yang menarik dan edukatif
            </p>
        </div>

        <!-- Stats Section (if user is logged in) -->
        @auth
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-6 md:mb-8">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4">📊 Progres Anda</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                <div class="text-center p-3 md:p-4 bg-primary/10 rounded-lg">
                    <div class="text-xl md:text-2xl font-bold text-primary">{{ $recentSessions?->unique('game_id')->count() ?? 0 }}</div>
                    <div class="text-xs md:text-sm text-gray-600">Game Dimainkan</div>
                </div>
                <div class="text-center p-3 md:p-4 bg-secondary/10 rounded-lg">
                    <div class="text-xl md:text-2xl font-bold text-secondary">{{ $recentSessions?->where('status', 'completed')->count() ?? 0 }}</div>
                    <div class="text-xs md:text-sm text-gray-600">Game Selesai</div>
                </div>
                <div class="text-center p-3 md:p-4 bg-tertiary/10 rounded-lg">
                    <div class="text-xl md:text-2xl font-bold text-tertiary">{{ $recentSessions?->sum('score') ?? 0 }}</div>
                    <div class="text-xs md:text-sm text-gray-600">Total Skor</div>
                </div>
                <div class="text-center p-3 md:p-4 bg-primary/10 rounded-lg">
                    <div class="text-xl md:text-2xl font-bold text-primary">{{ $recentSessions?->where('status', 'in_progress')->count() ?? 0 }}</div>
                    <div class="text-xs md:text-sm text-gray-600">Game Berlangsung</div>
                </div>
            </div>
        </div>
        @endauth

        <!-- Games Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
            @forelse($games as $game)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <!-- Game Thumbnail -->
                <div class="relative h-40 sm:h-48 bg-gradient-to-br {{ getGameGradient($game->game_type) }} flex items-center justify-center">
                    <div class="text-4xl sm:text-6xl">{{ getGameIcon($game->game_type) }}</div>
                    <div class="absolute top-2 sm:top-4 right-2 sm:right-4 bg-white bg-opacity-90 px-2 py-1 rounded-full text-xs font-semibold text-gray-700">
                        {{ ucfirst($game->difficulty) }}
                    </div>
                </div>

                <!-- Game Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $game->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $game->description }}</p>
                    
                    <!-- Game Type Badge -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                            {{ $game->game_type_display }}
                        </span>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-4">👥 {{ $game->total_plays }}</span>
                            <span>⭐ {{ number_format($game->average_score, 1) }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('game.show', $game->slug) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg font-semibold transition-colors">
                            📖 Info
                        </a>
                        <a href="{{ route('game.play', $game->slug) }}" 
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg font-semibold transition-colors">
                            🎮 Main
                        </a>
                    </div>

                    <!-- Progress Bar (if user has played this game) -->
                    @auth
                    @php
                        $userSession = $recentSessions?->where('game_id', $game->id)->first();
                    @endphp
                    @if($userSession)
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Progress</span>
                            <span>{{ $userSession->completion_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" 
                                 style="width: {{ $userSession->completion_percentage }}%"></div>
                        </div>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-6xl mb-4">🎮</div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Game Tersedia</h3>
                <p class="text-gray-500">Game edukatif akan segera hadir!</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($games->hasPages())
        <div class="mt-8 md:mt-12 flex justify-center">
            {{ $games->links() }}
        </div>
        @endif

        <!-- Game Categories Section -->
        <div class="mt-12 md:mt-16 bg-white rounded-xl shadow-lg p-6 md:p-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-6 text-center">📚 Kategori Permainan</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 md:gap-6">
                <div class="text-center p-3 md:p-4 hover:bg-primary/5 rounded-lg transition-colors">
                    <div class="text-2xl md:text-3xl mb-2">🕰️</div>
                    <h3 class="font-semibold text-primary text-sm md:text-base">Time Travel</h3>
                    <p class="text-xs text-gray-600 mt-1">Petualangan waktu interaktif</p>
                </div>
                <div class="text-center p-3 md:p-4 hover:bg-secondary/5 rounded-lg transition-colors">
                    <div class="text-2xl md:text-3xl mb-2">🧩</div>
                    <h3 class="font-semibold text-secondary text-sm md:text-base">Geography Puzzle</h3>
                    <p class="text-xs text-gray-600 mt-1">Puzzle peta Indonesia</p>
                </div>
                <div class="text-center p-3 md:p-4 hover:bg-tertiary/5 rounded-lg transition-colors">
                    <div class="text-2xl md:text-3xl mb-2">🔍</div>
                    <h3 class="font-semibold text-tertiary text-sm md:text-base">Historical Detective</h3>
                    <p class="text-xs text-gray-600 mt-1">Investigasi misteri sejarah</p>
                </div>
                <div class="text-center p-3 md:p-4 hover:bg-purple-50 rounded-lg transition-colors">
                    <div class="text-2xl md:text-3xl mb-2">🏝️</div>
                    <h3 class="font-semibold text-gray-800 text-sm md:text-base">Island Explorer</h3>
                    <p class="text-xs text-gray-600 mt-1">Eksplorasi nusantara</p>
                </div>
                <div class="text-center p-3 md:p-4 hover:bg-pink-50 rounded-lg transition-colors">
                    <div class="text-2xl md:text-3xl mb-2">🧠</div>
                    <h3 class="font-semibold text-gray-800 text-sm md:text-base">Memory Palace</h3>
                    <p class="text-xs text-gray-600 mt-1">Teknik memori canggih</p>
                </div>
            </div>
        </div>

        <!-- Call to Action for Guests -->
        @guest
        <div class="mt-12 md:mt-16 bg-gradient-to-r from-primary to-secondary rounded-xl shadow-lg p-6 md:p-8 text-center text-white">
            <h2 class="text-xl md:text-2xl font-bold mb-4">🚀 Mulai Petualangan Belajar Anda!</h2>
            <p class="text-sm md:text-base mb-6 px-4">Daftar sekarang untuk melacak progress dan membuka achievement khusus</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
                <a href="{{ route('register') }}" 
                   class="bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-center">
                    📝 Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" 
                   class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors text-center">
                    🔐 Masuk
                </a>
            </div>
        </div>
        @endguest

    </div>
</div>

@push('scripts')
<script>
// Add some interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    document.querySelectorAll('.bg-white').forEach((card) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        observer.observe(card);
    });
});
</script>
@endpush

@push('styles')
<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
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
