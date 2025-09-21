<!-- Stories Section -->
<section id="stories" class="py-20 px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20 fade-in-up">
            <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Cerita Favorit Anak Muda! 🔥</h2>
            <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Dari kerajaan kuno sampai perjuangan kemerdekaan, semua dikemas dengan gaya yang asik!</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Story Card 1 -->
            <div class="bg-primary text-white rounded-3xl p-8 hover-lift fade-in-up relative overflow-hidden">
                <div class="absolute top-0 right-0 text-6xl opacity-20">👑</div>
                <div class="relative z-10">
                    <div class="text-4xl mb-6">🏰</div>
                    <h3 class="text-2xl font-bold mb-4">Kerajaan Kuno</h3>
                    <p class="text-white/90 leading-relaxed mb-6">Gimana rasanya jadi raja di Majapahit? Yuk intip kehidupan istana yang mewah dan penuh intriga!</p>
                    <a href="{{ route('sejarah') }}" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-xl transition-colors backdrop-blur-sm font-medium inline-block">
                        Baca Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Story Card 2 -->
            <div class="bg-secondary text-white rounded-3xl p-8 hover-lift fade-in-up relative overflow-hidden" style="animation-delay: 0.2s;">
                <div class="absolute top-0 right-0 text-6xl opacity-20">⚔️</div>
                <div class="relative z-10">
                    <div class="text-4xl mb-6">🛡️</div>
                    <h3 class="text-2xl font-bold mb-4">Pahlawan Keren</h3>
                    <p class="text-white/90 leading-relaxed mb-6">Kisah heroik Cut Nyak Dien yang berani melawan penjajah! Inspiring banget deh pokoknya!</p>
                    <a href="{{ route('sejarah') }}" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-xl transition-colors backdrop-blur-sm font-medium inline-block">
                        Baca Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Story Card 3 -->
            <div class="bg-tertiary text-white rounded-3xl p-8 hover-lift fade-in-up relative overflow-hidden md:col-span-2 lg:col-span-1" style="animation-delay: 0.4s;">
                <div class="absolute top-0 right-0 text-6xl opacity-20">🚢</div>
                <div class="relative z-10">
                    <div class="text-4xl mb-6">🌊</div>
                    <h3 class="text-2xl font-bold mb-4">Pelaut Legendaris</h3>
                    <p class="text-white/90 leading-relaxed mb-6">Petualangan seru di lautan luas! Gimana caranya nenek moyang kita bisa jago banget berlayar?</p>
                    <a href="{{ route('sejarah') }}" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-xl transition-colors backdrop-blur-sm font-medium inline-block">
                        Baca Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>