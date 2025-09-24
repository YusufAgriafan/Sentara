@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary via-secondary to-quaternary/60 text-white">
    <!-- Game Header -->
    <div class="bg-black bg-opacity-30 backdrop-blur-sm border-b border-primary/50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('game.index') }}" class="text-red-200 hover:text-white transition-colors text-sm sm:text-base">
                        ← Kembali ke Games
                    </a>
                    <h1 class="text-lg sm:text-2xl font-bold">🧠 {{ $game->title }}</h1>
                </div>
            <div class="flex items-center space-x-6 text-sm">
                <div class="flex items-center space-x-2">
                    <span class="text-red-200">Memori:</span>
                    <span id="memory-strength" class="font-bold">0%</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-red-200">Waktu:</span>
                    <span id="game-timer" class="font-bold">00:00</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-red-200">Ruang:</span>
                    <span id="current-room" class="font-bold">Entrance</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8 text-center">
        <div class="bg-black bg-opacity-40 rounded-2xl shadow-2xl border border-primary/50 p-12">
            <div class="text-8xl mb-6">🧠</div>
            <h2 class="text-4xl font-bold mb-6 text-red-200">Memory Palace</h2>
            <p class="text-xl text-red-100 mb-8 max-w-3xl mx-auto">
                Sistem latihan memori canggih sedang dalam tahap pengembangan. 
                Segera Anda akan dapat membangun istana memori dan menguasai teknik mnemonic terbaik!
            </p>
            
            <!-- Palace Rooms Preview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($game->settings['palace_rooms'] as $roomKey => $roomName)
                <div class="bg-primary/20 rounded-xl p-6 border border-primary/40">
                    <div class="text-4xl mb-3">
                        @switch($roomKey)
                            @case('entrance_hall')
                                🚪
                                @break
                            @case('history_wing')
                                📜
                                @break
                            @case('geography_hall')
                                🗺️
                                @break
                            @case('culture_room')
                                🎭
                                @break
                            @case('modern_section')
                                🏢
                                @break
                            @default
                                🏛️
                        @endswitch
                    </div>
                    <h3 class="font-bold text-indigo-300 mb-2">{{ str_replace('_', ' ', ucwords($roomKey, '_')) }}</h3>
                    <p class="text-indigo-200 text-sm">{{ $roomName }}</p>
                </div>
                @endforeach
            </div>

            <!-- Memory Techniques Preview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($game->settings['memory_techniques'] as $technique)
                <div class="bg-purple-600 bg-opacity-20 rounded-xl p-6 border border-purple-400">
                    <div class="text-3xl mb-3">
                        @switch($technique)
                            @case('method_of_loci')
                                🏛️
                                @break
                            @case('acronym_system')
                                🔤
                                @break
                            @case('story_method')
                                📖
                                @break
                            @case('image_association')
                                🖼️
                                @break
                            @default
                                🧠
                        @endswitch
                    </div>
                    <h3 class="font-bold text-purple-300 mb-2">{{ str_replace('_', ' ', ucwords($technique, '_')) }}</h3>
                    <p class="text-purple-200 text-sm">
                        @switch($technique)
                            @case('method_of_loci')
                                Teknik klasik menggunakan lokasi familiar untuk mengingat
                            @break
                            @case('acronym_system')
                                Sistem akronim untuk menghafal daftar dan urutan
                            @break
                            @case('story_method')
                                Membuat cerita untuk menghubungkan informasi
                            @break
                            @case('image_association')
                                Menggunakan visualisasi dan asosiasi gambar
                            @break
                        @endswitch
                    </p>
                </div>
                @endforeach
            </div>

            <!-- Advanced Features -->
            <div class="bg-pink-600 bg-opacity-20 rounded-xl p-6 border border-pink-400 mb-8">
                <h3 class="text-2xl font-bold text-pink-300 mb-4">🚧 Fitur Canggih yang Akan Datang:</h3>
                <ul class="text-left text-pink-200 space-y-2 max-w-2xl mx-auto">
                    <li class="flex items-center space-x-2">
                        <span class="text-pink-400">•</span>
                        <span>3D visualization istana memori dengan teknologi WebGL</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-pink-400">•</span>
                        <span>Spaced repetition algorithm untuk optimasi pembelajaran</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-pink-400">•</span>
                        <span>Daily challenges untuk konsistensi latihan</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-pink-400">•</span>
                        <span>Progress tracking dengan analytics mendalam</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-pink-400">•</span>
                        <span>Personalized memory training berdasarkan gaya belajar</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-pink-400">•</span>
                        <span>Voice-guided meditation untuk fokus memori</span>
                    </li>
                </ul>
            </div>

            <!-- Memory Stats Preview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-indigo-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-indigo-300">0</div>
                    <div class="text-sm text-indigo-200">Items Memorized</div>
                </div>
                <div class="bg-purple-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-purple-300">0%</div>
                    <div class="text-sm text-purple-200">Retention Rate</div>
                </div>
                <div class="bg-pink-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-pink-300">0</div>
                    <div class="text-sm text-pink-200">Days Streak</div>
                </div>
                <div class="bg-blue-800 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-300">0</div>
                    <div class="text-sm text-blue-200">Techniques Mastered</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-x-4">
                <a href="{{ route('game.index') }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 px-8 py-3 rounded-xl font-semibold transition-all inline-block">
                    🏠 Kembali ke Menu
                </a>
                <a href="{{ route('game.play', 'geography-puzzle') }}" 
                   class="bg-green-600 hover:bg-green-700 px-8 py-3 rounded-xl font-semibold transition-all inline-block">
                    🧩 Coba Geography Puzzle
                </a>
            </div>
        </div>
    </div>
</div>
@endsection