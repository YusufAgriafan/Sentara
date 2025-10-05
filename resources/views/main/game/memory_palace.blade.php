@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-white text-gray-800">
    <!-- Game Header -->
    <div class="bg-primary shadow-lg border-b-4 border-white">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('game.index') }}" class="text-white hover:text-secondary transition-colors text-sm sm:text-base bg-white/20 px-3 py-1 rounded-lg">
                        ← Kembali ke Games
                    </a>
                    <h1 class="text-lg sm:text-2xl font-bold text-white flex items-center">
                        <span class="text-2xl mr-2">🧠</span>
                        {{ $game->title }}
                    </h1>
                </div>
            <div class="flex items-center space-x-6 text-sm">
                <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                    <span class="text-secondary">Memori:</span>
                    <span id="memory-strength" class="font-bold text-white">0%</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                    <span class="text-secondary">Waktu:</span>
                    <span id="game-timer" class="font-bold text-white">00:00</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                    <span class="text-secondary">Ruang:</span>
                    <span id="current-room" class="font-bold text-white">Entrance</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-4 md:py-8">
        <!-- Game Progress -->
        <div class="mb-6 lg:mb-8">
            <div class="flex justify-between items-center text-sm lg:text-base text-gray-700 mb-3">
                <div class="flex items-center space-x-2">
                    <span class="text-primary font-semibold">🧠 Memory Strength</span>
                    <span class="text-gray-500">•</span>
                    <span id="memory-progress-text" class="font-semibold text-tertiary">0/10 Items</span>
                </div>
                <span id="memory-percentage" class="text-primary font-bold">0%</span>
            </div>
            <div class="w-full bg-quaternary rounded-full h-3 lg:h-4 shadow-inner border border-gray-300">
                <div id="memory-progress-bar" class="bg-primary h-3 lg:h-4 rounded-full transition-all duration-700 ease-in-out shadow-sm" style="width: 0%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 lg:gap-8">
            <!-- Main Game Area -->
            <div class="xl:col-span-3 order-2 xl:order-1">
                <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-6 lg:p-8">
                    <!-- Game Introduction -->
                    <div id="game-intro" class="text-center">
                        <div class="text-8xl mb-6">🧠</div>
                        <h2 class="text-4xl font-bold mb-6 text-primary">Memory Palace</h2>
                        <p class="text-xl text-gray-700 mb-8 max-w-3xl mx-auto">
                            Bangun istana memori Anda dengan teknik mnemonic kuno! Jelajahi ruangan-ruangan bersejarah dan hafalkan informasi penting tentang Indonesia.
                        </p>
                        <button id="enter-palace" class="bg-primary hover:bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg text-lg">
                            🏛️ Masuki Istana Memori
                        </button>
                    </div>

                    <!-- Palace Navigation -->
                    <div id="palace-navigation" class="hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-primary flex items-center">
                                <span class="text-3xl mr-3">🏛️</span>
                                Pilih Ruangan
                            </h3>
                            <button id="back-to-intro" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                                ← Kembali
                            </button>
                        </div>
                        
                        <!-- Palace Rooms -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($game->settings['palace_rooms'] as $roomKey => $roomName)
                            <div class="palace-room bg-secondary rounded-2xl p-6 border border-yellow-200 cursor-pointer hover:bg-tertiary hover:shadow-lg transition-all transform hover:scale-105" data-room="{{ $roomKey }}">
                                <div class="text-5xl mb-4 text-center">
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
                                <h3 class="font-bold text-purple-200 mb-2 text-center">{{ str_replace('_', ' ', ucwords($roomKey, '_')) }}</h3>
                                <p class="text-purple-100 text-sm text-center mb-4">{{ $roomName }}</p>
                                <div class="text-center">
                                    <span class="room-status text-xs bg-purple-700 px-2 py-1 rounded-full">Belum Dimulai</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Memory Training Room -->
                    <div id="memory-room" class="hidden">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center space-x-4">
                                <h3 id="room-title" class="text-2xl font-bold text-red-200"></h3>
                                <span id="room-progress" class="bg-red-600 px-3 py-1 rounded-full text-sm">0/5</span>
                            </div>
                            <button id="back-to-rooms" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white transition-colors">
                                ← Pilih Ruangan
                            </button>
                        </div>

                        <!-- Memory Challenge Area -->
                        <div id="memory-challenge" class="bg-gradient-to-br from-indigo-900/20 to-purple-900/20 rounded-xl p-6 border border-indigo-400/30 mb-6">
                            <div id="challenge-content" class="text-center">
                                <!-- Content will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Memory Techniques Panel -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gradient-to-br from-green-900/20 to-teal-900/20 rounded-xl p-6 border border-green-400/30">
                                <h4 class="text-lg font-bold text-green-200 mb-3">🧠 Teknik Aktif</h4>
                                <div id="active-technique" class="text-green-100">
                                    <p class="mb-2"><strong>Method of Loci</strong></p>
                                    <p class="text-sm">Bayangkan Anda berjalan melalui ruangan ini dan tempatkan informasi pada lokasi tertentu.</p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-orange-900/20 to-red-900/20 rounded-xl p-6 border border-orange-400/30">
                                <h4 class="text-lg font-bold text-orange-200 mb-3">📊 Statistik</h4>
                                <div class="space-y-2 text-orange-100 text-sm">
                                    <div class="flex justify-between">
                                        <span>Items Dipelajari:</span>
                                        <span id="items-learned">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Tingkat Retensi:</span>
                                        <span id="retention-rate">0%</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Waktu Sesi:</span>
                                        <span id="session-time">00:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="xl:col-span-1 order-1 xl:order-2">
                <div class="bg-black bg-opacity-40 rounded-2xl shadow-xl border border-primary/50 p-6 sticky top-24">
                    <!-- Current Stats -->
                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-red-200 mb-4">� Status Saat Ini</h4>
                        <div class="space-y-3">
                            <div class="bg-gradient-to-r from-red-800/20 to-orange-800/20 rounded-lg p-3 border border-red-600/30">
                                <div class="text-sm text-red-200">Kekuatan Memori</div>
                                <div class="text-lg font-bold text-red-100" id="sidebar-memory">0%</div>
                            </div>
                            <div class="bg-gradient-to-r from-blue-800/20 to-purple-800/20 rounded-lg p-3 border border-blue-600/30">
                                <div class="text-sm text-blue-200">Ruang Aktif</div>
                                <div class="text-lg font-bold text-blue-100" id="sidebar-room">Belum Dimulai</div>
                            </div>
                            <div class="bg-gradient-to-r from-green-800/20 to-teal-800/20 rounded-lg p-3 border border-green-600/30">
                                <div class="text-sm text-green-200">Waktu Sesi</div>
                                <div class="text-lg font-bold text-green-100" id="sidebar-timer">00:00</div>
                            </div>
                        </div>
                    </div>

                    <!-- Memory Techniques -->
                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-red-200 mb-4">🎯 Teknik Memori</h4>
                        <div class="space-y-2">
                            @foreach($game->settings['memory_techniques'] as $technique)
                            <div class="technique-item bg-gradient-to-r from-purple-800/20 to-pink-800/20 rounded-lg p-2 border border-purple-600/30 text-sm" data-technique="{{ $technique }}">
                                <div class="flex items-center justify-between">
                                    <span class="text-purple-200">
                                        @switch($technique)
                                            @case('method_of_loci')
                                                🏛️ Method of Loci
                                                @break
                                            @case('acronym_system')
                                                🔤 Sistem Akronim
                                                @break
                                            @case('story_method')
                                                📖 Metode Cerita
                                                @break
                                            @case('image_association')
                                                🖼️ Asosiasi Gambar
                                                @break
                                        @endswitch
                                    </span>
                                    <span class="technique-status text-xs bg-purple-700 px-2 py-1 rounded-full">Tersedia</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Achievement Preview -->
                    <div>
                        <h4 class="text-lg font-bold text-red-200 mb-4">🏆 Pencapaian</h4>
                        <div class="space-y-2 text-sm">
                            <div class="achievement-item bg-gradient-to-r from-yellow-800/20 to-orange-800/20 rounded-lg p-2 border border-yellow-600/30">
                                <div class="text-yellow-200">🥉 Memory Novice</div>
                                <div class="text-yellow-100/80 text-xs">Hafal 5 item pertama</div>
                            </div>
                            <div class="achievement-item bg-gray-800/20 rounded-lg p-2 border border-gray-600/30 opacity-50">
                                <div class="text-gray-400">🥈 Room Master</div>
                                <div class="text-gray-500 text-xs">Selesaikan satu ruangan</div>
                            </div>
                            <div class="achievement-item bg-gray-800/20 rounded-lg p-2 border border-gray-600/30 opacity-50">
                                <div class="text-gray-400">🥇 Memory Palace Master</div>
                                <div class="text-gray-500 text-xs">Selesaikan semua ruangan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Memory Palace JavaScript -->
    <script>
    class MemoryPalace {
        constructor() {
            this.currentRoom = null;
            this.currentChallenge = 0;
            this.memorizedItems = [];
            this.startTime = null;
            this.timerInterval = null;
            this.gameData = this.initializeGameData();
            
            this.init();
        }

        initializeGameData() {
            return {
                entrance_hall: {
                    name: "Ruang Kemerdekaan",
                    items: [
                        { id: 1, name: "Soekarno", detail: "Presiden pertama Indonesia", year: "1945-1967", icon: "👨‍💼" },
                        { id: 2, name: "Mohammad Hatta", detail: "Wakil Presiden pertama", year: "1945-1956", icon: "👨‍🎓" },
                        { id: 3, name: "Proklamasi", detail: "17 Agustus 1945", year: "1945", icon: "📜" },
                        { id: 4, name: "Pancasila", detail: "Dasar negara Indonesia", year: "1945", icon: "⭐" },
                        { id: 5, name: "Bendera Merah Putih", detail: "Sang Saka Merah Putih", year: "1945", icon: "🏳️" }
                    ]
                },
                history_wing: {
                    name: "Sayap Sejarah",
                    items: [
                        { id: 6, name: "Majapahit", detail: "Kerajaan terbesar Nusantara", year: "1293-1527", icon: "👑" },
                        { id: 7, name: "Sriwijaya", detail: "Kerajaan maritim Sumatera", year: "650-1377", icon: "⛵" },
                        { id: 8, name: "Diponegoro", detail: "Pangeran Jawa dalam Perang Jawa", year: "1785-1855", icon: "⚔️" },
                        { id: 9, name: "Cut Nyak Dhien", detail: "Pahlawan wanita Aceh", year: "1848-1908", icon: "👸" },
                        { id: 10, name: "Borobudur", detail: "Candi Buddha terbesar di dunia", year: "750-850", icon: "🏛️" }
                    ]
                },
                geography_hall: {
                    name: "Aula Geografi",
                    items: [
                        { id: 11, name: "Sumatera", detail: "Pulau terbesar keenam di dunia", year: "473,481 km²", icon: "🏝️" },
                        { id: 12, name: "Jawa", detail: "Pulau terpadat di dunia", year: "138,794 km²", icon: "🏙️" },
                        { id: 13, name: "Kalimantan", detail: "Bagian Indonesia dari Borneo", year: "743,330 km²", icon: "🌿" },
                        { id: 14, name: "Papua", detail: "Provinsi terluas Indonesia", year: "421,981 km²", icon: "🦋" },
                        { id: 15, name: "Danau Toba", detail: "Danau vulkanik terbesar di dunia", year: "1,145 km²", icon: "🌊" }
                    ]
                },
                culture_room: {
                    name: "Ruang Budaya",
                    items: [
                        { id: 16, name: "Batik", detail: "Seni kain tradisional Indonesia", year: "UNESCO 2009", icon: "🎨" },
                        { id: 17, name: "Gamelan", detail: "Orkestra tradisional Jawa-Bali", year: "Abad ke-8", icon: "🎵" },
                        { id: 18, name: "Wayang", detail: "Seni pertunjukan bayangan", year: "UNESCO 2003", icon: "🎭" },
                        { id: 19, name: "Tari Saman", detail: "Tarian asal Aceh", year: "UNESCO 2011", icon: "💃" },
                        { id: 20, name: "Rendang", detail: "Makanan terenak di dunia", year: "CNN 2011", icon: "🍛" }
                    ]
                },
                modern_section: {
                    name: "Bagian Modern",
                    items: [
                        { id: 21, name: "Jakarta", detail: "Ibu kota Indonesia", year: "10.6 juta jiwa", icon: "🏙️" },
                        { id: 22, name: "Garuda Indonesia", detail: "Maskapai nasional", year: "1949", icon: "✈️" },
                        { id: 23, name: "Pertamina", detail: "Perusahaan minyak nasional", year: "1957", icon: "⛽" },
                        { id: 24, name: "Gojek", detail: "Unicorn Indonesia", year: "2010", icon: "🛵" },
                        { id: 25, name: "Bali", detail: "Destinasi wisata dunia", year: "5.7 juta wisatawan", icon: "🏖️" }
                    ]
                }
            };
        }

        init() {
            this.bindEvents();
            this.updateUI();
        }

        bindEvents() {
            // Enter palace button
            document.getElementById('enter-palace').addEventListener('click', () => {
                this.showPalaceNavigation();
            });

            // Back to intro
            document.getElementById('back-to-intro').addEventListener('click', () => {
                this.showGameIntro();
            });

            // Back to rooms
            document.getElementById('back-to-rooms').addEventListener('click', () => {
                this.showPalaceNavigation();
            });

            // Room selection
            document.querySelectorAll('.palace-room').forEach(room => {
                room.addEventListener('click', () => {
                    const roomKey = room.dataset.room;
                    this.enterRoom(roomKey);
                });
            });
        }

        showGameIntro() {
            document.getElementById('game-intro').classList.remove('hidden');
            document.getElementById('palace-navigation').classList.add('hidden');
            document.getElementById('memory-room').classList.add('hidden');
        }

        showPalaceNavigation() {
            document.getElementById('game-intro').classList.add('hidden');
            document.getElementById('palace-navigation').classList.remove('hidden');
            document.getElementById('memory-room').classList.add('hidden');
            
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
        }

        enterRoom(roomKey) {
            this.currentRoom = roomKey;
            this.currentChallenge = 0;
            this.startTime = new Date();
            
            // Start session timer
            this.startSessionTimer();
            
            // Show room interface
            document.getElementById('palace-navigation').classList.add('hidden');
            document.getElementById('memory-room').classList.remove('hidden');
            
            // Update room info
            const roomData = this.gameData[roomKey];
            document.getElementById('room-title').textContent = `${this.getRoomIcon(roomKey)} ${roomData.name}`;
            document.getElementById('sidebar-room').textContent = roomData.name;
            
            // Load first challenge
            this.loadChallenge();
            this.updateProgress();
        }

        getRoomIcon(roomKey) {
            const icons = {
                'entrance_hall': '🚪',
                'history_wing': '📜', 
                'geography_hall': '🗺️',
                'culture_room': '🎭',
                'modern_section': '🏢'
            };
            return icons[roomKey] || '🏛️';
        }

        loadChallenge() {
            const roomData = this.gameData[this.currentRoom];
            const item = roomData.items[this.currentChallenge];
            
            if (!item) {
                this.completeRoom();
                return;
            }
            
            const challengeContent = document.getElementById('challenge-content');
            challengeContent.innerHTML = `
                <div class="mb-6">
                    <div class="text-6xl mb-4">${item.icon}</div>
                    <h3 class="text-2xl font-bold text-white mb-2">${item.name}</h3>
                    <p class="text-indigo-200 text-lg mb-2">${item.detail}</p>
                    <p class="text-indigo-300">${item.year}</p>
                </div>
                
                <div class="bg-indigo-800/30 rounded-lg p-4 mb-6">
                    <h4 class="text-indigo-200 font-semibold mb-2">💡 Teknik Memori:</h4>
                    <p class="text-indigo-100 text-sm">
                        Bayangkan ${item.name} berada di sudut ${this.getLocationHint()} ruangan ini. 
                        Visualisasikan ${item.icon} ${item.name} dengan detail: "${item.detail}" pada tahun ${item.year}.
                    </p>
                </div>
                
                <div class="space-y-4">
                    <button id="memorize-item" class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg text-white">
                        🧠 Hafalkan Item Ini
                    </button>
                    <button id="test-memory" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg text-white hidden">
                        🎯 Uji Hafalan
                    </button>
                </div>
                
                <div id="memory-test" class="hidden mt-6">
                    <div class="bg-purple-800/30 rounded-lg p-4">
                        <h4 class="text-purple-200 font-semibold mb-3">📝 Uji Hafalan:</h4>
                        <p class="text-purple-100 mb-4">Apa detail dari ${item.name}?</p>
                        <div class="space-y-2">
                            ${this.generateAnswerOptions(item)}
                        </div>
                    </div>
                </div>
            `;
            
            // Bind challenge events
            this.bindChallengeEvents();
        }

        getLocationHint() {
            const locations = ['kiri depan', 'kanan depan', 'tengah', 'kiri belakang', 'kanan belakang'];
            return locations[this.currentChallenge % locations.length];
        }

        generateAnswerOptions(correctItem) {
            const roomData = this.gameData[this.currentRoom];
            const allItems = Object.values(this.gameData).flat().map(room => room.items).flat();
            
            // Get wrong options from other items
            const wrongOptions = allItems.filter(item => 
                item.id !== correctItem.id && item.detail !== correctItem.detail
            ).slice(0, 2);
            
            const options = [
                { text: correctItem.detail, correct: true },
                { text: wrongOptions[0]?.detail || "Pilihan salah 1", correct: false },
                { text: wrongOptions[1]?.detail || "Pilihan salah 2", correct: false }
            ].sort(() => Math.random() - 0.5);
            
            return options.map((option, index) => `
                <button class="answer-option w-full text-left bg-purple-700/20 hover:bg-purple-600/30 p-3 rounded-lg transition-all border border-purple-500/30" 
                        data-correct="${option.correct}">
                    ${String.fromCharCode(65 + index)}. ${option.text}
                </button>
            `).join('');
        }

        bindChallengeEvents() {
            // Memorize button
            const memorizeBtn = document.getElementById('memorize-item');
            if (memorizeBtn) {
                memorizeBtn.addEventListener('click', () => {
                    memorizeBtn.classList.add('hidden');
                    document.getElementById('test-memory').classList.remove('hidden');
                    
                    // Add visual feedback
                    memorizeBtn.innerHTML = '✅ Dihafalkan!';
                    memorizeBtn.classList.add('bg-green-700');
                });
            }
            
            // Test memory button
            const testBtn = document.getElementById('test-memory');
            if (testBtn) {
                testBtn.addEventListener('click', () => {
                    document.getElementById('memory-test').classList.remove('hidden');
                    testBtn.classList.add('hidden');
                });
            }
            
            // Answer options
            document.querySelectorAll('.answer-option').forEach(option => {
                option.addEventListener('click', () => {
                    this.handleAnswer(option.dataset.correct === 'true', option);
                });
            });
        }

        handleAnswer(isCorrect, clickedOption) {
            // Disable all options
            document.querySelectorAll('.answer-option').forEach(option => {
                option.disabled = true;
                if (option.dataset.correct === 'true') {
                    option.classList.add('bg-green-600/50', 'border-green-400');
                } else if (option === clickedOption && !isCorrect) {
                    option.classList.add('bg-red-600/50', 'border-red-400');
                }
            });
            
            if (isCorrect) {
                this.memorizedItems.push({
                    room: this.currentRoom,
                    challenge: this.currentChallenge,
                    item: this.gameData[this.currentRoom].items[this.currentChallenge]
                });
                
                // Show success message and next button
                setTimeout(() => {
                    const challengeContent = document.getElementById('challenge-content');
                    challengeContent.innerHTML += `
                        <div class="mt-6 bg-green-800/30 border border-green-400/50 rounded-lg p-4 text-center">
                            <div class="text-4xl mb-2">🎉</div>
                            <p class="text-green-200 font-semibold">Hebat! Item berhasil dihafalkan!</p>
                            <button id="next-challenge" class="mt-3 bg-yellow-600 hover:bg-yellow-700 px-6 py-3 rounded-xl font-semibold transition-all text-white">
                                ➡️ Item Selanjutnya
                            </button>
                        </div>
                    `;
                    
                    // Bind next challenge button
                    document.getElementById('next-challenge').addEventListener('click', () => {
                        this.nextChallenge();
                    });
                }, 1000);
            } else {
                // Show retry option
                setTimeout(() => {
                    const challengeContent = document.getElementById('challenge-content');
                    challengeContent.innerHTML += `
                        <div class="mt-6 bg-red-800/30 border border-red-400/50 rounded-lg p-4 text-center">
                            <div class="text-4xl mb-2">😅</div>
                            <p class="text-red-200 font-semibold">Coba lagi! Ingat teknik memori yang digunakan.</p>
                            <button id="retry-challenge" class="mt-3 bg-orange-600 hover:bg-orange-700 px-6 py-3 rounded-xl font-semibold transition-all text-white">
                                🔄 Coba Lagi
                            </button>
                        </div>
                    `;
                    
                    document.getElementById('retry-challenge').addEventListener('click', () => {
                        this.loadChallenge();
                    });
                }, 1000);
            }
            
            this.updateProgress();
        }

        nextChallenge() {
            this.currentChallenge++;
            this.loadChallenge();
        }

        completeRoom() {
            const challengeContent = document.getElementById('challenge-content');
            challengeContent.innerHTML = `
                <div class="text-center">
                    <div class="text-8xl mb-6">🏆</div>
                    <h3 class="text-3xl font-bold text-yellow-300 mb-4">Ruangan Selesai!</h3>
                    <p class="text-yellow-200 text-lg mb-6">
                        Selamat! Anda telah berhasil menghafal semua item di ${this.gameData[this.currentRoom].name}.
                    </p>
                    <div class="bg-yellow-800/20 rounded-lg p-4 mb-6">
                        <h4 class="text-yellow-200 font-semibold mb-2">📊 Statistik Ruangan:</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-yellow-300">Items Dihafalkan:</div>
                                <div class="text-white font-bold">5/5</div>
                            </div>
                            <div>
                                <div class="text-yellow-300">Waktu yang Dibutuhkan:</div>
                                <div class="text-white font-bold" id="room-completion-time">00:00</div>
                            </div>
                        </div>
                    </div>
                    <div class="space-x-4">
                        <button id="review-room" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-xl font-semibold transition-all text-white">
                            📚 Review Ruangan
                        </button>
                        <button id="next-room" class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-xl font-semibold transition-all text-white">
                            🚪 Ruangan Berikutnya
                        </button>
                    </div>
                </div>
            `;
            
            // Update completion time
            if (this.startTime) {
                const elapsed = Math.floor((new Date() - this.startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                document.getElementById('room-completion-time').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
            
            // Bind completion events
            document.getElementById('review-room').addEventListener('click', () => {
                this.showRoomReview();
            });
            
            document.getElementById('next-room').addEventListener('click', () => {
                this.showPalaceNavigation();
            });
            
            // Update room status in navigation
            const roomElement = document.querySelector(`[data-room="${this.currentRoom}"]`);
            if (roomElement) {
                const statusElement = roomElement.querySelector('.room-status');
                if (statusElement) {
                    statusElement.textContent = 'Selesai';
                    statusElement.classList.remove('bg-purple-700');
                    statusElement.classList.add('bg-green-700');
                }
            }
        }

        showRoomReview() {
            const challengeContent = document.getElementById('challenge-content');
            const roomData = this.gameData[this.currentRoom];
            
            challengeContent.innerHTML = `
                <div>
                    <h3 class="text-2xl font-bold text-blue-300 mb-6 text-center">📚 Review ${roomData.name}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        ${roomData.items.map((item, index) => `
                            <div class="bg-blue-800/20 rounded-lg p-4 border border-blue-400/30">
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="text-2xl">${item.icon}</span>
                                    <div>
                                        <h4 class="font-semibold text-blue-200">${item.name}</h4>
                                        <p class="text-blue-300 text-sm">Lokasi: ${this.getLocationHint()}</p>
                                    </div>
                                </div>
                                <p class="text-blue-100 text-sm mb-1">${item.detail}</p>
                                <p class="text-blue-300 text-xs">${item.year}</p>
                            </div>
                        `).join('')}
                    </div>
                    <div class="text-center mt-6">
                        <button id="back-to-rooms-from-review" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-xl font-semibold transition-all text-white">
                            🏛️ Kembali ke Istana
                        </button>
                    </div>
                </div>
            `;
            
            document.getElementById('back-to-rooms-from-review').addEventListener('click', () => {
                this.showPalaceNavigation();
            });
        }

        updateProgress() {
            const totalItems = Object.values(this.gameData).reduce((sum, room) => sum + room.items.length, 0);
            const memorizedCount = this.memorizedItems.length;
            const percentage = totalItems > 0 ? Math.round((memorizedCount / totalItems) * 100) : 0;
            
            // Update progress bar
            document.getElementById('memory-progress-bar').style.width = `${percentage}%`;
            document.getElementById('memory-progress-text').textContent = `${memorizedCount}/${totalItems} Items`;
            document.getElementById('memory-percentage').textContent = `${percentage}%`;
            
            // Update sidebar
            document.getElementById('sidebar-memory').textContent = `${percentage}%`;
            document.getElementById('memory-strength').textContent = `${percentage}%`;
            
            // Update room progress
            if (this.currentRoom) {
                const roomItems = this.gameData[this.currentRoom].items.length;
                const roomMemorized = this.memorizedItems.filter(item => item.room === this.currentRoom).length;
                document.getElementById('room-progress').textContent = `${roomMemorized}/${roomItems}`;
            }
            
            // Update stats
            document.getElementById('items-learned').textContent = memorizedCount;
            document.getElementById('retention-rate').textContent = `${percentage}%`;
        }

        startSessionTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
            }
            
            this.timerInterval = setInterval(() => {
                if (this.startTime) {
                    const elapsed = Math.floor((new Date() - this.startTime) / 1000);
                    const minutes = Math.floor(elapsed / 60);
                    const seconds = elapsed % 60;
                    const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    
                    document.getElementById('session-time').textContent = timeString;
                    document.getElementById('sidebar-timer').textContent = timeString;
                    document.getElementById('game-timer').textContent = timeString;
                }
            }, 1000);
        }

        updateUI() {
            this.updateProgress();
        }
    }

    // Initialize game when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        new MemoryPalace();
    });
    </script>
</div>