@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-white py-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center my-16">
            <div class="w-24 h-24 bg-primary rounded-3xl flex items-center justify-center text-5xl mx-auto mb-8 shadow-lg">
                🎮
            </div>
            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-8">Permainan Edukatif</h1>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Jelajahi sejarah dan geografi Indonesia melalui permainan interaktif yang menarik dan edukatif
            </p>
        </div>

        <!-- Stats Section (if user is logged in) -->
        @auth
        <div class="bg-quaternary rounded-3xl p-8 mb-12">
            <div class="flex items-center justify-center mb-8">
                <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-2xl mr-4">
                    📊
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Progres Anda</h2>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white rounded-2xl shadow-sm">
                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        🎮
                    </div>
                    <div class="text-2xl md:text-3xl font-bold text-primary mb-2">{{ $recentSessions?->unique('game_id')->count() ?? 0 }}</div>
                    <div class="text-sm font-medium text-gray-600">Game Dimainkan</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-sm">
                    <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        ✅
                    </div>
                    <div class="text-2xl md:text-3xl font-bold text-tertiary mb-2">{{ $recentSessions?->where('status', 'completed')->count() ?? 0 }}</div>
                    <div class="text-sm font-medium text-gray-600">Game Selesai</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-sm">
                    <div class="w-16 h-16 bg-tertiary rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        ⭐
                    </div>
                    <div class="text-2xl md:text-3xl font-bold text-primary mb-2">{{ $recentSessions?->sum('score') ?? 0 }}</div>
                    <div class="text-sm font-medium text-gray-600">Total Skor</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-sm">
                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                        ⏳
                    </div>
                    <div class="text-2xl md:text-3xl font-bold text-tertiary mb-2">{{ $recentSessions?->where('status', 'in_progress')->count() ?? 0 }}</div>
                    <div class="text-sm font-medium text-gray-600">Game Berlangsung</div>
                </div>
            </div>
        </div>
        @endauth

        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($games as $game)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
                <!-- Game Thumbnail -->
                <div class="relative h-48 bg-primary flex items-center justify-center">
                    <div class="text-6xl text-white">{{ getGameIcon($game->game_type) }}</div>
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full">
                        <span class="text-xs font-bold text-gray-800">{{ ucfirst($game->difficulty) }}</span>
                    </div>
                </div>

                <!-- Game Content -->
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $game->title }}</h3>
                    <p class="text-gray-600 mb-6 line-clamp-3">{{ $game->description }}</p>
                    
                    <!-- Game Stats -->
                    <div class="flex items-center justify-between mb-6">
                        <span class="px-4 py-2 bg-secondary text-gray-800 text-sm font-semibold rounded-2xl">
                            {{ $game->game_type_display }}
                        </span>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <span class="mr-1">👥</span>
                                <span>{{ $game->total_plays }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-1">⭐</span>
                                <span>{{ number_format($game->average_score, 1) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar (if user has played this game) -->
                    @auth
                    @php
                        $userSession = $recentSessions?->where('game_id', $game->id)->first();
                    @endphp
                    @if($userSession)
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span class="font-medium">Progress</span>
                            <span class="font-bold">{{ $userSession->completion_percentage }}%</span>
                        </div>
                        <div class="w-full bg-quaternary rounded-full h-3">
                            <div class="bg-primary h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $userSession->completion_percentage }}%"></div>
                        </div>
                    </div>
                    @endif
                    @endauth

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ route('game.show', $game->slug) }}" 
                           class="flex-1 bg-quaternary hover:bg-gray-300 text-gray-800 text-center py-3 px-6 rounded-2xl font-semibold transition-all duration-200 flex items-center justify-center">
                            <span class="mr-2">📖</span>
                            Info
                        </a>
                        <a href="{{ route('game.play', $game->slug) }}" 
                           class="flex-1 bg-primary hover:bg-blue-600 text-white text-center py-3 px-6 rounded-2xl font-semibold transition-all duration-200 flex items-center justify-center">
                            <span class="mr-2">🎮</span>
                            Main
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <div class="w-24 h-24 bg-quaternary rounded-3xl flex items-center justify-center text-6xl mx-auto mb-8">
                    🎮
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Game Tersedia</h3>
                <p class="text-gray-600 text-lg">Game edukatif akan segera hadir!</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <!-- Pagination -->
        @if($games->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $games->links() }}
        </div>
        @endif

        <!-- Game Categories Section -->
        <div class="mt-20 bg-quaternary rounded-3xl p-12">
            <div class="text-center mb-12">
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                    📚
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Kategori Permainan</h2>
                <p class="text-gray-600 text-lg">Pilih jenis permainan yang Anda sukai</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <div class="text-center p-6 bg-white rounded-2xl hover:shadow-lg transition-all duration-200 cursor-pointer">
                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🕰️</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Time Travel</h3>
                    <p class="text-gray-600 text-sm">Petualangan waktu interaktif</p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl hover:shadow-lg transition-all duration-200 cursor-pointer">
                    <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🧩</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Geography Puzzle</h3>
                    <p class="text-gray-600 text-sm">Puzzle peta Indonesia</p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl hover:shadow-lg transition-all duration-200 cursor-pointer">
                    <div class="w-16 h-16 bg-tertiary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🔍</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Historical Detective</h3>
                    <p class="text-gray-600 text-sm">Investigasi misteri sejarah</p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl hover:shadow-lg transition-all duration-200 cursor-pointer">
                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🏝️</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Island Explorer</h3>
                    <p class="text-gray-600 text-sm">Eksplorasi nusantara</p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl hover:shadow-lg transition-all duration-200 cursor-pointer">
                    <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🧠</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Memory Palace</h3>
                    <p class="text-gray-600 text-sm">Teknik memori canggih</p>
                </div>
            </div>
        </div>

        <!-- Call to Action for Guests -->
        @guest
        <div class="mt-20 bg-primary rounded-3xl p-12 text-center">
            <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center text-4xl mx-auto mb-8">
                🚀
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Mulai Petualangan Belajar Anda!</h2>
            <p class="text-lg text-blue-100 mb-10 max-w-2xl mx-auto">
                Daftar sekarang untuk melacak progress dan membuka achievement khusus
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-lg mx-auto">
                <a href="{{ route('register') }}" 
                   class="bg-white text-primary px-8 py-4 rounded-2xl font-bold hover:bg-gray-50 transition-all duration-200 text-center flex items-center justify-center">
                    <span class="mr-2">📝</span>
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-secondary text-gray-800 px-8 py-4 rounded-2xl font-bold hover:bg-tertiary transition-all duration-200 text-center flex items-center justify-center">
                    <span class="mr-2">🔐</span>
                    Masuk
                </a>
            </div>
        </div>
        @endguest

    </div>
</div>

@push('scripts')
<script>
// Smooth scroll animations
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Animate cards and sections
    document.querySelectorAll('.bg-white, .bg-quaternary, .bg-primary').forEach((element) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(element);
    });

    // Add hover effects to interactive elements
    document.querySelectorAll('[class*="hover:"]').forEach((element) => {
        element.style.transition = 'all 0.2s ease';
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

/* Responsive grid adjustments */
@media (max-width: 640px) {
    .grid-cols-1 {
        gap: 1rem;
    }
}

/* Enhanced focus states for accessibility */
a:focus,
button:focus {
    outline: 2px solid #3396D3;
    outline-offset: 2px;
}
</style>
@endpush
@endsection

@php
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
