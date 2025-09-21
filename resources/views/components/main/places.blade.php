<!-- Places Section -->
<section id="places" class="py-20 px-6 lg:px-8 bg-gray-50">
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
                            <div class="w-16 h-16 bg-quaternary rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Konten Terpilih</h4>
                                <p class="text-gray-600">Tempat bersejarah yang sudah dikurasi guru sesuai materi pembelajaran!</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-tertiary/30 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-book-open text-secondary text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Info Edukatif</h4>
                                <p class="text-gray-600">Penjelasan lengkap dan mendalam untuk pembelajaran optimal!</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-users text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Akses Kelas</h4>
                                <p class="text-gray-600">Hanya tersedia untuk anggota kelas yang sudah terdaftar!</p>
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
                <div class="bg-quaternary/20 rounded-3xl p-12 text-center relative overflow-hidden">
                    <div class="absolute top-4 left-4 w-20 h-20 bg-primary/20 rounded-full"></div>
                    <div class="absolute bottom-4 right-4 w-16 h-16 bg-secondary/30 rounded-full"></div>
                    <div class="absolute top-1/2 right-8 w-12 h-12 bg-tertiary/40 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="text-8xl mb-8">🏫</div>
                        <h3 class="text-3xl font-bold text-primary mb-6">Sistem Pembelajaran</h3>
                        <p class="text-gray-700 text-xl leading-relaxed">Platform edukatif terstruktur untuk pembelajaran sejarah yang efektif dan terarah!</p>
                        
                        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                            <div class="bg-white rounded-2xl p-4">
                                <div class="text-2xl font-bold text-primary">Kelas</div>
                                <p class="text-gray-600 text-sm">Berbasis</p>
                            </div>
                            <div class="bg-white rounded-2xl p-4">
                                <div class="text-2xl font-bold text-secondary">Guru</div>
                                <p class="text-gray-600 text-sm">Mengelola</p>
                            </div>
                            <div class="bg-white rounded-2xl p-4">
                                <div class="text-2xl font-bold text-tertiary">Siswa</div>
                                <p class="text-gray-600 text-sm">Belajar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>