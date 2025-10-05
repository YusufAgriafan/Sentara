<!-- Stories Section -->
<section id="stories" class="py-20 px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20 fade-in-up">
            <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Konten Edukatif Pilihan! 📚</h2>
            <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Materi sejarah yang dikurasi guru untuk pembelajaran yang efektif dan menarik!</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Story Card 1 -->
            <div class="bg-primary text-white rounded-3xl p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 fade-in-up relative overflow-hidden">
                <div class="absolute top-4 right-4 text-6xl opacity-30">👑</div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <div class="text-3xl">🏰</div>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Cerita Era Kerajaan</h3>
                    <p class="text-white/90 leading-relaxed mb-8 text-lg">Jelajahi tempat bersejarah seperti Candi Borobudur dan Prambanan dengan cerita interaktif yang telah di-assign guru!</p>
                    <a href="{{ route('register') }}" class="bg-white text-primary hover:bg-white/90 px-6 py-3 rounded-2xl transition-all duration-300 font-semibold inline-flex items-center">
                        Akses Kelas <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Story Card 2 -->
            <div class="bg-secondary text-primary rounded-3xl p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 fade-in-up relative overflow-hidden" style="animation-delay: 0.2s;">
                <div class="absolute top-4 right-4 text-6xl opacity-30">⚔️</div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center mb-6">
                        <div class="text-3xl">🛡️</div>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Era Kemerdekaan</h3>
                    <p class="text-primary/80 leading-relaxed mb-8 text-lg">Kunjungi virtual Monumen Nasional dan tempat bersejarah lainnya dengan koordinat peta yang akurat!</p>
                    <a href="{{ route('register') }}" class="bg-primary text-white hover:bg-primary/90 px-6 py-3 rounded-2xl transition-all duration-300 font-semibold inline-flex items-center">
                        Bergabung Kelas <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Story Card 3 -->
            <div class="bg-tertiary text-white rounded-3xl p-10 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 fade-in-up relative overflow-hidden md:col-span-2 lg:col-span-1" style="animation-delay: 0.4s;">
                <div class="absolute top-4 right-4 text-6xl opacity-30">🚢</div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <div class="text-3xl">🌊</div>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Game Edukatif</h3>
                    <p class="text-white/90 leading-relaxed mb-8 text-lg">Mainkan game Time Travel, Geography Puzzle, dan Historical Detective untuk belajar sejarah dengan cara yang menyenangkan!</p>
                    <a href="{{ route('register') }}" class="bg-white text-tertiary hover:bg-white/90 px-6 py-3 rounded-2xl transition-all duration-300 font-semibold inline-flex items-center">
                        Mulai Belajar <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>