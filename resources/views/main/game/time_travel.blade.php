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
                    <h1 class="text-lg sm:text-2xl font-bold">🕰️ {{ $game->title }}</h1>
                </div>
                <div class="flex flex-wrap items-center gap-3 sm:gap-6 text-xs sm:text-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-red-200">Skor:</span>
                        <span id="current-score" class="font-bold">{{ $session->score }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-red-200">Waktu:</span>
                        <span id="game-timer" class="font-bold">00:00</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-red-200">Chapter:</span>
                        <span id="current-chapter" class="font-bold">1</span>/<span>{{ count($game->settings['scenarios']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-4 md:py-8">
        <!-- Game Progress Bar -->
        <div class="mb-6 md:mb-8">
            <div class="flex justify-between text-xs sm:text-sm text-red-200 mb-2">
                <span>Progress Petualangan</span>
                <span id="progress-percentage">0%</span>
            </div>
            <div class="w-full bg-purple-900 rounded-full h-2 sm:h-3 border border-purple-500">
                <div id="progress-bar" class="bg-gradient-to-r from-purple-400 to-pink-400 h-2 sm:h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        <!-- Game Container -->
        <div class="bg-black bg-opacity-40 rounded-2xl shadow-2xl border border-primary/50 overflow-hidden">
            <!-- Story Display Area -->
            <div id="story-container" class="p-8">
                <!-- Chapter Introduction -->
                <div id="chapter-intro" class="text-center mb-8">
                    <h2 class="text-3xl font-bold mb-4 text-tertiary">Selamat Datang, Penjelajah Waktu!</h2>
                    <p class="text-lg text-red-200 max-w-3xl mx-auto">
                        Anda akan mengalami momen-momen bersejarah Indonesia dan membuat keputusan yang dapat mengubah jalannya sejarah.
                        Setiap pilihan Anda akan mempengaruhi skor dan alur cerita selanjutnya.
                    </p>
                    <button id="start-adventure" class="mt-6 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 px-8 py-3 rounded-xl font-semibold transition-all transform hover:scale-105">
                        🚀 Mulai Petualangan
                    </button>
                </div>

                <!-- Story Scene (Hidden initially) -->
                <div id="story-scene" class="hidden">
                    <!-- Character Avatar -->
                    <div class="flex justify-center mb-6">
                        <div id="character-avatar" class="w-24 h-24 rounded-full bg-gradient-to-r from-yellow-400 to-orange-400 flex items-center justify-center text-3xl border-4 border-yellow-300">
                            👤
                        </div>
                    </div>

                    <!-- Character Name -->
                    <div class="text-center mb-4">
                        <h3 id="character-name" class="text-xl font-bold text-tertiary"></h3>
                        <p id="character-role" class="text-red-200"></p>
                    </div>

                    <!-- Story Text -->
                    <div id="story-text" class="bg-black bg-opacity-50 rounded-xl p-6 mb-6 border border-purple-400">
                        <p class="text-lg leading-relaxed"></p>
                    </div>

                    <!-- Historical Context -->
                    <div id="historical-context" class="bg-blue-900 bg-opacity-50 rounded-xl p-4 mb-6 border border-blue-400">
                        <h4 class="font-bold text-secondary mb-2">📚 Konteks Sejarah:</h4>
                        <p class="text-red-100 text-sm"></p>
                    </div>

                    <!-- Decision Options -->
                    <div id="decision-options" class="space-y-3">
                        <!-- Options will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Chapter Complete -->
                <div id="chapter-complete" class="hidden text-center">
                    <h3 class="text-2xl font-bold text-green-300 mb-4">✅ Chapter Selesai!</h3>
                    <p class="text-purple-200 mb-6">Selamat! Anda telah menyelesaikan chapter ini dengan baik.</p>
                    <div class="flex justify-center space-x-4">
                        <button id="next-chapter" class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-xl font-semibold transition-all">
                            ➡️ Chapter Selanjutnya
                        </button>
                        <button id="review-choices" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-xl font-semibold transition-all">
                            📊 Tinjau Pilihan
                        </button>
                    </div>
                </div>

                <!-- Game Complete -->
                <div id="game-complete" class="hidden text-center">
                    <h2 class="text-3xl font-bold text-yellow-300 mb-4">🏆 Petualangan Selesai!</h2>
                    <p class="text-purple-200 mb-6">Anda telah menyelesaikan seluruh petualangan waktu!</p>
                    <div class="grid grid-cols-3 gap-4 mb-6 text-center">
                        <div class="bg-purple-800 rounded-lg p-4">
                            <div class="text-2xl font-bold" id="final-score">0</div>
                            <div class="text-sm text-purple-300">Skor Total</div>
                        </div>
                        <div class="bg-purple-800 rounded-lg p-4">
                            <div class="text-2xl font-bold" id="final-time">00:00</div>
                            <div class="text-sm text-purple-300">Waktu</div>
                        </div>
                        <div class="bg-purple-800 rounded-lg p-4">
                            <div class="text-2xl font-bold" id="final-rank">-</div>
                            <div class="text-sm text-purple-300">Peringkat</div>
                        </div>
                    </div>
                    <div class="space-x-4">
                        <button id="play-again" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 px-6 py-3 rounded-xl font-semibold transition-all">
                            🔄 Main Lagi
                        </button>
                        <a href="{{ route('game.index') }}" class="bg-gray-600 hover:bg-gray-700 px-6 py-3 rounded-xl font-semibold transition-all inline-block">
                            🏠 Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Game Instructions (Sidebar) -->
        <div class="mt-8 bg-black bg-opacity-40 rounded-xl border border-primary/50 p-6">
            <h3 class="text-xl font-bold mb-4 text-yellow-300">📖 Cara Bermain</h3>
            <ul class="space-y-2 text-purple-200">
                <li class="flex items-start space-x-2">
                    <span class="text-purple-400">•</span>
                    <span>Baca cerita dengan saksama dan pahami konteks sejarahnya</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="text-purple-400">•</span>
                    <span>Pilih keputusan yang menurut Anda paling tepat</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="text-purple-400">•</span>
                    <span>Setiap pilihan akan mempengaruhi skor dan alur cerita</span>
                </li>
                <li class="flex items-start space-x-2">
                    <span class="text-purple-400">•</span>
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
        this.gameData = @json($game->settings);
        this.sessionData = @json($session);
        this.currentChapter = 0;
        this.currentScene = 0;
        this.score = {{ $session->score }};
        this.startTime = new Date();
        this.timer = null;
        
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
        const scenarioKey = this.gameData.scenarios[chapterIndex];
        const scenario = this.scenarios[scenarioKey];
        
        if (!scenario) {
            this.completeGame();
            return;
        }
        
        document.getElementById('current-chapter').textContent = chapterIndex + 1;
        document.getElementById('character-name').textContent = scenario.character.name;
        document.getElementById('character-role').textContent = scenario.character.role;
        document.getElementById('character-avatar').textContent = scenario.character.avatar;
        
        this.loadScene(scenario, 0);
        document.getElementById('story-scene').classList.remove('hidden');
    }
    
    loadScene(scenario, sceneIndex) {
        const scene = scenario.scenes[sceneIndex];
        
        document.getElementById('story-text').querySelector('p').textContent = scene.text;
        document.getElementById('historical-context').querySelector('p').textContent = scene.context;
        
        const optionsContainer = document.getElementById('decision-options');
        optionsContainer.innerHTML = '';
        
        scene.options.forEach((option, index) => {
            const button = document.createElement('button');
            button.className = 'w-full text-left bg-purple-700 hover:bg-purple-600 p-4 rounded-xl border-2 border-transparent hover:border-purple-400 transition-all transform hover:scale-102';
            button.innerHTML = `
                <div class="flex items-center justify-between">
                    <span>${option.text}</span>
                    <span class="text-purple-300">+${option.points} pts</span>
                </div>
            `;
            
            button.addEventListener('click', () => {
                this.makeDecision(option);
            });
            
            optionsContainer.appendChild(button);
        });
    }
    
    makeDecision(option) {
        this.score += option.points;
        document.getElementById('current-score').textContent = this.score;
        
        // Show feedback
        this.showFeedback(option.feedback, option.points);
        
        // Update progress
        this.updateProgress();
        
        // Save progress
        this.saveProgress();
        
        setTimeout(() => {
            this.completeChapter();
        }, 2000);
    }
    
    showFeedback(feedback, points) {
        const feedbackDiv = document.createElement('div');
        feedbackDiv.className = 'fixed top-4 right-4 bg-green-600 text-white p-4 rounded-xl shadow-lg z-50 transform translate-x-full';
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
        
        setTimeout(() => {
            feedbackDiv.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            feedbackDiv.style.transform = 'translateX(full)';
            setTimeout(() => feedbackDiv.remove(), 300);
        }, 3000);
    }
    
    updateProgress() {
        const progress = ((this.currentChapter + 1) / this.gameData.scenarios.length) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
        document.getElementById('progress-percentage').textContent = Math.round(progress) + '%';
    }
    
    completeChapter() {
        document.getElementById('story-scene').classList.add('hidden');
        document.getElementById('chapter-complete').classList.remove('hidden');
    }
    
    nextChapter() {
        document.getElementById('chapter-complete').classList.add('hidden');
        const nextChapterIndex = this.currentChapter + 1;
        
        if (nextChapterIndex >= this.gameData.scenarios.length) {
            this.completeGame();
        } else {
            this.loadChapter(nextChapterIndex);
        }
    }
    
    async completeGame() {
        clearInterval(this.timer);
        
        document.getElementById('story-scene').classList.add('hidden');
        document.getElementById('chapter-complete').classList.add('hidden');
        
        document.getElementById('final-score').textContent = this.score;
        document.getElementById('final-time').textContent = document.getElementById('game-timer').textContent;
        
        // Save completion to server
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
                        chapters_completed: this.gameData.scenarios.length,
                        game_type: 'time_travel'
                    }
                })
            });
            
            const result = await response.json();
            if (result.success) {
                // Show achievements if any
                if (result.achievements && result.achievements.length > 0) {
                    this.showAchievements(result.achievements);
                }
            }
        } catch (error) {
            console.error('Error saving game completion:', error);
        }
        
        document.getElementById('game-complete').classList.remove('hidden');
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
                        current_chapter: this.currentChapter,
                        completed_steps: this.currentChapter + 1,
                        total_steps: this.gameData.scenarios.length
                    },
                    score: this.score,
                    time_spent: Math.floor((new Date() - this.startTime) / 1000)
                })
            });
        } catch (error) {
            console.error('Error saving progress:', error);
        }
    }
    
    resetGame() {
        this.currentChapter = 0;
        this.score = 0;
        this.startTime = new Date();
        
        document.getElementById('current-score').textContent = '0';
        document.getElementById('game-complete').classList.add('hidden');
        document.getElementById('chapter-intro').classList.remove('hidden');
        
        this.updateProgress();
    }
    
    updateUI() {
        const progress = this.sessionData.progress_data;
        if (progress && progress.current_chapter) {
            this.currentChapter = progress.current_chapter;
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