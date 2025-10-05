@extends('layouts.main')

@section('content')
<style>
    /* Game-specific animations and styles */
    .evidence-card {
        transition: all 0.3s ease;
        animation: slideInLeft 0.5s ease;
    }
    
    .evidence-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(255, 193, 7, 0.3);
    }
    
    .location-card, .suspect-card {
        transition: all 0.3s ease;
    }
    
    .location-card:hover, .suspect-card:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .collect-evidence-btn {
        transition: all 0.3s ease;
    }
    
    .collect-evidence-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    
    .answer-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .answer-btn:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);
    }
    
    .answer-btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }
    
    .answer-btn:hover:before {
        left: 100%;
    }
    
    .suspect-choice-btn {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .suspect-choice-btn:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
    }
    
    .progress-bar {
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .notification-enter {
        animation: slideInRight 0.3s ease;
    }
    
    .notification-exit {
        animation: slideOutRight 0.3s ease;
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .fade-in-up {
        animation: fadeInUp 0.6s ease;
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    .evidence-found {
        animation: bounceIn 0.6s ease;
    }
    
    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .interview-message {
        animation: typewriter 0.5s ease;
    }
    
    @keyframes typewriter {
        from {
            width: 0;
        }
        to {
            width: 100%;
        }
    }
    
    .game-complete-animation {
        animation: celebrationBounce 1s ease;
    }
    
    @keyframes celebrationBounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }
</style>

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
                        <span class="text-2xl mr-2">🔍</span>
                        {{ $game->title }}
                    </h1>
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                        <span class="text-secondary">Skor:</span>
                        <span id="current-score" class="font-bold text-white">{{ $session->score }}</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                        <span class="text-secondary">Waktu:</span>
                        <span id="game-timer" class="font-bold text-white">00:00</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/20 px-3 py-2 rounded-lg">
                        <span class="text-secondary">Kasus:</span>
                        <span id="current-case" class="font-bold text-white">1</span>/<span class="text-secondary">{{ count($game->settings['cases']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Game Container -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Panel - Evidence Board -->
            <div class="lg:col-span-1">
                <div class="bg-black bg-opacity-40 rounded-xl border border-yellow-500 p-6">
                    <h3 class="text-xl font-bold text-yellow-300 mb-4 flex items-center">
                        � Papan Bukti
                    </h3>
                    <div id="evidence-board" class="space-y-3">
                        <div class="text-gray-400 text-sm">Belum ada bukti yang dikumpulkan...</div>
                    </div>
                    
                    <!-- Investigation Progress -->
                    <div class="mt-6 pt-4 border-t border-gray-300">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-primary text-sm">Progress Investigasi:</span>
                            <span id="investigation-progress" class="text-tertiary text-sm font-bold">0/12</span>
                        </div>
                        <div class="w-full bg-quaternary rounded-full h-2">
                            <div id="progress-bar" class="bg-primary h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <!-- Suspects Panel -->
                <div class="bg-secondary rounded-3xl shadow-lg border border-yellow-200 p-6 mt-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="text-2xl mr-3">🕵️</span>
                        Daftar Saksi
                    </h3>
                    <div id="suspects-list" class="space-y-2">
                        <!-- Suspects will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Center Panel - Main Investigation Area -->
            <div class="lg:col-span-2">
                <!-- Case Introduction -->
                <div id="case-intro" class="bg-white rounded-3xl shadow-lg border border-quaternary p-8 mb-6">
                    <div class="text-center">
                        <div class="text-6xl mb-4">🏺</div>
                        <h2 id="case-title" class="text-3xl font-bold text-primary mb-4">Hilangnya Pusaka Majapahit</h2>
                        <p id="case-description" class="text-gray-700 mb-6">
                            Sebuah pusaka berharga dari era Majapahit telah hilang dari museum. 
                            Sebagai detektif sejarah, Anda harus menyelidiki kasus ini dengan mengumpulkan bukti, 
                            mewawancarai saksi, dan memecahkan misteri yang tersembunyi.
                        </p>
                        <button id="start-investigation" class="bg-primary hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold transition-all shadow-lg">
                            🔍 Mulai Investigasi
                        </button>
                    </div>
                </div>

                <!-- Investigation Interface (hidden initially) -->
                <div id="investigation-interface" class="hidden">
                    <!-- Location Selection -->
                    <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-6 mb-6">
                        <h3 class="text-xl font-bold text-primary mb-4 flex items-center">
                            <span class="text-2xl mr-3">🗺️</span>
                            Pilih Lokasi Investigasi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="location-grid">
                            <!-- Locations will be loaded here -->
                        </div>
                    </div>

                    <!-- Investigation Results -->
                    <div id="investigation-results" class="bg-tertiary rounded-3xl shadow-lg border border-yellow-300 p-6 mb-6 hidden">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-3">🔍</span>
                            Hasil Investigasi
                        </h3>
                        <div id="results-content">
                            <!-- Investigation results will appear here -->
                        </div>
                    </div>

                    <!-- Interview Interface -->
                    <div id="interview-interface" class="bg-black bg-opacity-40 rounded-xl border border-purple-500 p-6 mb-6 hidden">
                        <h3 class="text-xl font-bold text-purple-300 mb-4">� Wawancara</h3>
                        <div id="interview-content">
                            <!-- Interview content will appear here -->
                        </div>
                    </div>

                    <!-- Deduction Interface -->
                    <div id="deduction-interface" class="bg-black bg-opacity-40 rounded-xl border border-red-500 p-6 hidden">
                        <h3 class="text-xl font-bold text-red-300 mb-4">🧩 Buat Deduksi</h3>
                        <p class="text-red-200 mb-4">Hubungkan bukti-bukti yang telah Anda kumpulkan untuk memecahkan kasus ini:</p>
                        <div id="deduction-content">
                            <!-- Deduction interface will appear here -->
                        </div>
                    </div>
                </div>

                <!-- Game Complete Interface -->
                <div id="game-complete" class="bg-black bg-opacity-40 rounded-xl border border-green-500 p-8 text-center hidden">
                    <div class="text-6xl mb-4">🎉</div>
                    <h2 class="text-3xl font-bold text-green-300 mb-4">Kasus Terpecahkan!</h2>
                    <p id="completion-message" class="text-green-200 mb-6"></p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-green-600 bg-opacity-20 rounded-xl p-4">
                            <div class="text-2xl mb-2">🏆</div>
                            <div class="text-green-300 font-bold" id="final-score">0</div>
                            <div class="text-green-200 text-sm">Skor Akhir</div>
                        </div>
                        <div class="bg-blue-600 bg-opacity-20 rounded-xl p-4">
                            <div class="text-2xl mb-2">⏱️</div>
                            <div class="text-blue-300 font-bold" id="final-time">00:00</div>
                            <div class="text-blue-200 text-sm">Waktu Total</div>
                        </div>
                        <div class="bg-purple-600 bg-opacity-20 rounded-xl p-4">
                            <div class="text-2xl mb-2">🔍</div>
                            <div class="text-purple-300 font-bold" id="evidence-found">0/12</div>
                            <div class="text-purple-200 text-sm">Bukti Ditemukan</div>
                        </div>
                    </div>
                    <div class="space-x-4">
                        <button id="next-case" class="bg-yellow-600 hover:bg-yellow-700 px-8 py-3 rounded-xl font-semibold transition-all">
                            ➡️ Kasus Berikutnya
                        </button>
                        <a href="{{ route('game.index') }}" class="bg-gray-600 hover:bg-gray-700 px-8 py-3 rounded-xl font-semibold transition-all inline-block">
                            🏠 Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Game data and state management
let gameState = {
    currentCase: 0,
    cases: @json($game->settings['cases']),
    evidenceTypes: @json($game->settings['evidence_types']),
    scoring: @json($game->settings['scoring']),
    evidenceCollected: [],
    suspectsInterviewed: [],
    score: {{ $session->score }},
    startTime: Date.now(),
    gameSession: @json($session),
    currentLocation: null,
    currentSuspect: null,
    gameComplete: false
};

// Game initialization
document.addEventListener('DOMContentLoaded', function() {
    initializeGame();
});

function initializeGame() {
    startGameTimer();
    loadCurrentCase();
    setupEventListeners();
}

function startGameTimer() {
    const startTime = Date.now();
    setInterval(() => {
        if (!gameState.gameComplete) {
            const elapsed = Date.now() - startTime;
            const minutes = Math.floor(elapsed / 60000);
            const seconds = Math.floor((elapsed % 60000) / 1000);
            document.getElementById('game-timer').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    }, 1000);
}

function loadCurrentCase() {
    const currentCase = gameState.cases[gameState.currentCase];
    document.getElementById('case-title').textContent = currentCase.name;
    document.getElementById('case-description').textContent = currentCase.description;
    updateProgress();
}

function startInvestigation() {
    document.getElementById('case-intro').classList.add('hidden');
    document.getElementById('investigation-interface').classList.remove('hidden');
    loadLocations();
    loadSuspects();
    showNotification('Investigasi dimulai! Pilih lokasi untuk mencari bukti.', 'success');
}

function loadLocations() {
    const currentCase = gameState.cases[gameState.currentCase];
    const locationGrid = document.getElementById('location-grid');
    
    locationGrid.innerHTML = currentCase.locations.map(location => `
        <div class="location-card bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded-lg p-4 cursor-pointer transition-all transform hover:scale-105" 
             data-location-id="${location.id}">
            <div class="text-3xl mb-2">${location.emoji}</div>
            <h4 class="font-bold text-green-300 mb-2">${location.name}</h4>
            <p class="text-gray-300 text-sm mb-3">${location.description}</p>
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-400">Bukti: ${location.evidence.length}</span>
                <span class="text-xs px-2 py-1 rounded ${getLocationStatus(location.id)}">${getLocationStatusText(location.id)}</span>
            </div>
        </div>
    `).join('');
}

function getLocationStatus(locationId) {
    const currentCase = gameState.cases[gameState.currentCase];
    const location = currentCase.locations.find(l => l.id === locationId);
    const evidenceIds = location.evidence.map(e => e.id);
    const collectedEvidence = gameState.evidenceCollected.filter(e => evidenceIds.includes(e.id));
    
    if (collectedEvidence.length === 0) return 'bg-red-600 text-white';
    if (collectedEvidence.length < location.evidence.length) return 'bg-yellow-600 text-white';
    return 'bg-green-600 text-white';
}

function getLocationStatusText(locationId) {
    const currentCase = gameState.cases[gameState.currentCase];
    const location = currentCase.locations.find(l => l.id === locationId);
    const evidenceIds = location.evidence.map(e => e.id);
    const collectedEvidence = gameState.evidenceCollected.filter(e => evidenceIds.includes(e.id));
    
    if (collectedEvidence.length === 0) return 'Belum Diperiksa';
    if (collectedEvidence.length < location.evidence.length) return 'Sebagian Diperiksa';
    return 'Selesai';
}

function loadSuspects() {
    const currentCase = gameState.cases[gameState.currentCase];
    const suspectsList = document.getElementById('suspects-list');
    
    suspectsList.innerHTML = currentCase.suspects.map(suspect => `
        <div class="suspect-card bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded-lg p-3 cursor-pointer transition-all" 
             data-suspect-id="${suspect.id}">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">${suspect.emoji}</span>
                    <div>
                        <h5 class="font-semibold text-orange-300">${suspect.name}</h5>
                        <p class="text-xs text-gray-400">${suspect.role}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs px-2 py-1 rounded ${getSuspectStatus(suspect.id)}">${getSuspectStatusText(suspect.id)}</span>
                </div>
            </div>
        </div>
    `).join('');
}

function getSuspectStatus(suspectId) {
    const interviewed = gameState.suspectsInterviewed.includes(suspectId);
    return interviewed ? 'bg-green-600 text-white' : 'bg-gray-600 text-white';
}

function getSuspectStatusText(suspectId) {
    const interviewed = gameState.suspectsInterviewed.includes(suspectId);
    return interviewed ? 'Sudah Diwawancara' : 'Belum Diwawancara';
}

function investigateLocation(locationId) {
    const currentCase = gameState.cases[gameState.currentCase];
    const location = currentCase.locations.find(l => l.id === locationId);
    
    if (!location) return;
    
    gameState.currentLocation = locationId;
    const resultsDiv = document.getElementById('investigation-results');
    const resultsContent = document.getElementById('results-content');
    
    // Show available evidence
    const unCollectedEvidence = location.evidence.filter(e => 
        !gameState.evidenceCollected.some(collected => collected.id === e.id)
    );
    
    if (unCollectedEvidence.length === 0) {
        resultsContent.innerHTML = `
            <div class="text-center text-blue-300">
                <div class="text-4xl mb-3">✅</div>
                <p>Lokasi ini telah selesai diselidiki.</p>
            </div>
        `;
    } else {
        resultsContent.innerHTML = `
            <div class="mb-4">
                <h4 class="text-xl font-bold text-blue-300 mb-3">📍 ${location.name}</h4>
                <p class="text-blue-200 mb-4">${location.description}</p>
            </div>
            <div class="space-y-3">
                ${unCollectedEvidence.map(evidence => `
                    <div class="evidence-item bg-blue-900 bg-opacity-50 border border-blue-400 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="text-2xl">${gameState.evidenceTypes[evidence.type].icon}</span>
                                    <h5 class="font-bold text-blue-200">${evidence.name}</h5>
                                    <span class="text-xs px-2 py-1 bg-blue-600 text-white rounded">${gameState.evidenceTypes[evidence.type].name}</span>
                                </div>
                                <p class="text-blue-300 text-sm mb-3">${evidence.description}</p>
                                <div class="flex items-center space-x-4 text-xs text-blue-400">
                                    <span>Poin: +${evidence.points}</span>
                                    <span>Tingkat: ${getDifficultyText(evidence.difficulty)}</span>
                                </div>
                            </div>
                            <button class="collect-evidence-btn bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded font-semibold transition-all" 
                                    data-evidence-id="${evidence.id}" data-location-id="${locationId}">
                                🔍 Kumpulkan
                            </button>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    resultsDiv.classList.remove('hidden');
    resultsDiv.scrollIntoView({ behavior: 'smooth' });
}

function getDifficultyText(difficulty) {
    const levels = {
        'easy': 'Mudah',
        'medium': 'Sedang',
        'hard': 'Sulit'
    };
    return levels[difficulty] || 'Sedang';
}

function collectEvidence(evidenceId, locationId) {
    const currentCase = gameState.cases[gameState.currentCase];
    const location = currentCase.locations.find(l => l.id === locationId);
    const evidence = location.evidence.find(e => e.id === evidenceId);
    
    if (!evidence || gameState.evidenceCollected.some(e => e.id === evidenceId)) return;
    
    // Add animation to button
    const btn = document.querySelector(`[data-evidence-id="${evidenceId}"]`);
    btn.classList.add('pulse-animation');
    btn.disabled = true;
    btn.innerHTML = '🔄 Mengumpulkan...';
    
    setTimeout(() => {
        // Add to collected evidence
        gameState.evidenceCollected.push({
            ...evidence,
            locationId: locationId,
            collectedAt: Date.now()
        });
        
        // Update score with animation
        gameState.score += evidence.points;
        const scoreElement = document.getElementById('current-score');
        scoreElement.style.transform = 'scale(1.2)';
        scoreElement.style.color = '#10B981';
        setTimeout(() => {
            scoreElement.style.transform = 'scale(1)';
            scoreElement.style.color = 'white';
            scoreElement.textContent = gameState.score;
        }, 300);
        
        // Update UI
        updateEvidenceBoard();
        updateProgress();
        loadLocations(); // Refresh location status
        
        // Show success notification
        showNotification(`Bukti "${evidence.name}" berhasil dikumpulkan! +${evidence.points} poin`, 'success');
        
        // Re-investigate location to update available evidence
        investigateLocation(locationId);
        
        // Check if enough evidence to solve case
        checkSolutionAvailable();
    }, 1000);
}

function updateEvidenceBoard() {
    const evidenceBoard = document.getElementById('evidence-board');
    
    if (gameState.evidenceCollected.length === 0) {
        evidenceBoard.innerHTML = '<div class="text-gray-400 text-sm">Belum ada bukti yang dikumpulkan...</div>';
        return;
    }
    
    evidenceBoard.innerHTML = gameState.evidenceCollected.map((evidence, index) => `
        <div class="evidence-card bg-yellow-900 bg-opacity-30 border border-yellow-600 rounded-lg p-3 evidence-found" style="animation-delay: ${index * 0.1}s">
            <div class="flex items-center space-x-3">
                <span class="text-xl">${gameState.evidenceTypes[evidence.type].icon}</span>
                <div class="flex-1">
                    <h6 class="font-semibold text-yellow-200">${evidence.name}</h6>
                    <p class="text-xs text-yellow-400">${gameState.evidenceTypes[evidence.type].name} • +${evidence.points} poin</p>
                </div>
            </div>
        </div>
    `).join('');
}

function updateProgress() {
    const currentCase = gameState.cases[gameState.currentCase];
    const totalEvidence = currentCase.locations.reduce((total, location) => total + location.evidence.length, 0);
    const collectedCount = gameState.evidenceCollected.length;
    
    document.getElementById('investigation-progress').textContent = `${collectedCount}/${totalEvidence}`;
    
    const progressPercentage = (collectedCount / totalEvidence) * 100;
    document.getElementById('progress-bar').style.width = `${progressPercentage}%`;
}

function interviewSuspect(suspectId) {
    const currentCase = gameState.cases[gameState.currentCase];
    const suspect = currentCase.suspects.find(s => s.id === suspectId);
    
    if (!suspect || gameState.suspectsInterviewed.includes(suspectId)) return;
    
    gameState.currentSuspect = suspectId;
    const interviewDiv = document.getElementById('interview-interface');
    const interviewContent = document.getElementById('interview-content');
    
    // Show first question
    showQuestion(suspect, 0);
    
    interviewDiv.classList.remove('hidden');
    interviewDiv.scrollIntoView({ behavior: 'smooth' });
}

function showQuestion(suspect, questionIndex) {
    if (questionIndex >= suspect.questions.length) {
        completeInterview(suspect);
        return;
    }
    
    const question = suspect.questions[questionIndex];
    const interviewContent = document.getElementById('interview-content');
    
    interviewContent.innerHTML = `
        <div class="mb-6">
            <div class="flex items-center space-x-4 mb-4">
                <span class="text-4xl">${suspect.emoji}</span>
                <div>
                    <h4 class="text-xl font-bold text-purple-200">${suspect.name}</h4>
                    <p class="text-purple-400">${suspect.role}</p>
                </div>
            </div>
            <div class="bg-purple-900 bg-opacity-30 rounded-lg p-4 mb-4">
                <p class="text-purple-200 font-semibold">"${question.question}"</p>
            </div>
        </div>
        <div class="space-y-3">
            <h5 class="text-purple-300 font-semibold">Pilih jawaban:</h5>
            ${question.answers.map((answer, index) => `
                <button class="answer-btn w-full text-left bg-purple-800 hover:bg-purple-700 border border-purple-600 rounded-lg p-3 transition-all"
                        data-question-index="${questionIndex}" data-answer-index="${index}" data-points="${answer.points}">
                    <span class="text-purple-200">${String.fromCharCode(65 + index)}. ${answer.text}</span>
                </button>
            `).join('')}
        </div>
    `;
}

function answerQuestion(suspect, questionIndex, answerIndex, points) {
    gameState.score += points;
    document.getElementById('current-score').textContent = gameState.score;
    
    const answer = suspect.questions[questionIndex].answers[answerIndex];
    const isCorrect = answer.correct;
    
    showNotification(
        `${isCorrect ? 'Jawaban benar!' : 'Jawaban kurang tepat.'} ${points > 0 ? '+' : ''}${points} poin`,
        isCorrect ? 'success' : 'warning'
    );
    
    // Wait a moment then show next question
    setTimeout(() => {
        showQuestion(suspect, questionIndex + 1);
    }, 1500);
}

function completeInterview(suspect) {
    gameState.suspectsInterviewed.push(suspect.id);
    
    const interviewContent = document.getElementById('interview-content');
    interviewContent.innerHTML = `
        <div class="text-center text-purple-300">
            <div class="text-4xl mb-3">✅</div>
            <p class="text-xl font-bold mb-2">Wawancara Selesai</p>
            <p>Anda telah mewawancarai ${suspect.name}.</p>
        </div>
    `;
    
    loadSuspects(); // Refresh suspects status
    checkSolutionAvailable();
}

function checkSolutionAvailable() {
    const currentCase = gameState.cases[gameState.currentCase];
    const solution = currentCase.solution;
    
    // Check if minimum score reached
    if (gameState.score >= solution.min_score_to_solve) {
        // Check if required evidence collected
        const hasRequiredEvidence = solution.evidence_required.every(evidenceId =>
            gameState.evidenceCollected.some(e => e.id === evidenceId)
        );
        
        if (hasRequiredEvidence) {
            showDeductionInterface();
        }
    }
}

function showDeductionInterface() {
    const deductionDiv = document.getElementById('deduction-interface');
    const deductionContent = document.getElementById('deduction-content');
    
    const currentCase = gameState.cases[gameState.currentCase];
    
    deductionContent.innerHTML = `
        <div class="mb-6">
            <p class="text-red-200 mb-4">Berdasarkan bukti yang telah dikumpulkan, siapa menurut Anda pelaku dalam kasus ini?</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                ${currentCase.suspects.map(suspect => `
                    <button class="suspect-choice-btn bg-red-800 hover:bg-red-700 border border-red-600 rounded-lg p-4 transition-all text-left"
                            data-suspect-id="${suspect.id}">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">${suspect.emoji}</span>
                            <div>
                                <h6 class="font-bold text-red-200">${suspect.name}</h6>
                                <p class="text-sm text-red-400">${suspect.role}</p>
                            </div>
                        </div>
                    </button>
                `).join('')}
            </div>
        </div>
        <div class="text-center">
            <p class="text-red-400 text-sm">Pilih dengan hati-hati - deduksi yang salah akan mengurangi skor Anda!</p>
        </div>
    `;
    
    deductionDiv.classList.remove('hidden');
    deductionDiv.scrollIntoView({ behavior: 'smooth' });
}

function makeFinalDeduction(suspectId) {
    const currentCase = gameState.cases[gameState.currentCase];
    const solution = currentCase.solution;
    
    const isCorrect = suspectId === solution.culprit;
    
    if (isCorrect) {
        gameState.score += gameState.scoring.case_solved;
        showCaseCompletion(true);
    } else {
        gameState.score -= 100; // Penalty for wrong deduction
        showCaseCompletion(false);
    }
    
    document.getElementById('current-score').textContent = gameState.score;
    gameState.gameComplete = true;
    
    // Update session in database
    updateGameSession();
}

function showCaseCompletion(solved) {
    const currentCase = gameState.cases[gameState.currentCase];
    const gameCompleteDiv = document.getElementById('game-complete');
    const completionMessage = document.getElementById('completion-message');
    const finalScore = document.getElementById('final-score');
    const finalTime = document.getElementById('final-time');
    const evidenceFoundSpan = document.getElementById('evidence-found');
    
    const totalEvidence = currentCase.locations.reduce((total, location) => total + location.evidence.length, 0);
    const timeElapsed = Date.now() - gameState.startTime;
    const minutes = Math.floor(timeElapsed / 60000);
    const seconds = Math.floor((timeElapsed % 60000) / 1000);
    
    if (solved) {
        completionMessage.textContent = `Selamat! Anda berhasil memecahkan kasus "${currentCase.name}". ${currentCase.solution.motive}`;
        gameCompleteDiv.classList.add('game-complete-animation');
        
        // Animate the stats with delays
        setTimeout(() => {
            finalScore.textContent = gameState.score;
            finalScore.parentElement.style.animation = 'bounceIn 0.6s ease';
        }, 200);
        
        setTimeout(() => {
            finalTime.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            finalTime.parentElement.style.animation = 'bounceIn 0.6s ease';
        }, 400);
        
        setTimeout(() => {
            evidenceFoundSpan.textContent = `${gameState.evidenceCollected.length}/${totalEvidence}`;
            evidenceFoundSpan.parentElement.style.animation = 'bounceIn 0.6s ease';
        }, 600);
        
    } else {
        completionMessage.textContent = `Deduksi Anda kurang tepat. Pelaku sebenarnya adalah ${currentCase.suspects.find(s => s.id === currentCase.solution.culprit).name}. ${currentCase.solution.motive}`;
        
        // Still show stats but without celebration
        finalScore.textContent = gameState.score;
        finalTime.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        evidenceFoundSpan.textContent = `${gameState.evidenceCollected.length}/${totalEvidence}`;
    }
    
    // Hide other interfaces with fade out animation
    const interfacesToHide = ['investigation-interface'];
    interfacesToHide.forEach((interfaceId, index) => {
        setTimeout(() => {
            const element = document.getElementById(interfaceId);
            element.style.opacity = '0';
            element.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                element.classList.add('hidden');
            }, 300);
        }, index * 100);
    });
    
    // Show game complete with fade in
    setTimeout(() => {
        gameCompleteDiv.classList.remove('hidden');
        gameCompleteDiv.style.opacity = '0';
        gameCompleteDiv.style.transform = 'translateY(20px)';
        setTimeout(() => {
            gameCompleteDiv.style.opacity = '1';
            gameCompleteDiv.style.transform = 'translateY(0)';
        }, 100);
        gameCompleteDiv.scrollIntoView({ behavior: 'smooth' });
    }, 800);
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all transform translate-x-full notification-enter`;
    
    const colors = {
        'success': 'bg-green-600 text-white border-l-4 border-green-400',
        'warning': 'bg-yellow-600 text-black border-l-4 border-yellow-400',
        'error': 'bg-red-600 text-white border-l-4 border-red-400',
        'info': 'bg-blue-600 text-white border-l-4 border-blue-400'
    };
    
    const icons = {
        'success': '✅',
        'warning': '⚠️',
        'error': '❌',
        'info': 'ℹ️'
    };
    
    notification.className += ` ${colors[type]}`;
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <span class="text-lg">${icons[type]}</span>
            <span class="font-semibold">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        notification.classList.add('notification-exit');
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function updateGameSession() {
    // Send progress to server
    fetch(`/game/{{ $game->slug }}/progress`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            progress_data: {
                currentCase: gameState.currentCase,
                evidenceCollected: gameState.evidenceCollected,
                suspectsInterviewed: gameState.suspectsInterviewed,
                gameComplete: gameState.gameComplete
            },
            score: gameState.score,
            time_spent: Math.floor((Date.now() - gameState.startTime) / 1000)
        })
    }).catch(error => console.error('Failed to update session:', error));
}

// Event listeners
function setupEventListeners() {
    document.addEventListener('click', function(e) {
        // Start investigation
        if (e.target.id === 'start-investigation') {
            startInvestigation();
        }
        
        // Location investigation
        if (e.target.closest('.location-card')) {
            const locationId = e.target.closest('.location-card').dataset.locationId;
            investigateLocation(locationId);
        }
        
        // Evidence collection
        if (e.target.classList.contains('collect-evidence-btn')) {
            const evidenceId = e.target.dataset.evidenceId;
            const locationId = e.target.dataset.locationId;
            collectEvidence(evidenceId, locationId);
        }
        
        // Suspect interview
        if (e.target.closest('.suspect-card')) {
            const suspectId = e.target.closest('.suspect-card').dataset.suspectId;
            interviewSuspect(suspectId);
        }
        
        // Answer questions
        if (e.target.classList.contains('answer-btn')) {
            const questionIndex = parseInt(e.target.dataset.questionIndex);
            const answerIndex = parseInt(e.target.dataset.answerIndex);
            const points = parseInt(e.target.dataset.points);
            
            const currentCase = gameState.cases[gameState.currentCase];
            const suspect = currentCase.suspects.find(s => s.id === gameState.currentSuspect);
            
            answerQuestion(suspect, questionIndex, answerIndex, points);
        }
        
        // Final deduction
        if (e.target.classList.contains('suspect-choice-btn')) {
            const suspectId = e.target.dataset.suspectId;
            makeFinalDeduction(suspectId);
        }
        
        // Next case
        if (e.target.id === 'next-case') {
            if (gameState.currentCase + 1 < gameState.cases.length) {
                gameState.currentCase++;
                resetGameState();
                loadCurrentCase();
                document.getElementById('game-complete').classList.add('hidden');
                document.getElementById('case-intro').classList.remove('hidden');
                document.getElementById('current-case').textContent = gameState.currentCase + 1;
            } else {
                showNotification('Selamat! Anda telah menyelesaikan semua kasus!', 'success');
            }
        }
    });
}

function resetGameState() {
    gameState.evidenceCollected = [];
    gameState.suspectsInterviewed = [];
    gameState.currentLocation = null;
    gameState.currentSuspect = null;
    gameState.gameComplete = false;
    gameState.startTime = Date.now();
    
    // Reset UI
    updateEvidenceBoard();
    updateProgress();
    document.getElementById('investigation-results').classList.add('hidden');
    document.getElementById('interview-interface').classList.add('hidden');
    document.getElementById('deduction-interface').classList.add('hidden');
}
</script>
@endpush
@endsection