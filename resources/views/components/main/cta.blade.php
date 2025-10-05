<!-- CTA Section -->
<section class="py-20 px-6 lg:px-8 bg-primary text-white">
    <div class="max-w-4xl mx-auto text-center fade-in-up">
        <div class="text-6xl mb-8">🎓</div>
        <h2 class="text-4xl lg:text-6xl font-bold mb-6">Siap Bergabung?</h2>
        <p class="text-xl lg:text-2xl text-white/90 mb-12">Daftar sebagai siswa untuk bergabung dengan kelas, atau sebagai guru untuk mengelola konten pembelajaran!</p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-primary px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-user-graduate mr-3"></i>
                    Daftar Sebagai Siswa
                </a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="bg-secondary hover:bg-secondary/90 text-primary px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-chalkboard-teacher mr-3"></i>
                    Daftar Sebagai Guru
                </a>
            @endif
        </div>
        
    </div>
</section>