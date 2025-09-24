@ext    <!-- Game Header -->
    <div class="bg-black bg-opacity-30 backdrop-blur-sm border-b border-primary/50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('game.index') }}" class="text-red-200 hover:text-white transition-colors text-sm sm:text-base">
                        ← Kembali ke Games
                    </a>
                    <h1 class="text-lg sm:text-2xl font-bold">🏖️ {{ $game->title }}</h1>
                </div>outs.main')

@s    <div class="max-w-6xl mx-auto px-4 py-4 md:py-8 text-center">
        <div class="bg-black bg-opacity-40 rounded-xl md:rounded-2xl shadow-2xl border border-primary/50 p-6 md:p-12">
            <div class="text-6xl md:text-8xl mb-6">🏖️</div>
            <h2 class="text-2xl md:text-4xl font-bold mb-4 md:mb-6 text-red-200">Island Explorer</h2>
            <p class="text-base md:text-xl text-red-100 mb-6 md:mb-8 max-w-3xl mx-auto px-4">
                Petualangan eksplorasi Nusantara sedang dalam tahap pengembangan. 
                Segera Anda akan dapat menjelajahi keindahan dan keunikan setiap pulau di Indonesia!
            </p>
            
            <!-- Islands Preview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">tent')
<div class="min-h-screen bg-gradient-to-br from-primary via-secondary to-quaternary/60 text-white">
    <!-- Game Header -->
    <div class="bg-black bg-opacity-30 backdrop-blur-sm border-b border-primary/50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('game.index') }}" class="text-red-200 hover:text-white transition-colors">
                    ← Kembali ke Games
                </a>
                <h1 class="text-2xl font-bold">🏝️ {{ $game->title }}</h1>
            </div>
            <div class="flex items-center space-x-6 text-sm">
                <div class="flex items-center space-x-2">
                    <span class="text-teal-300">Artefak:</span>
                    <span id="artifacts-collected" class="font-bold">0</span>/<span>{{ $game->settings['collection_goal'] }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-teal-300">Waktu:</span>
                    <span id="game-timer" class="font-bold">00:00</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-teal-300">Pulau:</span>
                    <span id="current-island" class="font-bold">Jawa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8 text-center">
        <div class="bg-black bg-opacity-40 rounded-2xl shadow-2xl border border-primary/50 p-12">
            <div class="text-8xl mb-6">🏝️</div>
            <h2 class="text-4xl font-bold mb-6 text-red-200">Island Explorer</h2>
            <p class="text-xl text-red-100 mb-8 max-w-3xl mx-auto">
                Petualangan eksplorasi Nusantara sedang dalam tahap pengembangan. 
                Segera Anda akan dapat menjelajahi keindahan dan keunikan setiap pulau di Indonesia!
            </p>
            
            <!-- Islands Preview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach($game->settings['islands'] as $island)
                <div class="bg-teal-600 bg-opacity-20 rounded-xl p-6 border border-teal-400">
                    <div class="text-4xl mb-3">
                        @switch($island['name'])
                            @case('Jawa')
                                🏛️
                                @break
                            @case('Bali')
                                🛕
                                @break
                            @case('Sumatera')
                                🌋
                                @break
                            @default
                                🏝️
                        @endswitch
                    </div>
                    <h3 class="font-bold text-teal-300 mb-2">Pulau {{ $island['name'] }}</h3>
                    <p class="text-teal-200 text-sm mb-3">{{ $island['artifacts'] }} Artefak Budaya</p>
                    <div class="text-xs text-teal-100">
                        <div>Mini-games: {{ count($island['mini_games']) }}</div>
                        <div>Situs: {{ count($island['cultural_sites']) }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Features Preview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                <div class="bg-secondary/20 rounded-xl p-4 md:p-6 border border-secondary/40">
                    <div class="text-2xl md:text-3xl mb-3">🗺️</div>
                    <h3 class="font-bold text-red-200 mb-2 text-sm md:text-base">Interactive Map</h3>
                    <p class="text-red-100 text-xs md:text-sm">Jelajahi peta Indonesia dengan detail setiap pulau</p>
                </div>
                <div class="bg-secondary/20 rounded-xl p-6 border border-secondary/40">
                    <div class="text-3xl mb-3">🏺</div>
                    <h3 class="font-bold text-red-200 mb-2">Collect Artifacts</h3>
                    <p class="text-red-100 text-sm">Kumpulkan artefak budaya dari setiap daerah</p>
                </div>
                <div class="bg-secondary/20 rounded-xl p-6 border border-secondary/40">
                    <div class="text-3xl mb-3">🎮</div>
                    <h3 class="font-bold text-red-200 mb-2">Mini-Games</h3>
                    <p class="text-red-100 text-sm">Berbagai mini-games unik untuk setiap pulau</p>
                </div>
                <div class="bg-secondary/20 rounded-xl p-6 border border-secondary/40">
                    <div class="text-3xl mb-3">📚</div>
                    <h3 class="font-bold text-red-200 mb-2">Cultural Learning</h3>
                    <p class="text-red-100 text-sm">Pelajari budaya dan sejarah setiap daerah</p>
                </div>
            </div>

            <!-- Coming Soon Features -->
            <div class="bg-tertiary/20 rounded-xl p-6 border border-tertiary/40 mb-8">
                <h3 class="text-2xl font-bold text-orange-200 mb-4">🚧 Fitur yang Akan Datang:</h3>
                <ul class="text-left text-orange-100 space-y-2 max-w-2xl mx-auto">
                    <li class="flex items-center space-x-2">
                        <span class="text-tertiary">•</span>
                        <span>Eksplorasi virtual Candi Borobudur dan Prambanan</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-tertiary">•</span>
                        <span>Mini-game Batik Pattern di Pulau Jawa</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-tertiary">•</span>
                        <span>Petualangan Danau Toba di Sumatera Utara</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-tertiary">•</span>
                        <span>Ritual persembahan virtual di Bali</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-tertiary">•</span>
                        <span>Collection system dengan museum virtual</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
                <a href="{{ route('game.index') }}" 
                   class="bg-primary hover:bg-secondary px-6 md:px-8 py-3 rounded-xl font-semibold transition-all text-center text-sm md:text-base">
                    🏠 Kembali ke Menu
                </a>
                <a href="{{ route('game.play', 'time-travel-adventure') }}" 
                   class="bg-secondary hover:bg-primary px-6 md:px-8 py-3 rounded-xl font-semibold transition-all text-center text-sm md:text-base">
                    🕰️ Coba Time Travel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection