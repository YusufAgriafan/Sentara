<!-- Places Section -->
<section id="places" class="py-20 px-6 lg:px-8 bg-quaternary">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20 fade-in-up">
            <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Tempat Bersejarah Pilihan! 📍</h2>
            <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Akses koleksi tempat bersejarah yang telah dipilih guru untuk pembelajaran di kelasmu!</p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="fade-in-up">
                <div class="bg-white rounded-3xl p-10 shadow-lg">
                    <h3 class="text-3xl font-bold text-gray-900 mb-8">Fitur Pembelajaran! 🗺️</h3>
                    <div class="space-y-6">
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-white text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Assignment System</h4>
                                <p class="text-gray-600">Guru dapat assign tempat bersejarah dan cerita sejarah khusus untuk kelasmu!</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-book-open text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Peta Interaktif</h4>
                                <p class="text-gray-600">Setiap tempat bersejarah dilengkapi koordinat latitude/longitude yang akurat!</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-tertiary rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Diskusi Kelas</h4>
                                <p class="text-gray-600">Ikuti diskusi terarah dengan teman sekelas tentang topik sejarah tertentu!</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="mt-10 bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 w-full block text-center">
                        <i class="fas fa-graduation-cap mr-3"></i>
                        Bergabung Sekarang!
                    </a>
                </div>
            </div>
            
            <div class="fade-in-up" style="animation-delay: 0.3s;">
                <div class="bg-white rounded-3xl p-12 text-center relative overflow-hidden">
                    <div class="absolute top-4 left-4 w-20 h-20 bg-primary rounded-full"></div>
                    <div class="absolute bottom-4 right-4 w-16 h-16 bg-secondary rounded-full"></div>
                    <div class="absolute top-1/2 right-8 w-12 h-12 bg-tertiary rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="text-8xl mb-8">🏫</div>
                        <h3 class="text-3xl font-bold text-primary mb-6">Sistem Pembelajaran</h3>
                        <p class="text-gray-700 text-xl leading-relaxed">Platform edukatif terstruktur untuk pembelajaran sejarah yang efektif dan terarah!</p>
                        
                        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                            <div class="bg-primary rounded-2xl p-4">
                                <div class="text-2xl font-bold text-white">Kelas</div>
                                <p class="text-white/80 text-sm">Berbasis</p>
                            </div>
                            <div class="bg-secondary rounded-2xl p-4">
                                <div class="text-2xl font-bold text-primary">Guru</div>
                                <p class="text-primary/80 text-sm">Mengelola</p>
                            </div>
                            <div class="bg-tertiary rounded-2xl p-4">
                                <div class="text-2xl font-bold text-white">Siswa</div>
                                <p class="text-white/80 text-sm">Belajar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>