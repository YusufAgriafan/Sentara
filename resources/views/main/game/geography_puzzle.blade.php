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
                    <h1 class="text-lg sm:text-2xl font-bold">🧩 {{ $game->title }}</h1>
                </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('game.index') }}" class="text-green-300 hover:text-white transition-colors">
                    ← Kembali ke Games
                </a>
                <h1 class="text-2xl font-bold">🧩 {{ $game->title }}</h1>
            </div>
            <div class="flex items-center space-x-6 text-sm">
                <div class="flex items-center space-x-2">
                    <span class="text-green-300">Skor:</span>
                    <span id="current-score" class="font-bold">{{ $session->score }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-green-300">Waktu:</span>
                    <span id="game-timer" class="font-bold">00:00</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-green-300">Level:</span>
                    <span id="current-level" class="font-bold">1</span>/<span>{{ count($game->settings['levels']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-4 md:py-8">
        <!-- Game Progress -->
        <div class="mb-6 md:mb-8">
            <div class="flex justify-between text-xs sm:text-sm text-white mb-2">
                <span>Level Progress</span>
                <span id="progress-text">0/5</span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2 sm:h-3">
                <div id="progress-bar" class="bg-gradient-to-r from-primary to-secondary h-2 sm:h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>
            <div class="flex justify-between text-sm text-green-300 mb-2">
                <span>Progress Level</span>
                <span id="progress-percentage">0%</span>
            </div>
            <div class="w-full bg-green-900 rounded-full h-3 border border-green-500">
                <div id="progress-bar" class="bg-gradient-to-r from-green-400 to-blue-400 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Game Area -->
            <div class="lg:col-span-3">
                <div class="bg-black bg-opacity-40 rounded-2xl shadow-2xl border border-green-500 p-6">
                    <!-- Level Introduction -->
                    <div id="level-intro" class="text-center">
                        <h2 class="text-2xl font-bold mb-4 text-yellow-300">🗺️ Puzzle Peta Nusantara</h2>
                        <p class="text-green-200 mb-6">
                            Susun potongan-potongan peta Indonesia dengan benar! Semakin cepat Anda menyelesaikan, semakin tinggi skor yang didapat.
                        </p>
                        <button id="start-puzzle" class="bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105">
                            🚀 Mulai Puzzle
                        </button>
                    </div>

                    <!-- Puzzle Game Area -->
                    <div id="puzzle-area" class="hidden">
                        <!-- Level Info -->
                        <div class="flex justify-between items-center mb-6">
                            <h3 id="level-title" class="text-xl font-bold text-green-300"></h3>
                            <div class="flex items-center space-x-4">
                                <div id="time-limit" class="bg-red-600 px-3 py-1 rounded-lg">
                                    ⏱️ <span id="countdown">00:00</span>
                                </div>
                                <button id="hint-button" class="bg-yellow-600 hover:bg-yellow-700 px-3 py-1 rounded-lg transition-colors">
                                    💡 Hint (<span id="hint-count">3</span>)
                                </button>
                            </div>
                        </div>

                        <!-- Puzzle Container -->
                        <div class="relative">
                            <!-- Drop Zone (Map Outline) -->
                            <div id="drop-zone" class="relative w-full bg-blue-900 bg-opacity-30 border-2 border-dashed border-green-400 rounded-xl p-4 min-h-96">
                                <div class="absolute inset-0 flex items-center justify-center text-green-300 pointer-events-none">
                                    <span id="drop-instruction">Seret potongan peta ke sini</span>
                                </div>
                                <!-- Correct positions will be generated by JavaScript -->
                            </div>

                            <!-- Puzzle Pieces Container -->
                            <div id="puzzle-pieces" class="mt-6 bg-green-900 bg-opacity-30 rounded-xl p-4">
                                <h4 class="text-green-300 font-semibold mb-3">Potongan Peta:</h4>
                                <div id="pieces-container" class="grid grid-cols-3 md:grid-cols-6 gap-3">
                                    <!-- Pieces will be generated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <div class="flex justify-center space-x-4 mt-6">
                            <button id="reset-puzzle" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg transition-colors">
                                🔄 Reset
                            </button>
                            <button id="check-answer" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors">
                                ✅ Periksa Jawaban
                            </button>
                        </div>
                    </div>

                    <!-- Level Complete -->
                    <div id="level-complete" class="hidden text-center">
                        <h3 class="text-2xl font-bold text-green-300 mb-4">🎉 Level Selesai!</h3>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-green-800 rounded-lg p-4">
                                <div class="text-2xl font-bold" id="level-score">0</div>
                                <div class="text-sm text-green-300">Skor Level</div>
                            </div>
                            <div class="bg-green-800 rounded-lg p-4">
                                <div class="text-2xl font-bold" id="level-time">00:00</div>
                                <div class="text-sm text-green-300">Waktu</div>
                            </div>
                            <div class="bg-green-800 rounded-lg p-4">
                                <div class="text-2xl font-bold" id="accuracy">100%</div>
                                <div class="text-sm text-green-300">Akurasi</div>
                            </div>
                        </div>
                        <div class="space-x-4">
                            <button id="next-level" class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-xl font-semibold transition-all">
                                ➡️ Level Selanjutnya
                            </button>
                            <button id="view-info" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-xl font-semibold transition-all">
                                📚 Info Daerah
                            </button>
                        </div>
                    </div>

                    <!-- Game Complete -->
                    <div id="game-complete" class="hidden text-center">
                        <h2 class="text-3xl font-bold text-yellow-300 mb-4">🏆 Semua Level Selesai!</h2>
                        <p class="text-green-200 mb-6">Selamat! Anda telah menguasai peta Indonesia!</p>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-green-800 rounded-lg p-4">
                                <div class="text-2xl font-bold" id="final-score">0</div>
                                <div class="text-sm text-green-300">Skor Total</div>
                            </div>
                            <div class="bg-green-800 rounded-lg p-4">
                                <div class="text-2xl font-bold" id="final-time">00:00</div>
                                <div class="text-sm text-green-300">Total Waktu</div>
                            </div>
                            <div class="bg-green-800 rounded-lg p-4">
                                <div class="text-2xl font-bold" id="final-rank">-</div>
                                <div class="text-sm text-green-300">Peringkat</div>
                            </div>
                        </div>
                        <div class="space-x-4">
                            <button id="play-again" class="bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 px-6 py-3 rounded-xl font-semibold transition-all">
                                🔄 Main Lagi
                            </button>
                            <a href="{{ route('game.index') }}" class="bg-gray-600 hover:bg-gray-700 px-6 py-3 rounded-xl font-semibold transition-all inline-block">
                                🏠 Kembali ke Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Level Info -->
                <div class="bg-black bg-opacity-40 rounded-xl border border-green-500 p-4">
                    <h3 class="text-lg font-bold mb-4 text-yellow-300">📊 Info Level</h3>
                    <div id="level-details">
                        <div class="mb-2">
                            <span class="text-green-300">Level:</span>
                            <span id="sidebar-level" class="font-semibold">-</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-green-300">Potongan:</span>
                            <span id="sidebar-pieces" class="font-semibold">-</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-green-300">Batas Waktu:</span>
                            <span id="sidebar-time" class="font-semibold">-</span>
                        </div>
                    </div>
                </div>

                <!-- Province Info -->
                <div id="province-info" class="bg-black bg-opacity-40 rounded-xl border border-green-500 p-4 hidden">
                    <h3 class="text-lg font-bold mb-4 text-yellow-300">🗺️ Info Provinsi</h3>
                    <div id="selected-province">
                        <div class="mb-2">
                            <span class="text-green-300">Nama:</span>
                            <span id="province-name" class="font-semibold">-</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-green-300">Ibukota:</span>
                            <span id="province-capital" class="font-semibold">-</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-green-300">Pulau:</span>
                            <span id="province-island" class="font-semibold">-</span>
                        </div>
                        <p id="province-description" class="text-sm text-green-200 mt-3"></p>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-black bg-opacity-40 rounded-xl border border-green-500 p-4">
                    <h3 class="text-lg font-bold mb-4 text-yellow-300">📖 Cara Bermain</h3>
                    <ul class="space-y-2 text-green-200 text-sm">
                        <li class="flex items-start space-x-2">
                            <span class="text-green-400">•</span>
                            <span>Seret potongan peta ke posisi yang tepat</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-400">•</span>
                            <span>Gunakan hint jika kesulitan (terbatas)</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-400">•</span>
                            <span>Semakin cepat selesai, semakin tinggi skor</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-green-400">•</span>
                            <span>Pelajari info provinsi setelah selesai</span>
                        </li>
                    </ul>
                </div>

                <!-- Leaderboard -->
                <div class="bg-black bg-opacity-40 rounded-xl border border-green-500 p-4">
                    <h3 class="text-lg font-bold mb-4 text-yellow-300">🏆 Papan Skor</h3>
                    <div id="leaderboard" class="space-y-2">
                        <div class="text-center text-green-300 text-sm">Loading...</div>
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
        
        this.provinceData = {
            'Jawa Barat': { capital: 'Bandung', island: 'Jawa', description: 'Provinsi dengan populasi terbesar di Indonesia' },
            'Jawa Tengah': { capital: 'Semarang', island: 'Jawa', description: 'Terkenal dengan budaya Jawa dan Candi Borobudur' },
            'Jawa Timur': { capital: 'Surabaya', island: 'Jawa', description: 'Pusat industri dan Gunung Bromo yang terkenal' },
            'DKI Jakarta': { capital: 'Jakarta', island: 'Jawa', description: 'Ibukota negara dan pusat ekonomi Indonesia' },
            'Banten': { capital: 'Serang', island: 'Jawa', description: 'Bekas wilayah Kesultanan Banten' },
            'DI Yogyakarta': { capital: 'Yogyakarta', island: 'Jawa', description: 'Kota pelajar dan budaya Jawa' },
            'Sumatera Utara': { capital: 'Medan', island: 'Sumatera', description: 'Terkenal dengan Danau Toba dan budaya Batak' },
            'Sumatera Barat': { capital: 'Padang', island: 'Sumatera', description: 'Tanah Minang dengan masakan Padang terkenal' },
            'Riau': { capital: 'Pekanbaru', island: 'Sumatera', description: 'Pusat industri minyak dan gas' },
            'Kalimantan Timur': { capital: 'Samarinda', island: 'Kalimantan', description: 'Kaya akan minyak dan gas alam' }
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
        pieceDiv.className = 'puzzle-piece bg-gradient-to-br from-primary to-secondary rounded-lg p-3 cursor-grab border-2 border-red-400 hover:border-red-200 transition-all transform hover:scale-105';
        pieceDiv.draggable = true;
        pieceDiv.dataset.pieceId = piece.id;
        pieceDiv.dataset.provinceName = piece.name;
        pieceDiv.innerHTML = `
            <div class="text-center">
                <div class="text-lg font-bold text-white mb-1">${piece.name}</div>
                <div class="text-xs text-green-200">${piece.data.capital}</div>
            </div>
        `;
        
        return pieceDiv;
    }
    
    createDropZones(level, container) {
        const dropZonesContainer = document.createElement('div');
        dropZonesContainer.className = 'grid grid-cols-2 md:grid-cols-3 gap-4 h-full min-h-80';
        
        for (let i = 0; i < level.pieces; i++) {
            const dropZone = document.createElement('div');
            dropZone.className = 'drop-zone-slot bg-blue-800 bg-opacity-50 border-2 border-dashed border-blue-400 rounded-lg flex items-center justify-center min-h-20 transition-all';
            dropZone.dataset.slotId = i;
            dropZone.innerHTML = `<span class="text-blue-300 text-sm">Slot ${i + 1}</span>`;
            
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
                piece.style.opacity = '0.5';
            });
            
            piece.addEventListener('dragend', () => {
                piece.style.opacity = '1';
            });
            
            piece.addEventListener('click', () => {
                this.showProvinceInfo(piece.dataset.provinceName);
            });
        });
        
        dropSlots.forEach(slot => {
            slot.addEventListener('dragover', (e) => {
                e.preventDefault();
                slot.classList.add('bg-green-600', 'bg-opacity-50');
            });
            
            slot.addEventListener('dragleave', () => {
                slot.classList.remove('bg-green-600', 'bg-opacity-50');
            });
            
            slot.addEventListener('drop', (e) => {
                e.preventDefault();
                slot.classList.remove('bg-green-600', 'bg-opacity-50');
                
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
            previousSlot.innerHTML = `<span class="text-blue-300 text-sm">Slot ${parseInt(previousSlot.dataset.slotId) + 1}</span>`;
            previousSlot.removeAttribute('data-occupied-by');
        }
        
        // Check if slot is already occupied
        if (slot.hasAttribute('data-occupied-by')) {
            const occupyingPiece = document.querySelector(`[data-piece-id="${slot.getAttribute('data-occupied-by')}"]`);
            if (occupyingPiece) {
                // Move occupying piece back to pieces container
                document.getElementById('pieces-container').appendChild(occupyingPiece);
            }
        }
        
        // Place piece in new slot
        slot.innerHTML = piece.outerHTML;
        slot.setAttribute('data-occupied-by', piece.dataset.pieceId);
        piece.remove();
        
        // Update placed pieces map
        this.placedPieces.set(parseInt(slot.dataset.slotId), piece.dataset.provinceName);
        
        // Show province info
        this.showProvinceInfo(piece.dataset.provinceName);
        
        // Check if all pieces are placed
        if (this.placedPieces.size === this.currentPuzzleData.length) {
            document.getElementById('check-answer').classList.remove('hidden');
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
        if (this.hintsUsed >= this.maxHints) return;
        
        this.hintsUsed++;
        document.getElementById('hint-count').textContent = this.maxHints - this.hintsUsed;
        
        // Find an unplaced piece and highlight its correct position
        const unplacedPiece = this.currentPuzzleData.find(piece => {
            return !Array.from(this.placedPieces.values()).includes(piece.name);
        });
        
        if (unplacedPiece) {
            const correctSlot = document.querySelector(`[data-slot-id="${unplacedPiece.correctPosition}"]`);
            if (correctSlot) {
                correctSlot.classList.add('ring-4', 'ring-yellow-400', 'animate-pulse');
                setTimeout(() => {
                    correctSlot.classList.remove('ring-4', 'ring-yellow-400', 'animate-pulse');
                }, 3000);
            }
        }
        
        // Deduct points for using hint
        this.score = Math.max(0, this.score - 50);
        document.getElementById('current-score').textContent = this.score;
    }
    
    checkAnswer() {
        let correctPlacements = 0;
        const totalPieces = this.currentPuzzleData.length;
        
        this.placedPieces.forEach((provinceName, slotIndex) => {
            const correctPiece = this.currentPuzzleData.find(piece => piece.name === provinceName);
            if (correctPiece && correctPiece.correctPosition === slotIndex) {
                correctPlacements++;
            }
        });
        
        const accuracy = (correctPlacements / totalPieces) * 100;
        const timeBonus = this.calculateTimeBonus();
        const levelScore = Math.round(correctPlacements * 100 + timeBonus - (this.hintsUsed * 50));
        
        this.score += Math.max(0, levelScore);
        document.getElementById('current-score').textContent = this.score;
        
        this.completeLevelWithScore(levelScore, accuracy);
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
            const response = await fetch(`/game/{{ $game->slug }}/leaderboard`);
            const leaderboard = await response.json();
            
            const leaderboardContainer = document.getElementById('leaderboard');
            leaderboardContainer.innerHTML = '';
            
            leaderboard.slice(0, 5).forEach((entry, index) => {
                const entryDiv = document.createElement('div');
                entryDiv.className = 'flex justify-between text-sm';
                entryDiv.innerHTML = `
                    <span class="text-green-300">${index + 1}. ${entry.user.name}</span>
                    <span class="text-white">${entry.score}</span>
                `;
                leaderboardContainer.appendChild(entryDiv);
            });
        } catch (error) {
            console.error('Error loading leaderboard:', error);
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
        const progress = ((this.currentLevel + 1) / this.gameData.levels.length) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
        document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
    }
    
    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }
    
    resetPuzzle() {
        this.placedPieces.clear();
        document.getElementById('pieces-container').innerHTML = '';
        this.setupPuzzle(this.gameData.levels[this.currentLevel]);
        document.getElementById('province-info').classList.add('hidden');
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
.puzzle-piece:active {
    cursor: grabbing;
}

.drop-zone-slot.drag-over {
    background-color: rgba(106, 38, 52, 0.3); /* primary color with opacity */
    border-color: rgb(106, 38, 52); /* primary color */
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
@endpush
@endsection