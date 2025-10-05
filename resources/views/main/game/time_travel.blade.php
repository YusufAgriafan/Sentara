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
                <div class="text-sm text-gray-600 mb-1">Chapter</div>
                <div id="mobile-chapter" class="text-2xl font-bold text-primary">1</div>
            </div>
            <div class="bg-tertiary p-4 rounded-xl">
                <div class="text-sm text-gray-600 mb-1">Skor</div>
                <div id="mobile-score" class="text-2xl font-bold text-gray-800">{{ $session->score }}</div>
            </div>
            <div class="bg-quaternary p-4 rounded-xl">
                <div class="text-sm text-gray-600 mb-1">Waktu</div>
                <div id="mobile-timer" class="text-2xl font-bold text-gray-800">00:00</div>
            </div>
        </div>
    </div>

    <!-- Game Header -->
    <div class="bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">
                <div class="ml-16 lg:ml-0">
                    <div class="flex items-center space-x-4 mb-2">
                        <a href="{{ route('game.index') }}" class="text-white hover:text-secondary transition-colors font-medium">
                            ← Kembali ke Games
                        </a>
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-bold">🕰️ {{ $game->title }}</h1>
                    <p class="text-blue-100 mt-2">Jelajahi sejarah Indonesia dan ubah masa depan</p>
                </div>
                <div class="hidden lg:flex items-center space-x-6">
                    <div class="bg-white bg-opacity-20 rounded-xl px-4 py-3">
                        <span class="text-sm opacity-80">Chapter: </span>
                        <span id="current-chapter" class="font-bold text-lg">1</span>
                        <span class="text-sm opacity-80">/{{ count($game->settings['scenarios']) }}</span>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-xl px-4 py-3">
                        <span class="text-sm opacity-80">Skor: </span>
                        <span id="current-score" class="font-bold text-lg">{{ $session->score }}</span>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-xl px-4 py-3">
                        <span class="text-sm opacity-80">⏱️ </span>
                        <span id="game-timer" class="font-bold text-lg">00:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Game Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between text-sm text-gray-600 mb-3">
                <span class="font-medium">Progress Petualangan</span>
                <span id="progress-percentage" class="font-bold text-primary">0%</span>
            </div>
            <div class="w-full bg-quaternary rounded-full h-4 overflow-hidden">
                <div id="progress-bar" class="bg-primary h-4 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        <!-- Game Container -->
        <div class="bg-white rounded-3xl shadow-lg border border-quaternary overflow-hidden">
            <!-- Story Display Area -->
            <div id="story-container" class="p-8 lg:p-12">
                <!-- Chapter Introduction -->
                <div id="chapter-intro" class="text-center mb-8">
                    <div class="w-24 h-24 bg-secondary rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                        🕰️
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold mb-6 text-gray-800">Selamat Datang, Penjelajah Waktu!</h2>
                    <div class="max-w-3xl mx-auto">
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Anda akan mengalami momen-momen bersejarah Indonesia dan membuat keputusan yang dapat mengubah jalannya sejarah.
                            Setiap pilihan Anda akan mempengaruhi skor dan alur cerita selanjutnya.
                        </p>
                        <button id="start-adventure" class="bg-primary hover:bg-blue-600 text-white px-8 py-4 rounded-2xl font-semibold text-lg transition-all transform hover:scale-105 shadow-lg">
                            🚀 Mulai Petualangan
                        </button>
                    </div>
                </div>

                <!-- Story Scene (Hidden initially) -->
                <div id="story-scene" class="hidden">
                    <!-- Character Avatar -->
                    <div class="flex justify-center mb-8">
                        <div id="character-avatar" class="w-32 h-32 rounded-full bg-tertiary flex items-center justify-center text-5xl border-4 border-white shadow-lg">
                            👤
                        </div>
                    </div>

                    <!-- Character Name -->
                    <div class="text-center mb-8">
                        <h3 id="character-name" class="text-2xl font-bold text-gray-800 mb-2"></h3>
                        <p id="character-role" class="text-gray-600 text-lg"></p>
                    </div>

                    <!-- Story Text -->
                    <div id="story-text" class="bg-quaternary rounded-2xl p-8 mb-8 border border-gray-100">
                        <p class="text-lg leading-relaxed text-gray-700"></p>
                    </div>

                    <!-- Historical Context -->
                    <div id="historical-context" class="bg-secondary rounded-2xl p-6 mb-8 border border-yellow-100">
                        <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                            <span class="text-2xl mr-2">📚</span>
                            Konteks Sejarah:
                        </h4>
                        <p class="text-gray-700 leading-relaxed"></p>
                    </div>

                    <!-- Decision Options -->
                    <div id="decision-options" class="space-y-4">
                        <!-- Options will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Chapter Complete -->
                <div id="chapter-complete" class="hidden text-center">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                        ✅
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">Chapter Selesai!</h3>
                    <p class="text-gray-600 mb-8 text-lg">Selamat! Anda telah menyelesaikan chapter ini dengan baik.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <button id="next-chapter" class="bg-primary hover:bg-blue-600 text-white px-8 py-4 rounded-2xl font-semibold transition-all">
                            ➡️ Chapter Selanjutnya
                        </button>
                        <button id="review-choices" class="bg-tertiary hover:bg-yellow-400 text-gray-800 px-8 py-4 rounded-2xl font-semibold transition-all">
                            📊 Tinjau Pilihan
                        </button>
                    </div>
                </div>

                <!-- Game Complete -->
                <div id="game-complete" class="hidden text-center">
                    <div class="w-32 h-32 bg-yellow-100 rounded-full flex items-center justify-center text-6xl mx-auto mb-6">
                        🏆
                    </div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Petualangan Selesai!</h2>
                    <p class="text-gray-600 mb-8 text-lg">Anda telah menyelesaikan seluruh petualangan waktu!</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 max-w-2xl mx-auto">
                        <div class="bg-primary text-white rounded-2xl p-6">
                            <div class="text-3xl font-bold" id="final-score">0</div>
                            <div class="text-sm opacity-90">Skor Total</div>
                        </div>
                        <div class="bg-secondary text-gray-800 rounded-2xl p-6">
                            <div class="text-3xl font-bold" id="final-time">00:00</div>
                            <div class="text-sm">Waktu</div>
                        </div>
                        <div class="bg-tertiary text-gray-800 rounded-2xl p-6">
                            <div class="text-3xl font-bold" id="final-rank">-</div>
                            <div class="text-sm">Peringkat</div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <button id="play-again" class="bg-primary hover:bg-blue-600 text-white px-8 py-4 rounded-2xl font-semibold transition-all">
                            🔄 Main Lagi
                        </button>
                        <a href="{{ route('game.index') }}" class="bg-quaternary hover:bg-gray-300 text-gray-800 px-8 py-4 rounded-2xl font-semibold transition-all inline-block">
                            🏠 Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Game Instructions -->
        <div class="mt-8 bg-white rounded-3xl shadow-lg border border-quaternary p-8">
            <h3 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
                <span class="text-3xl mr-3">📖</span>
                Cara Bermain
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">1</div>
                    <span class="text-gray-700">Baca cerita dengan saksama dan pahami konteks sejarahnya</span>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">2</div>
                    <span class="text-gray-700">Pilih keputusan yang menurut Anda paling tepat</span>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">3</div>
                    <span class="text-gray-700">Setiap pilihan akan mempengaruhi skor dan alur cerita</span>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">4</div>
                    <span class="text-gray-700">Selesaikan semua chapter untuk mendapatkan achievement</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const closeDrawer = document.getElementById('close-drawer');
    
    // Toggle mobile menu
    mobileMenuToggle?.addEventListener('click', function() {
        mobileDrawer.classList.remove('-translate-x-full');
    });
    
    // Close mobile menu
    closeDrawer?.addEventListener('click', function() {
        mobileDrawer.classList.add('-translate-x-full');
    });
    
    // Close on backdrop click
    mobileDrawer?.addEventListener('click', function(e) {
        if (e.target === mobileDrawer) {
            mobileDrawer.classList.add('-translate-x-full');
        }
    });
    
    // Update mobile drawer with current stats
    function updateMobileStats() {
        const mobileChapter = document.getElementById('mobile-chapter');
        const mobileScore = document.getElementById('mobile-score');
        const mobileTimer = document.getElementById('mobile-timer');
        
        const currentChapter = document.getElementById('current-chapter')?.textContent || '1';
        const currentScore = document.getElementById('current-score')?.textContent || '0';
        const gameTimer = document.getElementById('game-timer')?.textContent || '00:00';
        
        if (mobileChapter) mobileChapter.textContent = currentChapter;
        if (mobileScore) mobileScore.textContent = currentScore;
        if (mobileTimer) mobileTimer.textContent = gameTimer;
    }
    
    // Update mobile stats periodically
    setInterval(updateMobileStats, 1000);
});

class TimeTravelGame {
    constructor() {
        this.gameData = @json($game->settings) || {};
        this.sessionData = @json($session) || {};
        this.currentChapter = 0;
        this.currentScene = 0;
        this.score = {{ $session->score ?? 0 }};
        this.startTime = new Date();
        this.timer = null;
        this.gameTime = 0;
        
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
            this.gameTime = Math.floor((Date.now() - this.startTime) / 1000);
            this.updateTimer();
        }, 1000);
    }
    
    updateTimer() {
        const minutes = Math.floor(this.gameTime / 60);
        const seconds = this.gameTime % 60;
        const timeStr = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        const timerEl = document.getElementById('game-timer');
        const mobileTimerEl = document.getElementById('mobile-timer');
        
        if (timerEl) timerEl.textContent = timeStr;
        if (mobileTimerEl) mobileTimerEl.textContent = timeStr;
    }
    
    setupEventListeners() {
        document.getElementById('start-adventure')?.addEventListener('click', () => {
            this.startGame();
        });
        
        document.getElementById('next-chapter')?.addEventListener('click', () => {
            this.nextChapter();
        });
        
        document.getElementById('play-again')?.addEventListener('click', () => {
            this.resetGame();
        });
    }
    
    startGame() {
        document.getElementById('chapter-intro')?.classList.add('hidden');
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
        const mobileChapterEl = document.getElementById('mobile-chapter');
        const characterNameEl = document.getElementById('character-name');
        const characterRoleEl = document.getElementById('character-role');
        const characterAvatarEl = document.getElementById('character-avatar');
        const storySceneEl = document.getElementById('story-scene');
        
        if (currentChapterEl) currentChapterEl.textContent = chapterIndex + 1;
        if (mobileChapterEl) mobileChapterEl.textContent = chapterIndex + 1;
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
                button.className = 'w-full bg-white hover:bg-quaternary border-2 border-quaternary hover:border-primary text-gray-800 p-6 rounded-2xl text-left transition-all transform hover:scale-[1.02] shadow-sm hover:shadow-md';
                button.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-medium">${option.text || 'Option ' + (index + 1)}</span>
                        <div class="bg-primary text-white px-3 py-1 rounded-full text-sm font-bold">+${option.points || 0}</div>
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
        
        // Update score displays
        const currentScoreEl = document.getElementById('current-score');
        const mobileScoreEl = document.getElementById('mobile-score');
        if (currentScoreEl) currentScoreEl.textContent = this.score;
        if (mobileScoreEl) mobileScoreEl.textContent = this.score;
        
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
        feedbackDiv.className = 'fixed top-4 right-4 bg-primary text-white p-6 rounded-2xl shadow-xl z-50 transform translate-x-full transition-transform duration-300 max-w-sm';
        feedbackDiv.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="bg-white bg-opacity-20 rounded-full p-2">
                    <span class="text-2xl">💡</span>
                </div>
                <div>
                    <div class="font-bold text-lg mb-1">+${points} Poin</div>
                    <div class="text-blue-100">${feedback}</div>
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
        const finalRankEl = document.getElementById('final-rank');
        
        if (storySceneEl) storySceneEl.classList.add('hidden');
        if (chapterCompleteEl) chapterCompleteEl.classList.add('hidden');
        
        if (finalScoreEl) finalScoreEl.textContent = this.score || 0;
        if (finalTimeEl) {
            const minutes = Math.floor(this.gameTime / 60);
            const seconds = this.gameTime % 60;
            finalTimeEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
        
        // Calculate rank based on score
        let rank = 'C';
        if (this.score >= 120) rank = 'A+';
        else if (this.score >= 100) rank = 'A';
        else if (this.score >= 80) rank = 'B+';
        else if (this.score >= 60) rank = 'B';
        
        if (finalRankEl) finalRankEl.textContent = rank;
        
        if (gameCompleteEl) gameCompleteEl.classList.remove('hidden');
        
        // Save completion
        await this.saveProgress();
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
                        score: this.score,
                        game_time: this.gameTime
                    }
                })
            });
            
            if (!response.ok) {
                console.error('Failed to save progress');
            }
        } catch (error) {
            console.error('Error saving progress:', error);
        }
    }
    
    resetGame() {
        this.currentChapter = 0;
        this.currentScene = 0;
        this.score = 0;
        this.startTime = new Date();
        this.gameTime = 0;
        
        // Reset UI
        const gameCompleteEl = document.getElementById('game-complete');
        const chapterIntroEl = document.getElementById('chapter-intro');
        
        if (gameCompleteEl) gameCompleteEl.classList.add('hidden');
        if (chapterIntroEl) chapterIntroEl.classList.remove('hidden');
        
        // Reset displays
        const currentScoreEl = document.getElementById('current-score');
        const mobileScoreEl = document.getElementById('mobile-score');
        const progressBarEl = document.getElementById('progress-bar');
        const progressPercentageEl = document.getElementById('progress-percentage');
        
        if (currentScoreEl) currentScoreEl.textContent = '0';
        if (mobileScoreEl) mobileScoreEl.textContent = '0';
        if (progressBarEl) progressBarEl.style.width = '0%';
        if (progressPercentageEl) progressPercentageEl.textContent = '0%';
        
        this.updateUI();
    }
    
    updateUI() {
        this.updateProgress();
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
/* Custom animations for smooth interactions */
.transform { transition: transform 0.2s ease; }
.hover\:scale-105:hover { transform: scale(1.05); }
.hover\:scale-\[1\.02\]:hover { transform: scale(1.02); }

/* Mobile drawer backdrop */
@media (max-width: 1023px) {
    .mobile-drawer-open::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 30;
    }
}

/* Smooth transitions for all interactive elements */
button, a {
    transition: all 0.2s ease;
}

/* Progress bar animation */
#progress-bar {
    transition: width 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar for mobile drawer */
#mobile-drawer {
    scrollbar-width: thin;
    scrollbar-color: #3396D3 #EEEEEE;
}

#mobile-drawer::-webkit-scrollbar {
    width: 6px;
}

#mobile-drawer::-webkit-scrollbar-track {
    background: #EEEEEE;
}

#mobile-drawer::-webkit-scrollbar-thumb {
    background: #3396D3;
    border-radius: 3px;
}
</style>
@endpush
@endsection