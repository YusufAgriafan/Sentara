@extends('layouts.main')

@section('title', 'Geografi Indonesia')

@section('content')
    <!-- Hero Section for Geografi -->
    <section class="pt-32 pb-20 px-6 lg:px-8 bg-gradient-to-br from-secondary to-tertiary text-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">🗺️</div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight">
                    Explore <span class="text-quaternary">Geografi</span> Indonesia
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Jelajahi keindahan alam Indonesia dari Sabang sampai Merauke! Temukan tempat-tempat bersejarah yang Instagramable banget!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button onclick="scrollToSection('map')" class="bg-white hover:bg-gray-100 text-secondary px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-map mr-3"></i>
                        Buka Peta
                    </button>
                    <button onclick="scrollToSection('places')" class="bg-white/20 hover:bg-white/30 text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 backdrop-blur-sm border border-white/30">
                        <i class="fas fa-camera mr-3"></i>
                        Lihat Tempat Hits
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Map Section -->
    <section id="map" class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Peta Interaktif Indonesia 🌏</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Klik dan jelajahi setiap provinsi untuk menemukan tempat bersejarah tersembunyi!</p>
            </div>
            
            <div class="bg-gradient-to-br from-quaternary/20 to-secondary/20 rounded-3xl p-8 lg:p-12 fade-in-up">
                <div class="grid lg:grid-cols-3 gap-12 items-center">
                    <div class="lg:col-span-2">
                        <!-- Placeholder for Interactive Map -->
                        <div class="bg-white rounded-2xl p-8 shadow-lg text-center">
                            <div class="text-8xl mb-6">🗺️</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Peta Indonesia Interaktif</h3>
                            <p class="text-gray-600 mb-8">Klik pada provinsi untuk melihat tempat bersejarah di daerah tersebut!</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                <button class="bg-primary/10 hover:bg-primary/20 text-primary px-4 py-2 rounded-lg transition-colors">Sumatera</button>
                                <button class="bg-secondary/10 hover:bg-secondary/20 text-secondary px-4 py-2 rounded-lg transition-colors">Jawa</button>
                                <button class="bg-tertiary/10 hover:bg-tertiary/20 text-tertiary px-4 py-2 rounded-lg transition-colors">Kalimantan</button>
                                <button class="bg-primary/10 hover:bg-primary/20 text-primary px-4 py-2 rounded-lg transition-colors">Sulawesi</button>
                                <button class="bg-secondary/10 hover:bg-secondary/20 text-secondary px-4 py-2 rounded-lg transition-colors">Bali & Nusa</button>
                                <button class="bg-tertiary/10 hover:bg-tertiary/20 text-tertiary px-4 py-2 rounded-lg transition-colors">Papua</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <h4 class="text-xl font-bold text-gray-900 mb-4">📊 Statistik Keren</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Provinsi</span>
                                    <span class="font-bold text-primary">34</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Tempat Bersejarah</span>
                                    <span class="font-bold text-secondary">500+</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Pulau Besar</span>
                                    <span class="font-bold text-tertiary">17,508</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <h4 class="text-xl font-bold text-gray-900 mb-4">🏆 Top Destinasi</h4>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">1</span>
                                    <span class="text-gray-700">Borobudur, Jawa Tengah</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center text-white font-bold text-sm">2</span>
                                    <span class="text-gray-700">Prambanan, Yogyakarta</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 bg-tertiary rounded-full flex items-center justify-center text-white font-bold text-sm">3</span>
                                    <span class="text-gray-700">Istana Maimun, Medan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Places Section -->
    <section id="places" class="py-20 px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Tempat Hits Bersejarah! 📸</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Destinasi yang wajib masuk bucket list dan feed Instagram kamu!</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Place Card 1 -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover-lift fade-in-up">
                    <div class="bg-gradient-to-br from-primary to-secondary h-48 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-6xl mb-4">🏛️</div>
                            <h3 class="text-xl font-bold">Candi Borobudur</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-sm font-medium">Jawa Tengah</span>
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star mr-1"></i>
                                <span class="font-semibold">4.9</span>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">Candi Buddha terbesar di dunia yang bikin kamu speechless! Perfect buat sunrise hunting dan foto aesthetic.</p>
                        <button class="w-full bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lihat Lokasi
                        </button>
                    </div>
                </div>

                <!-- Place Card 2 -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover-lift fade-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-gradient-to-br from-secondary to-tertiary h-48 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-6xl mb-4">🕌</div>
                            <h3 class="text-xl font-bold">Masjid Menara Kudus</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-secondary/20 text-secondary px-3 py-1 rounded-full text-sm font-medium">Jawa Tengah</span>
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star mr-1"></i>
                                <span class="font-semibold">4.7</span>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">Masjid unik dengan arsitektur campuran Hindu-Islam. Menara yang iconic banget buat foto OOTD!</p>
                        <button class="w-full bg-secondary hover:bg-secondary/90 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lihat Lokasi
                        </button>
                    </div>
                </div>

                <!-- Place Card 3 -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover-lift fade-in-up" style="animation-delay: 0.4s;">
                    <div class="bg-gradient-to-br from-tertiary to-primary h-48 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-6xl mb-4">🏰</div>
                            <h3 class="text-xl font-bold">Istana Maimun</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-tertiary/20 text-tertiary px-3 py-1 rounded-full text-sm font-medium">Medan</span>
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star mr-1"></i>
                                <span class="font-semibold">4.8</span>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">Istana Sultan Deli yang megah dengan arsitektur Melayu-Islam. Vibes kerajaan yang elegant!</p>
                        <button class="w-full bg-tertiary hover:bg-tertiary/90 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lihat Lokasi
                        </button>
                    </div>
                </div>

                <!-- Place Card 4 -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover-lift fade-in-up" style="animation-delay: 0.6s;">
                    <div class="bg-gradient-to-br from-quaternary to-primary h-48 flex items-center justify-center">
                        <div class="text-primary text-center">
                            <div class="text-6xl mb-4">⛩️</div>
                            <h3 class="text-xl font-bold">Candi Prambanan</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-quaternary text-primary px-3 py-1 rounded-full text-sm font-medium">Yogyakarta</span>
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star mr-1"></i>
                                <span class="font-semibold">4.8</span>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">Kompleks candi Hindu terbesar di Indonesia. Relief cerita Ramayana yang epic banget!</p>
                        <button class="w-full bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lihat Lokasi
                        </button>
                    </div>
                </div>

                <!-- Place Card 5 -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover-lift fade-in-up" style="animation-delay: 0.8s;">
                    <div class="bg-gradient-to-br from-primary to-tertiary h-48 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-6xl mb-4">🏛️</div>
                            <h3 class="text-xl font-bold">Keraton Ngayogyakarta</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-sm font-medium">Yogyakarta</span>
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star mr-1"></i>
                                <span class="font-semibold">4.9</span>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">Istana Sultan Yogya yang masih aktif sampai sekarang. Museum dan budaya Jawa yang autentik!</p>
                        <button class="w-full bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lihat Lokasi
                        </button>
                    </div>
                </div>

                <!-- Place Card 6 -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover-lift fade-in-up" style="animation-delay: 1s;">
                    <div class="bg-gradient-to-br from-secondary to-quaternary h-48 flex items-center justify-center">
                        <div class="text-secondary text-center">
                            <div class="text-6xl mb-4">🏯</div>
                            <h3 class="text-xl font-bold">Benteng Vredeburg</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-secondary/20 text-secondary px-3 py-1 rounded-full text-sm font-medium">Yogyakarta</span>
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star mr-1"></i>
                                <span class="font-semibold">4.6</span>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">Benteng kolonial Belanda yang sekarang jadi museum. Architecture dan sejarah dalam satu tempat!</p>
                        <button class="w-full bg-secondary hover:bg-secondary/90 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lihat Lokasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Travel Tips Section -->
    <section class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Tips Traveling! ✈️</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Hacks biar trip sejarah kamu makin seru dan hemat!</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Tip 1 -->
                <div class="bg-primary/10 rounded-3xl p-6 text-center fade-in-up">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Budget Smart</h3>
                    <p class="text-gray-600 text-sm">Cari promo tiket masuk dan paket bundling biar hemat tapi tetap puas!</p>
                </div>

                <!-- Tip 2 -->
                <div class="bg-secondary/10 rounded-3xl p-6 text-center fade-in-up" style="animation-delay: 0.2s;">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">App Helpful</h3>
                    <p class="text-gray-600 text-sm">Download audio guide dan app AR buat pengalaman yang lebih immersive!</p>
                </div>

                <!-- Tip 3 -->
                <div class="bg-tertiary/10 rounded-3xl p-6 text-center fade-in-up" style="animation-delay: 0.4s;">
                    <div class="text-4xl mb-4">🌅</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Best Time</h3>
                    <p class="text-gray-600 text-sm">Datang pagi atau sore biar dapat cahaya terbaik dan less crowded!</p>
                </div>

                <!-- Tip 4 -->
                <div class="bg-quaternary/40 rounded-3xl p-6 text-center fade-in-up" style="animation-delay: 0.6s;">
                    <div class="text-4xl mb-4">👗</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dress Code</h3>
                    <p class="text-gray-600 text-sm">Pakai outfit yang sopan dan nyaman, plus sepatu yang enak buat jalan!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Virtual Reality Section -->
    <section class="py-20 px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="bg-gradient-to-r from-primary via-secondary to-tertiary rounded-3xl p-8 lg:p-16 text-white text-center fade-in-up">
                <div class="text-8xl mb-8">🥽</div>
                <h2 class="text-4xl lg:text-6xl font-bold mb-8">Virtual Reality Experience!</h2>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-3xl mx-auto">
                    Gak bisa traveling langsung? Tenang! Explore tempat bersejarah pakai VR dari rumah. Immersive experience yang bikin kamu merasa ada di sana!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button class="bg-white hover:bg-gray-100 text-primary px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105">
                        <i class="fas fa-vr-cardboard mr-3"></i>
                        Coba VR Tour
                    </button>
                    <button class="bg-white/20 hover:bg-white/30 text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 backdrop-blur-sm border border-white/30">
                        <i class="fas fa-download mr-3"></i>
                        Download App
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection