@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-white text-gray-800">
    <!-- Game Header -->
    <div class="bg-primary shadow-lg border-b-4 border-white">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-3 lg:space-y-0">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('game.index') }}" class="text-white hover:text-secondary transition-colors text-sm lg:text-base bg-white/20 px-3 py-1 rounded-lg">
                        ← Kembali ke Games
                    </a>
                    <h1 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                        <span class="text-2xl mr-2">🧩</span>
                        {{ $game->title }}
                    </h1>
                </div>
                <div class="flex items-center space-x-6 text-sm lg:text-base">
                    <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                        <span class="text-secondary">📊 Skor:</span>
                        <span id="current-score" class="font-bold text-white">{{ $session->score }}</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                        <span class="text-secondary">⏱️ Waktu:</span>
                        <span id="game-timer" class="font-bold text-white">00:00</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                        <span class="text-secondary">🎯 Level:</span>
                        <span id="current-level" class="font-bold text-white">1</span>/<span class="text-secondary">{{ count($game->settings['levels']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-4 md:py-8">
        <!-- Game Progress -->
        <div class="mb-6 lg:mb-8">
            <div class="flex justify-between items-center text-sm lg:text-base text-gray-700 mb-3">
                <div class="flex items-center space-x-2">
                    <span class="text-primary font-semibold">📈 Progress Level</span>
                    <span class="text-gray-500">•</span>
                    <span id="progress-text" class="font-semibold text-tertiary">0/5</span>
                </div>
                <span id="progress-percentage" class="text-primary font-bold">0%</span>
            </div>
            <div class="w-full bg-quaternary rounded-full h-3 lg:h-4 shadow-inner border border-gray-300">
                <div id="progress-bar" class="bg-primary h-3 lg:h-4 rounded-full transition-all duration-700 ease-in-out shadow-sm" style="width: 0%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 lg:gap-8">
            <!-- Game Area -->
            <div class="xl:col-span-3 order-2 xl:order-1">
                <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-4 lg:p-6">
                    <!-- Level Introduction -->
                    <div id="level-intro" class="text-center">
                        <h2 class="text-xl lg:text-2xl font-bold mb-4 text-primary flex items-center justify-center">
                            <span class="text-3xl mr-3">🗺️</span>
                            Puzzle Peta Nusantara
                        </h2>
                        <p class="text-gray-700 mb-6 text-sm lg:text-base">
                            Susun potongan-potongan peta Indonesia dengan benar! Semakin cepat Anda menyelesaikan, semakin tinggi skor yang didapat.
                        </p>
                        <button id="start-puzzle" class="bg-primary hover:bg-blue-600 text-white px-6 lg:px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                            🚀 Mulai Puzzle
                        </button>
                    </div>

                    <!-- Puzzle Game Area -->
                    <div id="puzzle-area" class="hidden">
                        <!-- Level Info -->
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0 mb-6">
                            <h3 id="level-title" class="text-lg lg:text-xl font-bold text-primary"></h3>
                            <div class="flex items-center space-x-2 sm:space-x-4">
                                <div id="time-limit" class="bg-secondary px-2 lg:px-3 py-1 rounded-lg text-sm lg:text-base text-gray-800 border border-yellow-200">
                                    ⏱️ <span id="countdown">00:00</span>
                                </div>
                                <button id="hint-button" class="bg-tertiary hover:bg-yellow-500 px-2 lg:px-3 py-1 rounded-lg transition-colors text-sm lg:text-base text-gray-800 border border-yellow-300">
                                    💡 Hint (<span id="hint-count">3</span>)
                                </button>
                            </div>
                        </div>

                        <!-- Puzzle Container -->
                        <div class="relative">
                            <!-- Drop Zone (Map Outline) -->
                            <div id="drop-zone" class="relative w-full bg-quaternary border-2 border-dashed border-primary rounded-xl p-3 lg:p-4 min-h-64 lg:min-h-96">
                                <div class="absolute inset-0 flex items-center justify-center text-gray-600 pointer-events-none">
                                    <span id="drop-instruction" class="text-sm lg:text-base text-center px-4">Seret potongan peta ke sini</span>
                                </div>
                                <!-- Correct positions will be generated by JavaScript -->
                            </div>

                            <!-- Puzzle Pieces Container -->
                            <div id="puzzle-pieces" class="mt-4 lg:mt-6 bg-secondary rounded-xl p-3 lg:p-4 border border-yellow-200">
                                <h4 class="text-gray-800 font-semibold mb-3 text-sm lg:text-base">Potongan Peta:</h4>
                                <div id="pieces-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2 lg:gap-3">
                                    <!-- Pieces will be generated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-4 mt-4 lg:mt-6">
                            <button id="reset-puzzle" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors text-sm lg:text-base">
                                🔄 Reset
                            </button>
                            <button id="check-answer" class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors text-sm lg:text-base">
                                ✅ Periksa Jawaban
                            </button>
                        </div>
                    </div>

                    <!-- Level Complete -->
                    <div id="level-complete" class="hidden text-center animate-fade-in">
                        <div class="mb-6">
                            <h3 class="text-2xl lg:text-3xl font-bold text-green-300 mb-2 animate-bounce">🎉 Level Selesai!</h3>
                            <p class="text-green-200 text-sm lg:text-base">Selamat! Anda berhasil menyelesaikan level ini.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                            <div class="bg-gradient-to-br from-green-700 to-green-800 rounded-xl p-4 lg:p-6 shadow-lg border border-green-600 transform hover:scale-105 transition-all">
                                <div class="text-2xl lg:text-3xl font-bold text-white mb-1" id="level-score">0</div>
                                <div class="text-xs lg:text-sm text-green-300">Skor Level</div>
                            </div>
                            <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-4 lg:p-6 shadow-lg border border-blue-600 transform hover:scale-105 transition-all">
                                <div class="text-2xl lg:text-3xl font-bold text-white mb-1" id="level-time">00:00</div>
                                <div class="text-xs lg:text-sm text-blue-300">Waktu</div>
                            </div>
                            <div class="bg-gradient-to-br from-purple-700 to-purple-800 rounded-xl p-4 lg:p-6 shadow-lg border border-purple-600 transform hover:scale-105 transition-all">
                                <div class="text-2xl lg:text-3xl font-bold text-white mb-1" id="accuracy">100%</div>
                                <div class="text-xs lg:text-sm text-purple-300">Akurasi</div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <button id="next-level" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 px-6 lg:px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                                ➡️ Level Selanjutnya
                            </button>
                            <button id="view-info" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 px-6 lg:px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                                📚 Info Daerah
                            </button>
                        </div>
                    </div>

                    <!-- Game Complete -->
                    <div id="game-complete" class="hidden text-center animate-fade-in">
                        <div class="mb-6">
                            <h2 class="text-3xl lg:text-4xl font-bold text-yellow-300 mb-4 animate-pulse">🏆 Semua Level Selesai!</h2>
                            <p class="text-green-200 mb-6 text-sm lg:text-base">Selamat! Anda telah menguasai peta Indonesia!</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                            <div class="bg-gradient-to-br from-yellow-600 to-yellow-700 rounded-xl p-4 lg:p-6 shadow-xl border border-yellow-500 transform hover:scale-105 transition-all">
                                <div class="text-2xl lg:text-3xl font-bold text-white mb-1" id="final-score">0</div>
                                <div class="text-xs lg:text-sm text-yellow-200">Skor Total</div>
                            </div>
                            <div class="bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl p-4 lg:p-6 shadow-xl border border-orange-500 transform hover:scale-105 transition-all">
                                <div class="text-2xl lg:text-3xl font-bold text-white mb-1" id="final-time">00:00</div>
                                <div class="text-xs lg:text-sm text-orange-200">Total Waktu</div>
                            </div>
                            <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-xl p-4 lg:p-6 shadow-xl border border-red-500 transform hover:scale-105 transition-all">
                                <div class="text-2xl lg:text-3xl font-bold text-white mb-1" id="final-rank">-</div>
                                <div class="text-xs lg:text-sm text-red-200">Peringkat</div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <button id="play-again" class="bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 px-6 lg:px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                                🔄 Main Lagi
                            </button>
                            <a href="{{ route('game.index') }}" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 px-6 lg:px-8 py-3 rounded-xl font-semibold transition-all inline-block transform hover:scale-105 shadow-lg">
                                🏠 Kembali ke Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="xl:col-span-1 order-1 xl:order-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-4 lg:gap-6">
                    <!-- Level Info -->
                    <div class="bg-primary/40 rounded-xl border border-secondary/30 p-4 backdrop-blur-sm">
                        <h3 class="text-base lg:text-lg font-bold mb-4 text-quaternary">📊 Info Level</h3>
                        <div id="level-details" class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-white/80 text-sm lg:text-base">Level:</span>
                                <span id="sidebar-level" class="font-semibold text-white text-sm lg:text-base">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-white/80 text-sm lg:text-base">Potongan:</span>
                                <span id="sidebar-pieces" class="font-semibold text-white text-sm lg:text-base">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-white/80 text-sm lg:text-base">Batas Waktu:</span>
                                <span id="sidebar-time" class="font-semibold text-white text-sm lg:text-base">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Province Info -->
                    <div id="province-info" class="bg-primary/40 rounded-xl border border-secondary/30 p-4 backdrop-blur-sm hidden">
                        <h3 class="text-base lg:text-lg font-bold mb-4 text-quaternary">🗺️ Info Provinsi</h3>
                        <div id="selected-province" class="space-y-2">
                            <div class="flex justify-between items-start">
                                <span class="text-white/80 text-sm lg:text-base">Nama:</span>
                                <span id="province-name" class="font-semibold text-white text-sm lg:text-base text-right">-</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-white/80 text-sm lg:text-base">Ibukota:</span>
                                <span id="province-capital" class="font-semibold text-white text-sm lg:text-base text-right">-</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-white/80 text-sm lg:text-base">Pulau:</span>
                                <span id="province-island" class="font-semibold text-white text-sm lg:text-base text-right">-</span>
                            </div>
                            <div class="mt-3 pt-3 border-t border-secondary/40">
                                <p id="province-description" class="text-xs lg:text-sm text-white/90 leading-relaxed"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-black bg-opacity-40 rounded-xl border border-primary/30 p-4 backdrop-blur-sm">
                        <h3 class="text-base lg:text-lg font-bold mb-4 text-yellow-300">📖 Cara Bermain</h3>
                        <ul class="space-y-2 text-green-200 text-xs lg:text-sm">
                            <li class="flex items-start space-x-2">
                                <span class="text-green-400 mt-1">•</span>
                                <span>Seret potongan peta ke posisi yang tepat</span>
                            </li>
                            <li class="flex items-start space-x-2 sm:hidden">
                                <span class="text-blue-400 mt-1">•</span>
                                <span>Di mobile: tap piece lalu tap slot untuk menempatkan</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-green-400 mt-1">•</span>
                                <span>Gunakan hint jika kesulitan (terbatas)</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-tertiary mt-1">•</span>
                                <span>Semakin cepat selesai, semakin tinggi skor</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-tertiary mt-1">•</span>
                                <span>Pelajari info provinsi setelah selesai</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Leaderboard -->
                    <div class="bg-primary/40 rounded-xl border border-secondary/30 p-4 backdrop-blur-sm">
                        <h3 class="text-base lg:text-lg font-bold mb-4 text-quaternary">🏆 Papan Skor</h3>
                        <div id="leaderboard" class="space-y-2">
                            <div class="text-center text-white/80 text-xs lg:text-sm animate-pulse">Memuat data...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
class GeographyPuzzle {
    constructor() {
        this.gameData = @json($game->settings);
        this.sessionData = @json($session);
        this.currentLevel = 0;
        this.score = {{ $session->score }};
        this.startTime = new Date();
        this.levelStartTime = null;
        this.timer = null;
        this.countdownTimer = null;
        this.hintsUsed = 0;
        this.maxHints = 3;
        this.selectedPiece = null; // For mobile support
        
        this.provinceData = {
            'Jawa Barat': { capital: 'Bandung', island: 'Jawa', description: 'Provinsi dengan populasi terbesar di Indonesia, terkenal dengan industri tekstil dan pariwisata.' },
            'Jawa Tengah': { capital: 'Semarang', island: 'Jawa', description: 'Terkenal dengan budaya Jawa yang kental, Candi Borobudur, dan batik Solo.' },
            'Jawa Timur': { capital: 'Surabaya', island: 'Jawa', description: 'Pusat industri nasional dengan Gunung Bromo dan Malioboro yang terkenal.' },
            'DKI Jakarta': { capital: 'Jakarta', island: 'Jawa', description: 'Ibukota negara dan pusat bisnis serta ekonomi Indonesia.' },
            'Banten': { capital: 'Serang', island: 'Jawa', description: 'Bekas wilayah Kesultanan Banten dengan Pantai Anyer yang indah.' },
            'DI Yogyakarta': { capital: 'Yogyakarta', island: 'Jawa', description: 'Daerah Istimewa dan kota pelajar dengan Malioboro dan Kraton.' },
            'Sumatera Utara': { capital: 'Medan', island: 'Sumatera', description: 'Terkenal dengan Danau Toba terbesar di Asia Tenggara dan budaya Batak.' },
            'Sumatera Barat': { capital: 'Padang', island: 'Sumatera', description: 'Tanah Minang dengan masakan Padang dan Jam Gadang yang ikonik.' },
            'Riau': { capital: 'Pekanbaru', island: 'Sumatera', description: 'Pusat industri minyak dan gas dengan budaya Melayu yang kaya.' },
            'Kalimantan Timur': { capital: 'Samarinda', island: 'Kalimantan', description: 'Kaya akan minyak, gas alam, dan hutan tropis yang lebat.' },
            'Sulawesi Selatan': { capital: 'Makassar', island: 'Sulawesi', description: 'Terkenal dengan suku Bugis dan Makassar, serta kuliner Coto dan Pallubasa.' },
            'Bali': { capital: 'Denpasar', island: 'Bali', description: 'Pulau dewata dengan budaya Hindu yang unik dan pariwisata dunia.' }
        };
        
        this.currentPuzzleData = null;
        this.placedPieces = new Map();
        this.init();
    }
    
    init() {
        this.startTimer();
        this.setupEventListeners();
        this.loadLeaderboard();
        this.updateUI();
    }
    
    startTimer() {
        this.timer = setInterval(() => {
            const elapsed = Math.floor((new Date() - this.startTime) / 1000);
            const minutes = Math.floor(elapsed / 60);
            const seconds = elapsed % 60;
            document.getElementById('game-timer').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }, 1000);
    }
    
    setupEventListeners() {
        document.getElementById('start-puzzle').addEventListener('click', () => {
            this.startLevel(0);
        });
        
        document.getElementById('hint-button').addEventListener('click', () => {
            this.useHint();
        });
        
        document.getElementById('reset-puzzle').addEventListener('click', () => {
            this.resetPuzzle();
        });
        
        document.getElementById('check-answer').addEventListener('click', () => {
            this.checkAnswer();
        });
        
        document.getElementById('next-level').addEventListener('click', () => {
            this.nextLevel();
        });
        
        document.getElementById('play-again').addEventListener('click', () => {
            this.resetGame();
        });
    }
    
    startLevel(levelIndex) {
        this.currentLevel = levelIndex;
        const level = this.gameData.levels[levelIndex];
        
        if (!level) {
            this.completeGame();
            return;
        }
        
        this.levelStartTime = new Date();
        this.hintsUsed = 0;
        this.placedPieces.clear();
        
        document.getElementById('level-intro').classList.add('hidden');
        document.getElementById('level-complete').classList.add('hidden');
        
        document.getElementById('current-level').textContent = levelIndex + 1;
        document.getElementById('level-title').textContent = level.name;
        document.getElementById('hint-count').textContent = this.maxHints;
        
        // Update sidebar
        document.getElementById('sidebar-level').textContent = level.name;
        document.getElementById('sidebar-pieces').textContent = level.pieces;
        document.getElementById('sidebar-time').textContent = this.formatTime(level.time_limit);
        
        this.setupPuzzle(level);
        this.startCountdown(level.time_limit);
        
        document.getElementById('puzzle-area').classList.remove('hidden');
        this.updateProgress();
    }
    
    setupPuzzle(level) {
        const dropZone = document.getElementById('drop-zone');
        const piecesContainer = document.getElementById('pieces-container');
        
        // Clear existing content
        dropZone.innerHTML = '<div class="absolute inset-0 flex items-center justify-center text-green-300 pointer-events-none"><span id="drop-instruction">Seret potongan peta ke sini</span></div>';
        piecesContainer.innerHTML = '';
        
        // Create puzzle pieces
        const pieces = this.generatePuzzlePieces(level);
        this.currentPuzzleData = pieces;
        
        pieces.forEach((piece, index) => {
            const pieceElement = this.createPuzzlePiece(piece, index);
            piecesContainer.appendChild(pieceElement);
        });
        
        // Create drop zones
        this.createDropZones(level, dropZone);
        
        // Setup drag and drop
        this.setupDragAndDrop();
    }
    
    generatePuzzlePieces(level) {
        const pieces = [];
        const provinces = Object.keys(this.provinceData).slice(0, level.pieces);
        
        provinces.forEach((province, index) => {
            pieces.push({
                id: `piece-${index}`,
                name: province,
                correctPosition: index,
                data: this.provinceData[province]
            });
        });
        
        // Shuffle pieces
        return pieces.sort(() => Math.random() - 0.5);
    }
    
    createPuzzlePiece(piece, index) {
        const pieceDiv = document.createElement('div');
        pieceDiv.className = 'puzzle-piece bg-gradient-to-br from-primary via-secondary to-quaternary/80 rounded-lg p-3 border-2 border-primary/50 hover:border-primary/80 transition-all transform hover:scale-105 shadow-lg cursor-grab';
        pieceDiv.draggable = true;
        pieceDiv.dataset.pieceId = piece.id;
        pieceDiv.dataset.provinceName = piece.name;
        pieceDiv.dataset.correctPosition = piece.correctPosition;
        pieceDiv.innerHTML = `
            <div class="text-center">
                <div class="text-sm lg:text-base font-bold text-white mb-1">${piece.name}</div>
                <div class="text-xs text-green-200">${piece.data.capital}</div>
                <div class="text-xs text-blue-200 mt-1">${piece.data.island}</div>
            </div>
        `;
        
        // Add click event for mobile devices
        pieceDiv.addEventListener('click', () => {
            if (this.selectedPiece === pieceDiv) {
                this.selectedPiece = null;
                pieceDiv.classList.remove('ring-2', 'ring-yellow-400');
            } else {
                // Remove previous selection
                if (this.selectedPiece) {
                    this.selectedPiece.classList.remove('ring-2', 'ring-yellow-400');
                }
                this.selectedPiece = pieceDiv;
                pieceDiv.classList.add('ring-2', 'ring-yellow-400');
            }
        });
        
        return pieceDiv;
    }
    
    createDropZones(level, container) {
        const dropZonesContainer = document.createElement('div');
        const cols = level.pieces <= 4 ? 2 : level.pieces <= 6 ? 3 : 4;
        dropZonesContainer.className = `grid grid-cols-2 sm:grid-cols-${cols} gap-3 lg:gap-4 h-full min-h-64 lg:min-h-80`;
        
        for (let i = 0; i < level.pieces; i++) {
            const dropZone = document.createElement('div');
            dropZone.className = 'drop-zone-slot bg-blue-800/20 border-2 border-dashed border-blue-400/50 rounded-lg flex items-center justify-center min-h-16 lg:min-h-20 transition-all hover:border-blue-400/80 hover:bg-blue-800/30';
            dropZone.dataset.slotId = i;
            dropZone.innerHTML = `<span class="text-blue-300 text-xs lg:text-sm font-semibold">Slot ${i + 1}</span>`;
            
            // Add click event for mobile support
            dropZone.addEventListener('click', () => {
                if (this.selectedPiece && !dropZone.hasAttribute('data-occupied-by')) {
                    this.placePiece(this.selectedPiece, dropZone);
                    this.selectedPiece.classList.remove('ring-2', 'ring-yellow-400');
                    this.selectedPiece = null;
                }
            });
            
            dropZonesContainer.appendChild(dropZone);
        }
        
        container.appendChild(dropZonesContainer);
    }
    
    setupDragAndDrop() {
        const pieces = document.querySelectorAll('.puzzle-piece');
        const dropSlots = document.querySelectorAll('.drop-zone-slot');
        
        pieces.forEach(piece => {
            piece.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', piece.dataset.pieceId);
                piece.style.opacity = '0.6';
                piece.classList.add('dragging');
            });
            
            piece.addEventListener('dragend', () => {
                piece.style.opacity = '1';
                piece.classList.remove('dragging');
            });
            
            // Show province info on hover/click
            piece.addEventListener('mouseenter', () => {
                this.showProvinceInfo(piece.dataset.provinceName);
            });
        });
        
        dropSlots.forEach(slot => {
            slot.addEventListener('dragover', (e) => {
                e.preventDefault();
                slot.classList.add('drag-over');
            });
            
            slot.addEventListener('dragleave', (e) => {
                // Only remove drag-over if we're actually leaving the slot
                if (!slot.contains(e.relatedTarget)) {
                    slot.classList.remove('drag-over');
                }
            });
            
            slot.addEventListener('drop', (e) => {
                e.preventDefault();
                slot.classList.remove('drag-over');
                
                const pieceId = e.dataTransfer.getData('text/plain');
                const piece = document.querySelector(`[data-piece-id="${pieceId}"]`);
                
                if (piece) {
                    this.placePiece(piece, slot);
                }
            });
        });
    }
    
    placePiece(piece, slot) {
        // Remove piece from previous slot if any
        const previousSlot = document.querySelector(`.drop-zone-slot[data-occupied-by="${piece.dataset.pieceId}"]`);
        if (previousSlot) {
            const slotId = previousSlot.dataset.slotId;
            previousSlot.innerHTML = `<span class="text-blue-300 text-xs lg:text-sm font-semibold">Slot ${parseInt(slotId) + 1}</span>`;
            previousSlot.removeAttribute('data-occupied-by');
            this.placedPieces.delete(parseInt(slotId));
        }
        
        // Check if slot is already occupied
        if (slot.hasAttribute('data-occupied-by')) {
            const occupyingPieceId = slot.getAttribute('data-occupied-by');
            const occupyingPiece = document.querySelector(`[data-piece-id="${occupyingPieceId}"]`);
            if (occupyingPiece) {
                // Move occupying piece back to pieces container
                const piecesContainer = document.getElementById('pieces-container');
                occupyingPiece.classList.remove('ring-2', 'ring-yellow-400');
                piecesContainer.appendChild(occupyingPiece);
                this.placedPieces.delete(parseInt(slot.dataset.slotId));
            }
        }
        
        // Create a copy of the piece for the slot
        const pieceClone = piece.cloneNode(true);
        pieceClone.classList.add('animate-fade-in');
        pieceClone.draggable = false;
        
        // Add click handler to remove piece
        pieceClone.addEventListener('click', () => {
            const piecesContainer = document.getElementById('pieces-container');
            const originalPiece = this.createPuzzlePiece(
                this.currentPuzzleData.find(p => p.id === piece.dataset.pieceId),
                0
            );
            piecesContainer.appendChild(originalPiece);
            
            slot.innerHTML = `<span class="text-blue-300 text-xs lg:text-sm font-semibold">Slot ${parseInt(slot.dataset.slotId) + 1}</span>`;
            slot.removeAttribute('data-occupied-by');
            this.placedPieces.delete(parseInt(slot.dataset.slotId));
            
            this.setupDragAndDrop();
            this.updateCheckButton();
        });
        
        // Place piece in new slot
        slot.innerHTML = '';
        slot.appendChild(pieceClone);
        slot.setAttribute('data-occupied-by', piece.dataset.pieceId);
        
        // Remove original piece
        piece.remove();
        
        // Update placed pieces map
        this.placedPieces.set(parseInt(slot.dataset.slotId), piece.dataset.provinceName);
        
        // Show province info with animation
        this.showProvinceInfo(piece.dataset.provinceName);
        
        // Add visual feedback
        slot.classList.add('glow');
        setTimeout(() => slot.classList.remove('glow'), 1000);
        
        // Update UI
        this.updateCheckButton();
    }
    
    updateCheckButton() {
        const checkButton = document.getElementById('check-answer');
        if (this.placedPieces.size === this.currentPuzzleData.length) {
            checkButton.classList.remove('hidden');
            checkButton.classList.add('animate-bounce');
            setTimeout(() => checkButton.classList.remove('animate-bounce'), 2000);
        } else {
            checkButton.classList.add('hidden');
        }
    }
    
    showProvinceInfo(provinceName) {
        const data = this.provinceData[provinceName];
        if (!data) return;
        
        document.getElementById('province-name').textContent = provinceName;
        document.getElementById('province-capital').textContent = data.capital;
        document.getElementById('province-island').textContent = data.island;
        document.getElementById('province-description').textContent = data.description;
        
        document.getElementById('province-info').classList.remove('hidden');
    }
    
    useHint() {
        if (this.hintsUsed >= this.maxHints) {
            this.showFeedbackMessage('Hint sudah habis!');
            return;
        }
        
        this.hintsUsed++;
        const remainingHints = this.maxHints - this.hintsUsed;
        document.getElementById('hint-count').textContent = remainingHints;
        
        // Find an unplaced piece and highlight its correct position
        const unplacedPieces = this.currentPuzzleData.filter(piece => {
            return !Array.from(this.placedPieces.values()).includes(piece.name);
        });
        
        if (unplacedPieces.length > 0) {
            const randomPiece = unplacedPieces[Math.floor(Math.random() * unplacedPieces.length)];
            const correctSlot = document.querySelector(`[data-slot-id="${randomPiece.correctPosition}"]`);
            
            if (correctSlot) {
                // Highlight the correct slot
                correctSlot.classList.add('ring-4', 'ring-yellow-400', 'animate-pulse');
                correctSlot.innerHTML = `
                    <div class="text-center p-2">
                        <div class="text-yellow-300 font-bold text-sm">💡 ${randomPiece.name}</div>
                        <div class="text-xs text-yellow-200">Letakkan di sini!</div>
                    </div>
                `;
                
                setTimeout(() => {
                    correctSlot.classList.remove('ring-4', 'ring-yellow-400', 'animate-pulse');
                    correctSlot.innerHTML = `<span class="text-blue-300 text-xs lg:text-sm font-semibold">Slot ${randomPiece.correctPosition + 1}</span>`;
                }, 4000);
                
                // Also highlight the corresponding piece
                const pieceElement = document.querySelector(`[data-province-name="${randomPiece.name}"]`);
                if (pieceElement) {
                    pieceElement.classList.add('ring-2', 'ring-yellow-400', 'animate-bounce');
                    setTimeout(() => {
                        pieceElement.classList.remove('ring-2', 'ring-yellow-400', 'animate-bounce');
                    }, 4000);
                }
            }
        }
        
        // Deduct points for using hint
        this.score = Math.max(0, this.score - 50);
        document.getElementById('current-score').textContent = this.score;
        
        // Show feedback
        this.showFeedbackMessage(`Hint digunakan! (-50 poin). Sisa: ${remainingHints}`);
        
        // Update hint button state
        const hintButton = document.getElementById('hint-button');
        if (remainingHints === 0) {
            hintButton.classList.add('opacity-50', 'cursor-not-allowed');
            hintButton.disabled = true;
        }
    }
    
    checkAnswer() {
        let correctPlacements = 0;
        const totalPieces = this.currentPuzzleData.length;
        const wrongPlacements = [];
        
        // Check each placed piece
        this.placedPieces.forEach((provinceName, slotIndex) => {
            const correctPiece = this.currentPuzzleData.find(piece => piece.name === provinceName);
            const slot = document.querySelector(`[data-slot-id="${slotIndex}"]`);
            
            if (correctPiece && correctPiece.correctPosition === slotIndex) {
                correctPlacements++;
                // Add correct feedback
                slot.classList.add('border-green-500', 'bg-green-500/20');
            } else {
                wrongPlacements.push({ slot, correct: correctPiece?.correctPosition });
                // Add wrong feedback
                slot.classList.add('border-red-500', 'bg-red-500/20', 'animate-pulse');
            }
        });
        
        const accuracy = (correctPlacements / totalPieces) * 100;
        const isComplete = correctPlacements === totalPieces;
        
        if (isComplete) {
            // All correct - proceed to completion
            const timeBonus = this.calculateTimeBonus();
            const levelScore = Math.round(correctPlacements * 100 + timeBonus - (this.hintsUsed * 50));
            
            this.score += Math.max(0, levelScore);
            document.getElementById('current-score').textContent = this.score;
            
            // Celebration effect
            this.showSuccessAnimation();
            
            setTimeout(() => {
                this.completeLevelWithScore(levelScore, accuracy);
            }, 1500);
        } else {
            // Show feedback and allow retry
            this.showFeedbackMessage(`${correctPlacements}/${totalPieces} benar. Coba lagi!`);
            
            // Reset visual feedback after 2 seconds
            setTimeout(() => {
                document.querySelectorAll('.drop-zone-slot').forEach(slot => {
                    slot.classList.remove('border-green-500', 'bg-green-500/20', 'border-red-500', 'bg-red-500/20', 'animate-pulse');
                });
            }, 2000);
        }
    }
    
    showSuccessAnimation() {
        // Create celebration particles
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'fixed w-2 h-2 bg-yellow-400 rounded-full pointer-events-none z-50';
            particle.style.left = Math.random() * window.innerWidth + 'px';
            particle.style.top = Math.random() * window.innerHeight + 'px';
            particle.style.animation = `celebration-particle 1.5s ease-out forwards`;
            document.body.appendChild(particle);
            
            setTimeout(() => particle.remove(), 1500);
        }
        
        // Add celebration CSS if not exists
        if (!document.getElementById('celebration-styles')) {
            const style = document.createElement('style');
            style.id = 'celebration-styles';
            style.textContent = `
                @keyframes celebration-particle {
                    0% {
                        transform: scale(0) rotate(0deg);
                        opacity: 1;
                    }
                    50% {
                        transform: scale(1.5) rotate(180deg);
                        opacity: 0.8;
                    }
                    100% {
                        transform: scale(0) rotate(360deg);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }
    
    showFeedbackMessage(message) {
        const feedbackDiv = document.createElement('div');
        feedbackDiv.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-orange-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in';
        feedbackDiv.textContent = message;
        
        document.body.appendChild(feedbackDiv);
        setTimeout(() => {
            feedbackDiv.style.animation = 'fade-out 0.5s ease-out forwards';
            setTimeout(() => feedbackDiv.remove(), 500);
        }, 2000);
        
        // Add fade-out animation if not exists
        if (!document.getElementById('feedback-styles')) {
            const style = document.createElement('style');
            style.id = 'feedback-styles';
            style.textContent = `
                @keyframes fade-out {
                    from { opacity: 1; transform: translate(-50%, 0); }
                    to { opacity: 0; transform: translate(-50%, -20px); }
                }
            `;
            document.head.appendChild(style);
        }
    }

    calculateTimeBonus() {
        const level = this.gameData.levels[this.currentLevel];
        const timeUsed = Math.floor((new Date() - this.levelStartTime) / 1000);
        const timeLimit = level.time_limit;
        const timeRemaining = Math.max(0, timeLimit - timeUsed);
        
        return Math.round(timeRemaining * 2); // 2 points per second remaining
    }
    
    completeLevelWithScore(levelScore, accuracy) {
        clearInterval(this.countdownTimer);
        
        document.getElementById('puzzle-area').classList.add('hidden');
        document.getElementById('level-score').textContent = levelScore;
        document.getElementById('level-time').textContent = this.formatTime(Math.floor((new Date() - this.levelStartTime) / 1000));
        document.getElementById('accuracy').textContent = Math.round(accuracy) + '%';
        document.getElementById('level-complete').classList.remove('hidden');
        
        this.saveProgress();
    }
    
    nextLevel() {
        const nextLevelIndex = this.currentLevel + 1;
        
        if (nextLevelIndex >= this.gameData.levels.length) {
            this.completeGame();
        } else {
            this.startLevel(nextLevelIndex);
        }
    }
    
    startCountdown(timeLimit) {
        let remainingTime = timeLimit;
        
        this.countdownTimer = setInterval(() => {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            document.getElementById('countdown').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (remainingTime <= 30) {
                document.getElementById('time-limit').className = 'bg-red-600 animate-pulse px-3 py-1 rounded-lg';
            }
            
            remainingTime--;
            
            if (remainingTime < 0) {
                clearInterval(this.countdownTimer);
                this.timeUp();
            }
        }, 1000);
    }
    
    timeUp() {
        alert('Waktu habis! Level akan dilanjutkan dengan skor yang ada.');
        this.checkAnswer();
    }
    
    async completeGame() {
        clearInterval(this.timer);
        clearInterval(this.countdownTimer);
        
        document.getElementById('level-complete').classList.add('hidden');
        document.getElementById('final-score').textContent = this.score;
        document.getElementById('final-time').textContent = document.getElementById('game-timer').textContent;
        
        try {
            const response = await fetch(`/game/{{ $game->slug }}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    final_score: this.score,
                    final_time: Math.floor((new Date() - this.startTime) / 1000),
                    completion_data: {
                        levels_completed: this.gameData.levels.length,
                        hints_used: this.hintsUsed,
                        game_type: 'geography_puzzle'
                    }
                })
            });
            
            const result = await response.json();
            if (result.success && result.achievements) {
                this.showAchievements(result.achievements);
            }
        } catch (error) {
            console.error('Error completing game:', error);
        }
        
        document.getElementById('game-complete').classList.remove('hidden');
        this.loadLeaderboard();
    }
    
    showAchievements(achievements) {
        achievements.forEach(achievement => {
            const achievementDiv = document.createElement('div');
            achievementDiv.className = 'fixed bottom-4 right-4 bg-yellow-600 text-white p-4 rounded-xl shadow-lg z-50';
            achievementDiv.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">🏆</span>
                    <div>
                        <div class="font-bold">${achievement.achievement_name}</div>
                        <div class="text-sm">${achievement.description}</div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(achievementDiv);
            setTimeout(() => achievementDiv.remove(), 5000);
        });
    }
    
    async loadLeaderboard() {
        try {
            const leaderboardContainer = document.getElementById('leaderboard');
            leaderboardContainer.innerHTML = '<div class="text-center text-green-300 text-xs lg:text-sm animate-pulse loading-dots">Memuat data</div>';
            
            const response = await fetch(`/game/{{ $game->slug }}/leaderboard`);
            const leaderboard = await response.json();
            
            leaderboardContainer.innerHTML = '';
            
            if (leaderboard.length === 0) {
                leaderboardContainer.innerHTML = '<div class="text-center text-gray-400 text-xs lg:text-sm">Belum ada skor</div>';
                return;
            }
            
            leaderboard.slice(0, 5).forEach((entry, index) => {
                const entryDiv = document.createElement('div');
                entryDiv.className = 'flex justify-between items-center text-xs lg:text-sm py-2 px-3 rounded-lg bg-white/5 mb-2 transform hover:scale-105 transition-all';
                entryDiv.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <span class="${
                            index === 0 ? 'text-yellow-400' : 
                            index === 1 ? 'text-gray-300' : 
                            index === 2 ? 'text-orange-400' : 'text-green-300'
                        }">${index + 1}.</span>
                        <span class="text-white font-semibold">${entry.user.name}</span>
                    </div>
                    <span class="text-green-300 font-bold">${entry.score}</span>
                `;
                leaderboardContainer.appendChild(entryDiv);
            });
        } catch (error) {
            console.error('Error loading leaderboard:', error);
            document.getElementById('leaderboard').innerHTML = 
                '<div class="text-center text-red-400 text-xs lg:text-sm">Error memuat data</div>';
        }
    }
    
    async saveProgress() {
        try {
            await fetch(`/game/{{ $game->slug }}/progress`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    progress_data: {
                        current_level: this.currentLevel,
                        completed_steps: this.currentLevel + 1,
                        total_steps: this.gameData.levels.length
                    },
                    score: this.score,
                    time_spent: Math.floor((new Date() - this.startTime) / 1000)
                })
            });
        } catch (error) {
            console.error('Error saving progress:', error);
        }
    }
    
    updateProgress() {
        const totalLevels = this.gameData.levels.length;
        const currentProgress = this.currentLevel + 1;
        const progress = (currentProgress / totalLevels) * 100;
        
        document.getElementById('progress-bar').style.width = progress + '%';
        document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
        document.getElementById('progress-text').textContent = `${currentProgress}/${totalLevels}`;
        
        // Update level indicator in header
        document.getElementById('current-level').textContent = currentProgress;
        
        // Add milestone celebrations
        if (progress === 25 || progress === 50 || progress === 75) {
            this.showFeedbackMessage(`🎉 ${progress}% selesai! Terus semangat!`);
        }
    }
    
    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }
    
    resetPuzzle() {
        // Show confirmation
        if (!confirm('Yakin ingin reset puzzle? Progress level ini akan hilang.')) {
            return;
        }
        
        this.placedPieces.clear();
        document.getElementById('pieces-container').innerHTML = '';
        document.getElementById('province-info').classList.add('hidden');
        
        // Reset hint button
        this.hintsUsed = 0;
        document.getElementById('hint-count').textContent = this.maxHints;
        const hintButton = document.getElementById('hint-button');
        hintButton.classList.remove('opacity-50', 'cursor-not-allowed');
        hintButton.disabled = false;
        
        // Regenerate puzzle
        this.setupPuzzle(this.gameData.levels[this.currentLevel]);
        
        // Show feedback
        this.showFeedbackMessage('Puzzle direset! Mulai lagi dari awal.');
        
        // Hide check button
        document.getElementById('check-answer').classList.add('hidden');
    }
    
    resetGame() {
        this.currentLevel = 0;
        this.score = 0;
        this.hintsUsed = 0;
        this.startTime = new Date();
        
        document.getElementById('current-score').textContent = '0';
        document.getElementById('game-complete').classList.add('hidden');
        document.getElementById('level-intro').classList.remove('hidden');
        
        this.updateProgress();
    }
    
    updateUI() {
        const progress = this.sessionData.progress_data;
        if (progress && progress.current_level) {
            this.currentLevel = progress.current_level;
            this.updateProgress();
        }
    }
}

// Initialize game when page loads
document.addEventListener('DOMContentLoaded', function() {
    new GeographyPuzzle();
});
</script>
@endpush

@push('styles')
<style>
.puzzle-piece {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: grab;
}

.puzzle-piece:active {
    cursor: grabbing;
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
}

.puzzle-piece:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.drop-zone-slot {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px dashed rgba(59, 130, 246, 0.5);
}

.drop-zone-slot.drag-over {
    background-color: rgba(34, 197, 94, 0.2);
    border-color: rgb(34, 197, 94);
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
}

.drop-zone-slot:hover {
    border-color: rgba(59, 130, 246, 0.8);
    background-color: rgba(59, 130, 246, 0.1);
}

/* Animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        transform: translateY(0);
    }
    40%, 43% {
        animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
        transform: translateY(-15px);
    }
    70% {
        animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
        transform: translateY(-7px);
    }
    90% {
        transform: translateY(-3px);
    }
}

@keyframes pulse {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.8;
        transform: scale(1.05);
    }
}

@keyframes slideIn {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-bounce {
    animation: bounce 1s infinite;
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-slide-in {
    animation: slideIn 0.5s ease-out;
}

/* Progress bar animation */
#progress-bar {
    transition: width 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

#progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: progress-shine 2s infinite;
}

@keyframes progress-shine {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Glow effects */
.glow {
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.5);
    animation: glow-pulse 2s infinite alternate;
}

@keyframes glow-pulse {
    from { box-shadow: 0 0 20px rgba(34, 197, 94, 0.5); }
    to { box-shadow: 0 0 30px rgba(34, 197, 94, 0.8); }
}

/* Loading animation */
.loading-dots::after {
    content: '';
    animation: loading-dots 1.5s infinite;
}

@keyframes loading-dots {
    0%, 20% { content: '.'; }
    40% { content: '..'; }
    60%, 100% { content: '...'; }
}

/* Mobile optimizations */
@media (max-width: 640px) {
    .puzzle-piece {
        font-size: 0.875rem;
    }
    
    .drop-zone-slot {
        min-height: 3rem;
        font-size: 0.75rem;
    }
}

/* Backdrop blur fallback */
@supports not (backdrop-filter: blur(4px)) {
    .backdrop-blur-sm {
        background-color: rgba(0, 0, 0, 0.8);
    }
}
</style>
@endpush
@endsection