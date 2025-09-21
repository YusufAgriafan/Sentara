<!-- Places Section -->
<section id="places" class="py-20 px-6 lg:px-8 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20 fade-in-up">
            <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Tempat Hits Bersejarah! 📍</h2>
            <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Explore tempat-tempat kece yang wajib masuk bucket list-mu!</p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="fade-in-up">
                <div class="bg-white rounded-3xl p-10 shadow-lg">
                    <h3 class="text-3xl font-bold text-gray-900 mb-8">Fitur Keren di Peta! 🗺️</h3>
                    <div class="space-y-6">
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-quaternary rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-pin text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Lokasi Tepat</h4>
                                <p class="text-gray-600">GPS akurat biar gak nyasar pas mau berkunjung!</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-tertiary/30 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-camera text-secondary text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Foto Aesthetic</h4>
                                <p class="text-gray-600">Galeri foto yang Instagramable abis!</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-star text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Review Jujur</h4>
                                <p class="text-gray-600">Rating dan review dari pengunjung lain yang honest!</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('geografi') }}" class="mt-10 bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 w-full block text-center">
                        <i class="fas fa-compass mr-3"></i>
                        Explore Sekarang!
                    </a>
                </div>
            </div>
            
            <div class="fade-in-up" style="animation-delay: 0.3s;">
                <div class="bg-quaternary/20 rounded-3xl p-12 text-center relative overflow-hidden">
                    <div class="absolute top-4 left-4 w-20 h-20 bg-primary/20 rounded-full"></div>
                    <div class="absolute bottom-4 right-4 w-16 h-16 bg-secondary/30 rounded-full"></div>
                    <div class="absolute top-1/2 right-8 w-12 h-12 bg-tertiary/40 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="text-8xl mb-8">🗺️</div>
                        <h3 class="text-3xl font-bold text-primary mb-6">Peta Interaktif</h3>
                        <p class="text-gray-700 text-xl leading-relaxed">Jelajahi Indonesia dari Sabang sampai Merauke dengan teknologi peta modern yang user-friendly!</p>
                        
                        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                            <div class="bg-white rounded-2xl p-4">
                                <div class="text-2xl font-bold text-primary">500+</div>
                                <p class="text-gray-600 text-sm">Lokasi</p>
                            </div>
                            <div class="bg-white rounded-2xl p-4">
                                <div class="text-2xl font-bold text-secondary">34</div>
                                <p class="text-gray-600 text-sm">Provinsi</p>
                            </div>
                            <div class="bg-white rounded-2xl p-4">
                                <div class="text-2xl font-bold text-tertiary">100%</div>
                                <p class="text-gray-600 text-sm">Akurat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>