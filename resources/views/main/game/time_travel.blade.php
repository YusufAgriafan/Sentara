@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary via-secondary to-quaternary/60 text-white">
    <!-- Game Header -->
    <div class="bg-black bg-opacity-30 backdrop-blur-sm border-b border-primary/50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('game.index') }}" class="text-quaternary/80 hover:text-quaternary transition-colors text-sm sm:text-base">
                        ← Kembali ke Games
                    </a>
                    <h1 class="text-lg sm:text-2xl font-bold">🕰️ {{ $game->title }}</h1>
                </div>
                <div class="flex flex-wrap items-center gap-3 sm:gap-6 text-xs sm:text-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-quaternary/80">Skor:</span>
                        <span id="current-score" class="font-bold">{{ $session->score }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-quaternary/80">Waktu:</span>
                        <span id="game-timer" class="font-bold">00:00</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-quaternary/80">Chapter:</span>
                        <span id="current-chapter" class="font-bold">1</span>/<span>{{ count($game->settings['scenarios']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-4 md:py-8">
        <!-- Game Progress Bar -->
        <div class="mb-6 md:mb-8">
            <div class="flex justify-between text-xs sm:text-sm text-quaternary/80 mb-2">
                <span>Progress Petualangan</span>
                <span id="progress-percentage">0%</span>
            </div>
            <div class="w-full bg-primary/50 rounded-full h-2 sm:h-3 border border-primary">
                <div id="progress-bar" class="bg-gradient-to-r from-tertiary to-quaternary h-2 sm:h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        <!-- Game Container -->
        <div class="bg-black bg-opacity-40 rounded-2xl shadow-2xl border border-primary/50 overflow-hidden">
            <!-- Story Display Area -->
            <div id="story-container" class="p-8">
                <!-- Chapter Introduction -->
                <div id="chapter-intro" class="text-center mb-8">
                    <h2 class="text-3xl font-bold mb-4 text-tertiary">Selamat Datang, Penjelajah Waktu!</h2>
                    <p class="text-lg text-quaternary/90 max-w-3xl mx-auto">
                        Anda akan mengalami momen-momen bersejarah Indonesia dan membuat keputusan yang dapat mengubah jalannya sejarah.
                        Setiap pilihan Anda akan mempengaruhi skor dan alur cerita selanjutnya.
                    </p>
                    <button id="start-adventure" class="mt-6 bg-gradient-to-r from-secondary to-tertiary hover:from-primary hover:to-secondary px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105">
                        🚀 Mulai Petualangan
                    </button>
                </div>

                <!-- Story Scene (Hidden initially) -->
                <div id="story-scene" class="hidden">
                    <!-- Character Avatar -->
                    <div class="flex justify-center mb-6">
                        <div id="character-avatar" class="w-24 h-24 rounded-full bg-gradient-to-r from-tertiary to-quaternary flex items-center justify-center text-3xl border-4 border-tertiary/70">
                            👤
                        </div>
                    </div>

                    <!-- Character Name -->
                    <div class="text-center mb-4">
                        <h3 id="character-name" class="text-xl font-bold text-tertiary"></h3>
                        <p id="character-role" class="text-quaternary/80"></p>
                    </div>

                    <!-- Story Text -->
                    <div id="story-text" class="bg-black bg-opacity-50 rounded-xl p-6 mb-6 border border-primary/60">
                        <p class="text-lg leading-relaxed"></p>
                    </div>

                    <!-- Historical Context -->
                    <div id="historical-context" class="bg-primary/30 rounded-xl p-4 mb-6 border border-primary/60">
                        <h4 class="font-bold text-secondary mb-2">📚 Konteks Sejarah:</h4>
                        <p class="text-quaternary/90 text-sm"></p>
                    </div>

                    <!-- Decision Options -->
                    <div id="decision-options" class="space-y-3">
                        <!-- Options will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Chapter Complete -->
                <div id="chapter-complete" class="hidden text-center">
                    <h3 class="text-2xl font-bold text-tertiary mb-4">✅ Chapter Selesai!</h3>
                    <p class="text-quaternary/90 mb-6">Selamat! Anda telah menyelesaikan chapter ini dengan baik.</p>
                    <div class="flex justify-center space-x-4">
                        <button id="next-chapter" class="bg-secondary hover:bg-primary px-6 py-3 rounded-xl font-semibold transition-all">
                            ➡️ Chapter Selanjutnya
                        </button>
                        <button id="review-choices" class="bg-primary hover:bg-secondary px-6 py-3 rounded-xl font-semibold transition-all">
                            📊 Tinjau Pilihan
                        </button>
                    </div>
                </div>

                <!-- Game Complete -->
                <div id="game-complete" class="hidden text-center">
                    <h2 class="text-3xl font-bold text-tertiary mb-4">🏆 Petualangan Selesai!</h2>
                    <p class="text-quaternary/90 mb-6">Anda telah menyelesaikan seluruh petualangan waktu!</p>
                    <div class="grid grid-cols-3 gap-4 mb-6 text-center">
                        <div class="bg-primary/70 rounded-lg p-4">
                            <div class="text-2xl font-bold" id="final-score">0</div>
                            <div class="text-sm text-quaternary/80">Skor Total</div>
                        </div>
                        <div class="bg-primary/70 rounded-lg p-4">
                            <div class="text-2xl font-bold" id="final-time">00:00</div>
                            <div class="text-sm text-quaternary/80">Waktu</div>
                        </div>
                        <div class="bg-primary/70 rounded-lg p-4">
                            <div class="text-2xl font-bold" id="final-rank">-</div>
                            <div class="text-sm text-quaternary/80">Peringkat</div>
                        </div>
                    </div>
                    <div class="space-x-4">
                        <button id="play-again" class="bg-gradient-to-r from-secondary to-tertiary hover:from-primary hover:to-secondary px-6 py-3 rounded-xl font-semibold transition-all">
                            🔄 Main Lagi
                        </button>
                        <a href="{{ route('game.index') }}" class="bg-primary/80 hover:bg-primary px-6 py-3 rounded-xl font-semibold transition-all inline-block">
                            🏠 Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Game Instructions (Sidebar) -->
        <div class="mt-8 bg-black bg-opacity-40 rounded-xl border border-primary/50 p-6">
            <h3 class="text-xl font-bold mb-4 text-tertiary">📖 Cara Bermain</h3>
            <ul class="space-y-2 text-quaternary/90">
                <li class="flex items-start space-x-2">
                    <span class="text-secondary">•</span>
                    <span>Baca cerita dengan saksama dan pahami konteks sejarahnya</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="text-secondary">•</span>
                    <span>Pilih keputusan yang menurut Anda paling tepat</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="text-secondary">•</span>
                    <span>Setiap pilihan akan mempengaruhi skor dan alur cerita</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="text-secondary">•</span>
                    <span>Selesaikan semua chapter untuk mendapatkan achievement</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
class TimeTravelGame {
    constructor() {
        this.gameData = @json($game->settings) || {};
        this.sessionData = @json($session) || {};
        this.currentChapter = 0;
        this.currentScene = 0;
        this.score = {{ $session->score ?? 0 }};
        this.startTime = new Date();
        this.timer = null;
        
        // Ensure scenarios exist
        if (!this.gameData.scenarios || !Array.isArray(this.gameData.scenarios)) {
            this.gameData.scenarios = ['proklamasi_1945', 'sumpah_pemuda'];
        }
        
        this.scenarios = {
            proklamasi_1945: {
                title: "Proklamasi Kemerdekaan 1945",
                character: { name: "Soekarno", role: "Presiden Pertama", avatar: "🇮🇩" },
                scenes: [
                    {
                        text: "17 Agustus 1945, pagi yang bersejarah. Anda berperan sebagai Soekarno yang akan membacakan proklamasi kemerdekaan. Namun, ada tekanan dari berbagai pihak tentang waktu dan tempat pembacaan. Apa keputusan Anda?",
                        context: "Proklamasi kemerdekaan Indonesia adalah peristiwa bersejarah yang terjadi pada 17 Agustus 1945. Soekarno dan Hatta memimpin pembacaan teks proklamasi yang menandai lahirnya negara Indonesia.",
                        options: [
                            { text: "Bacakan segera di rumah Soekarno (Pegangsaan Timur 56)", points: 100, feedback: "Keputusan tepat! Lokasi ini aman dan bersejarah." },
                            { text: "Tunggu hingga situasi lebih kondusif", points: 50, feedback: "Terlalu lama menunggu bisa mengurangi momentum kemerdekaan." },
                            { text: "Bacakan di lapangan terbuka untuk khalayak umum", points: 75, feedback: "Berani, tapi berisiko keamanan di masa transisi." }
                        ]
                    }
                ]
            },
            sumpah_pemuda: {
                title: "Sumpah Pemuda 1928",
                character: { name: "Soegondo Djojopuspito", role: "Ketua Kongres", avatar: "🎓" },
                scenes: [
                    {
                        text: "Kongres Pemuda II sedang berlangsung. Berbagai organisasi pemuda berkumpul untuk membahas persatuan. Sebagai ketua kongres, bagaimana Anda merumuskan ikrar yang akan mempersatukan pemuda Indonesia?",
                        context: "Sumpah Pemuda 1928 adalah tonggak penting persatuan Indonesia. Kongres ini menghasilkan ikrar tentang satu tanah air, satu bangsa, dan satu bahasa.",
                        options: [
                            { text: "Tekankan kesatuan dalam keberagaman", points: 100, feedback: "Pendekatan yang bijaksana untuk mempersatukan berbagai latar belakang." },
                            { text: "Fokus pada perlawanan terhadap penjajah", points: 60, feedback: "Penting, tapi persatuan internal lebih prioritas saat ini." },
                            { text: "Prioritaskan pengembangan budaya daerah", points: 40, feedback: "Budaya penting, tapi saat ini butuh persatuan yang lebih kuat." }
                        ]
                    }
                ]
            },
            perang_diponegoro: {
                title: "Perang Diponegoro 1825-1830",
                character: { name: "Pangeran Diponegoro", role: "Pemimpin Perlawanan", avatar: "⚔️" },
                scenes: [
                    {
                        text: "Belanda telah memasang tiang di tanah leluhur tanpa izin. Rakyat mulai gelisah dan meminta Anda memimpin perlawanan. Sebagai Pangeran Diponegoro, apa strategi Anda?",
                        context: "Perang Diponegoro adalah perang terbesar yang dialami Belanda di Jawa. Dipimpin oleh Pangeran Diponegoro, perang ini berlangsung dari 1825-1830 dan menguras keuangan kolonial Belanda.",
                        options: [
                            { text: "Gunakan strategi gerilya dengan bantuan rakyat", points: 100, feedback: "Strategi gerilya terbukti efektif melawan tentara Belanda yang lebih modern." },
                            { text: "Serang langsung benteng Belanda", points: 60, feedback: "Serangan frontal berisiko tinggi menghadapi persenjataan modern Belanda." },
                            { text: "Cari dukungan dari kerajaan lain terlebih dahulu", points: 80, feedback: "Diplomasi penting, tapi momentum perlawanan bisa hilang." }
                        ]
                    }
                ]
            },
            majapahit_era: {
                title: "Era Kejayaan Majapahit",
                character: { name: "Gajah Mada", role: "Mahapatih", avatar: "👑" },
                scenes: [
                    {
                        text: "Anda adalah Gajah Mada yang baru saja mengucapkan Sumpah Palapa. Raja memberikan kepercayaan untuk mempersatukan Nusantara. Langkah strategis apa yang akan Anda ambil?",
                        context: "Gajah Mada adalah Mahapatih Kerajaan Majapahit yang terkenal dengan Sumpah Palapa-nya untuk mempersatukan seluruh Nusantara di bawah kekuasaan Majapahit.",
                        options: [
                            { text: "Kirim armada laut untuk menguasai jalur perdagangan", points: 100, feedback: "Menguasai jalur perdagangan adalah kunci kekuatan ekonomi dan politik." },
                            { text: "Fokus memperkuat pasukan darat terlebih dahulu", points: 70, feedback: "Pasukan darat penting, tapi kontrol laut lebih strategis untuk Nusantara." },
                            { text: "Bangun aliansi dengan kerajaan kecil melalui diplomasi", points: 90, feedback: "Diplomasi efektif untuk memperluas pengaruh tanpa konflik besar." }
                        ]
                    }
                ]
            },
            sriwijaya_kingdom: {
                title: "Kerajaan Sriwijaya",
                character: { name: "Balaputradewa", role: "Raja Sriwijaya", avatar: "🚢" },
                scenes: [
                    {
                        text: "Kapal-kapal dagang dari Tiongkok dan India semakin ramai melewati Selat Malaka. Sebagai raja Sriwijaya, bagaimana Anda memanfaatkan posisi strategis ini?",
                        context: "Kerajaan Sriwijaya adalah kerajaan maritim yang menguasai jalur perdagangan di Asia Tenggara. Kejayaannya bertumpu pada penguasaan Selat Malaka sebagai jalur perdagangan internasional.",
                        options: [
                            { text: "Terapkan sistem pajak dan perlindungan bagi pedagang", points: 100, feedback: "Sistem ini membuat Sriwijaya menjadi pusat perdagangan yang aman dan menguntungkan." },
                            { text: "Bangun armada laut yang kuat untuk patroli", points: 85, feedback: "Armada kuat penting untuk keamanan, tapi sistem ekonomi perlu diatur juga." },
                            { text: "Monopoli perdagangan dengan menutup akses bagi kompetitor", points: 60, feedback: "Monopoli berisiko menciptakan musuh dan mengurangi volume perdagangan." }
                        ]
                    }
                ]
            }
        };
        
        this.init();
    }
    
    init() {
        this.startTimer();
        this.setupEventListeners();
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
        document.getElementById('start-adventure').addEventListener('click', () => {
            this.startGame();
        });
        
        document.getElementById('next-chapter').addEventListener('click', () => {
            this.nextChapter();
        });
        
        document.getElementById('play-again').addEventListener('click', () => {
            this.resetGame();
        });
    }
    
    startGame() {
        document.getElementById('chapter-intro').classList.add('hidden');
        this.loadChapter(0);
    }
    
    loadChapter(chapterIndex) {
        this.currentChapter = chapterIndex;
        
        // Check if we have scenarios
        if (!this.gameData.scenarios || chapterIndex >= this.gameData.scenarios.length) {
            this.completeGame();
            return;
        }
        
        const scenarioKey = this.gameData.scenarios[chapterIndex];
        const scenario = this.scenarios[scenarioKey];
        
        if (!scenario) {
            console.warn(`Scenario '${scenarioKey}' not found. Completing game.`);
            this.completeGame();
            return;
        }
        
        // Update UI elements safely
        const currentChapterEl = document.getElementById('current-chapter');
        const characterNameEl = document.getElementById('character-name');
        const characterRoleEl = document.getElementById('character-role');
        const characterAvatarEl = document.getElementById('character-avatar');
        const storySceneEl = document.getElementById('story-scene');
        
        if (currentChapterEl) currentChapterEl.textContent = chapterIndex + 1;
        if (characterNameEl && scenario.character) characterNameEl.textContent = scenario.character.name || '';
        if (characterRoleEl && scenario.character) characterRoleEl.textContent = scenario.character.role || '';
        if (characterAvatarEl && scenario.character) characterAvatarEl.textContent = scenario.character.avatar || '👤';
        
        this.loadScene(scenario, 0);
        if (storySceneEl) storySceneEl.classList.remove('hidden');
    }
    
    loadScene(scenario, sceneIndex) {
        if (!scenario || !scenario.scenes || !scenario.scenes[sceneIndex]) {
            console.error('Invalid scene data');
            this.completeChapter();
            return;
        }
        
        const scene = scenario.scenes[sceneIndex];
        
        // Update story text safely
        const storyTextEl = document.getElementById('story-text');
        const contextEl = document.getElementById('historical-context');
        const optionsContainer = document.getElementById('decision-options');
        
        if (storyTextEl) {
            const textPara = storyTextEl.querySelector('p');
            if (textPara) textPara.textContent = scene.text || '';
        }
        
        if (contextEl) {
            const contextPara = contextEl.querySelector('p');
            if (contextPara) contextPara.textContent = scene.context || '';
        }
        
        if (!optionsContainer) {
            console.error('Options container not found');
            return;
        }
        
        optionsContainer.innerHTML = '';
        
        if (scene.options && Array.isArray(scene.options)) {
            scene.options.forEach((option, index) => {
                const button = document.createElement('button');
                button.className = 'w-full text-left bg-primary/70 hover:bg-secondary p-4 rounded-xl border-2 border-transparent hover:border-tertiary/60 transition-all transform hover:scale-102';
                button.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span>${option.text || 'Option ' + (index + 1)}</span>
                        <span class="text-quaternary/80">+${option.points || 0} pts</span>
                    </div>
                `;
                
                button.addEventListener('click', () => {
                    this.makeDecision(option);
                });
                
                optionsContainer.appendChild(button);
            });
        }
    }
    
    makeDecision(option) {
        if (!option) {
            console.error('Invalid option provided');
            return;
        }
        
        this.score += (option.points || 0);
        
        const currentScoreEl = document.getElementById('current-score');
        if (currentScoreEl) {
            currentScoreEl.textContent = this.score;
        }
        
        // Show feedback
        this.showFeedback(option.feedback || 'Pilihan dibuat!', option.points || 0);
        
        // Update progress
        this.updateProgress();
        
        // Save progress
        this.saveProgress();
        
        setTimeout(() => {
            this.completeChapter();
        }, 2000);
    }
    
    showFeedback(feedback, points) {
        if (!feedback || points === undefined || points === null) {
            console.warn('Invalid feedback data');
            return;
        }
        
        const feedbackDiv = document.createElement('div');
        feedbackDiv.className = 'fixed top-4 right-4 bg-secondary text-white p-4 rounded-xl shadow-lg z-50 transform translate-x-full';
        feedbackDiv.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="text-2xl">✅</span>
                <div>
                    <div class="font-bold">+${points} points</div>
                    <div class="text-sm">${feedback}</div>
                </div>
            </div>
        `;
        
        document.body.appendChild(feedbackDiv);
        
        // Animate in
        setTimeout(() => {
            feedbackDiv.style.transform = 'translateX(0)';
        }, 100);
        
        // Animate out and remove
        setTimeout(() => {
            feedbackDiv.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (feedbackDiv.parentNode) {
                    feedbackDiv.parentNode.removeChild(feedbackDiv);
                }
            }, 300);
        }, 3000);
    }
    
    updateProgress() {
        const totalChapters = this.gameData.scenarios ? this.gameData.scenarios.length : 1;
        const progress = ((this.currentChapter + 1) / totalChapters) * 100;
        
        const progressBarEl = document.getElementById('progress-bar');
        const progressPercentageEl = document.getElementById('progress-percentage');
        
        if (progressBarEl) progressBarEl.style.width = progress + '%';
        if (progressPercentageEl) progressPercentageEl.textContent = Math.round(progress) + '%';
    }
    
    completeChapter() {
        const storySceneEl = document.getElementById('story-scene');
        const chapterCompleteEl = document.getElementById('chapter-complete');
        
        if (storySceneEl) storySceneEl.classList.add('hidden');
        if (chapterCompleteEl) chapterCompleteEl.classList.remove('hidden');
    }
    
    nextChapter() {
        const chapterCompleteEl = document.getElementById('chapter-complete');
        if (chapterCompleteEl) chapterCompleteEl.classList.add('hidden');
        
        const nextChapterIndex = this.currentChapter + 1;
        const totalChapters = this.gameData.scenarios ? this.gameData.scenarios.length : 0;
        
        if (nextChapterIndex >= totalChapters) {
            this.completeGame();
        } else {
            this.loadChapter(nextChapterIndex);
        }
    }
    
    async completeGame() {
        if (this.timer) {
            clearInterval(this.timer);
        }
        
        const storySceneEl = document.getElementById('story-scene');
        const chapterCompleteEl = document.getElementById('chapter-complete');
        const gameCompleteEl = document.getElementById('game-complete');
        const finalScoreEl = document.getElementById('final-score');
        const finalTimeEl = document.getElementById('final-time');
        const gameTimerEl = document.getElementById('game-timer');
        
        if (storySceneEl) storySceneEl.classList.add('hidden');
        if (chapterCompleteEl) chapterCompleteEl.classList.add('hidden');
        
        if (finalScoreEl) finalScoreEl.textContent = this.score || 0;
        if (finalTimeEl && gameTimerEl) {
            finalTimeEl.textContent = gameTimerEl.textContent || '00:00';
        }
        
        // Save completion to server
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                if (gameCompleteEl) gameCompleteEl.classList.remove('hidden');
                return;
            }
            
            const response = await fetch(`/game/{{ $game->slug }}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                },
                body: JSON.stringify({
                    final_score: this.score || 0,
                    final_time: Math.floor((new Date() - this.startTime) / 1000),
                    completion_data: {
                        chapters_completed: this.gameData.scenarios ? this.gameData.scenarios.length : 0,
                        game_type: 'time_travel'
                    }
                })
            });
            
            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    // Show achievements if any
                    if (result.achievements && result.achievements.length > 0) {
                        this.showAchievements(result.achievements);
                    }
                }
            } else {
                console.error('Failed to save game completion:', response.status);
            }
        } catch (error) {
            console.error('Error saving game completion:', error);
        }
        
        if (gameCompleteEl) gameCompleteEl.classList.remove('hidden');
    }
    
    showAchievements(achievements) {
        if (!achievements || !Array.isArray(achievements)) {
            console.warn('Invalid achievements data');
            return;
        }
        
        achievements.forEach((achievement, index) => {
            if (!achievement) return;
            
            const achievementDiv = document.createElement('div');
            achievementDiv.className = 'fixed bottom-4 right-4 bg-tertiary text-white p-4 rounded-xl shadow-lg z-50';
            achievementDiv.style.transform = 'translateY(100%)';
            achievementDiv.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">🏆</span>
                    <div>
                        <div class="font-bold">${achievement.achievement_name || 'Achievement Unlocked!'}</div>
                        <div class="text-sm">${achievement.description || 'Congratulations!'}</div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(achievementDiv);
            
            // Stagger animations if multiple achievements
            setTimeout(() => {
                achievementDiv.style.transform = 'translateY(0)';
            }, index * 500);
            
            setTimeout(() => {
                achievementDiv.style.transform = 'translateY(100%)';
                setTimeout(() => {
                    if (achievementDiv.parentNode) {
                        achievementDiv.parentNode.removeChild(achievementDiv);
                    }
                }, 300);
            }, 4000 + (index * 500));
        });
    }
    
    async saveProgress() {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }
            
            const response = await fetch(`/game/{{ $game->slug }}/progress`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                },
                body: JSON.stringify({
                    progress_data: {
                        current_chapter: this.currentChapter,
                        completed_steps: this.currentChapter + 1,
                        total_steps: this.gameData.scenarios ? this.gameData.scenarios.length : 0
                    },
                    score: this.score || 0,
                    time_spent: Math.floor((new Date() - this.startTime) / 1000)
                })
            });
            
            if (!response.ok) {
                console.error('Failed to save progress:', response.status);
            }
        } catch (error) {
            console.error('Error saving progress:', error);
        }
    }
    
    resetGame() {
        this.currentChapter = 0;
        this.score = 0;
        this.startTime = new Date();
        
        const currentScoreEl = document.getElementById('current-score');
        const gameCompleteEl = document.getElementById('game-complete');
        const chapterIntroEl = document.getElementById('chapter-intro');
        
        if (currentScoreEl) currentScoreEl.textContent = '0';
        if (gameCompleteEl) gameCompleteEl.classList.add('hidden');
        if (chapterIntroEl) chapterIntroEl.classList.remove('hidden');
        
        this.updateProgress();
        
        // Restart timer if it was cleared
        if (this.timer) {
            clearInterval(this.timer);
        }
        this.startTimer();
    }
    
    updateUI() {
        if (this.sessionData && this.sessionData.progress_data && this.sessionData.progress_data.current_chapter !== undefined) {
            this.currentChapter = this.sessionData.progress_data.current_chapter;
            this.updateProgress();
        }
    }
}

// Initialize game when page loads
document.addEventListener('DOMContentLoaded', function() {
    new TimeTravelGame();
});
</script>
@endpush

@push('styles')
<style>
.transform { transition: transform 0.2s ease; }
.hover\:scale-105:hover { transform: scale(1.05); }
.hover\:scale-102:hover { transform: scale(1.02); }
</style>
@endpush
@endsection