<!-- CTA Section -->
<section class="py-20 px-6 lg:px-8 bg-primary text-white">
    <div class="max-w-4xl mx-auto text-center fade-in-up">
        <div class="text-6xl mb-8">🚀</div>
        <h2 class="text-4xl lg:text-6xl font-bold mb-6">Siap Mulai Petualangan?</h2>
        <p class="text-xl lg:text-2xl text-white/90 mb-12">Gabung sama ribuan remaja lainnya dan mulai jelajahi sejarah Indonesia dengan cara yang seru!</p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-primary px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-user-plus mr-3"></i>
                    Daftar Gratis Sekarang!
                </a>
            @endif
            <button onclick="scrollToSection('home')" class="bg-white/20 hover:bg-white/30 text-white px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 backdrop-blur-sm border border-white/30">
                <i class="fas fa-arrow-up mr-3"></i>
                Kembali ke Atas
            </button>
        </div>
        
        <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl font-bold mb-2">1000+</div>
                <p class="text-white/80">Pengguna Aktif</p>
            </div>
            <div>
                <div class="text-3xl font-bold mb-2">50+</div>
                <p class="text-white/80">Cerita Seru</p>
            </div>
            <div>
                <div class="text-3xl font-bold mb-2">100+</div>
                <p class="text-white/80">Tempat Bersejarah</p>
            </div>
            <div>
                <div class="text-3xl font-bold mb-2">24/7</div>
                <p class="text-white/80">Akses Kapan Saja</p>
            </div>
        </div>
    </div>
</section>