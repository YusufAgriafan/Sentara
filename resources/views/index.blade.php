<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sentara') }} - Jelajahi Sejarah Indonesia</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .bounce-in {
            animation: bounceIn 0.8s ease-out;
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.open {
            transform: translateX(0);
        }
        
        .hamburger span {
            transition: all 0.3s ease;
        }
        
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
    </style>
</head>

<body class="font-sans antialiased bg-white overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-gradient-to-r from-primary via-secondary to-tertiary shadow-lg">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-3xl font-bold text-white">
                            <i class="fas fa-location-crosshairs mr-2 text-quaternary"></i>
                            Sentara
                        </h1>
                    </div>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden lg:block">
                    <div class="ml-10 flex items-center space-x-8">
                        <a href="#home" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10">Beranda</a>
                        <a href="#features" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10">Fitur</a>
                        <a href="#stories" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10">Cerita</a>
                        <a href="#places" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10">Tempat</a>
                    </div>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-white text-primary hover:bg-gray-100 px-6 py-3 rounded-xl text-lg font-medium transition-all duration-300 hover:scale-105">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-quaternary px-4 py-3 rounded-xl text-lg font-medium transition-colors">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white hover:bg-white/90 text-primary px-6 py-3 rounded-xl text-lg font-medium transition-all duration-300 hover:scale-105">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button id="mobile-menu-btn" class="hamburger p-2">
                        <span class="block w-6 h-0.5 bg-white mb-1"></span>
                        <span class="block w-6 h-0.5 bg-white mb-1"></span>
                        <span class="block w-6 h-0.5 bg-white"></span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu" class="mobile-menu fixed top-0 right-0 h-full w-80 bg-gradient-to-b from-primary via-secondary to-tertiary shadow-2xl lg:hidden z-40">
            <div class="p-8 pt-24">
                <div class="space-y-6">
                    <a href="#home" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10">Beranda</a>
                    <a href="#features" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10">Fitur</a>
                    <a href="#stories" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10">Cerita</a>
                    <a href="#places" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10">Tempat</a>
                </div>
                
                <div class="mt-12 space-y-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block bg-white text-primary hover:bg-gray-100 px-6 py-4 rounded-xl text-lg font-medium text-center transition-all duration-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block text-white hover:text-quaternary px-6 py-4 rounded-xl text-lg font-medium text-center transition-colors border border-white/20">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block bg-white hover:bg-white/90 text-primary px-6 py-4 rounded-xl text-lg font-medium text-center transition-all duration-300">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Backdrop -->
        <div id="mobile-backdrop" class="fixed inset-0 bg-black/50 z-30 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="fade-in-up">
                    <div class="mb-8">
                        <span class="inline-block bg-quaternary text-primary px-6 py-2 rounded-full text-lg font-medium mb-6">
                            🎉 Jelajahi Sejarah Indonesia
                        </span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 mb-8 leading-tight">
                        Temukan 
                        <span class="text-primary">Cerita</span> 
                        <span class="text-secondary">Seru</span> 
                        dari Masa Lalu
                    </h1>
                    
                    <p class="text-xl lg:text-2xl text-gray-600 mb-12 leading-relaxed">
                        Bergabung dengan ribuan remaja untuk menjelajahi sejarah Indonesia melalui cerita interaktif, tempat bersejarah, dan diskusi seru! 📚✨
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-6">
                        <button onclick="scrollToSection('stories')" class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                            <i class="fas fa-book-open mr-3"></i>
                            Mulai Jelajah
                        </button>
                        
                        <button onclick="scrollToSection('features')" class="bg-white border-2 border-secondary text-secondary hover:bg-secondary hover:text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105">
                            <i class="fas fa-play mr-3"></i>
                            Lihat Demo
                        </button>
                    </div>
                </div>
                
                <div class="fade-in-up lg:order-first" style="animation-delay: 0.3s;">
                    <div class="relative">
                        <!-- Main illustration container -->
                        <div class="bg-tertiary/20 rounded-3xl p-12 text-center relative overflow-hidden">
                            <div class="absolute top-4 left-4 w-16 h-16 bg-quaternary rounded-full opacity-60"></div>
                            <div class="absolute bottom-4 right-4 w-20 h-20 bg-secondary/30 rounded-full opacity-60"></div>
                            <div class="absolute top-1/2 right-8 w-12 h-12 bg-primary/40 rounded-full opacity-60"></div>
                            
                            <div class="relative z-10">
                                <div class="text-8xl mb-6">🏛️</div>
                                <h3 class="text-2xl font-bold text-primary mb-4">Petualangan Sejarah</h3>
                                <p class="text-gray-600 text-lg">Temukan fakta unik dan cerita menarik dari masa lalu Indonesia</p>
                            </div>
                        </div>
                        
                        <!-- Floating elements -->
                        <div class="absolute -top-4 -right-4 bg-quaternary text-primary px-4 py-2 rounded-2xl font-bold text-lg bounce-in" style="animation-delay: 1s;">
                            Cool! 😎
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-secondary text-white px-4 py-2 rounded-2xl font-bold text-lg bounce-in" style="animation-delay: 1.5s;">
                            Fun! 🎉
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20 fade-in-up">
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Kenapa Pilih Sentara? 🤔</h2>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto">Platform belajar sejarah yang bikin kamu ketagihan belajar!</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up">
                    <div class="bg-primary w-20 h-20 rounded-2xl flex items-center justify-center mb-8 mx-auto">
                        <i class="fas fa-book text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Cerita Seru 📖</h3>
                    <p class="text-gray-600 leading-relaxed text-center text-lg">Baca cerita sejarah yang dikemas dengan gaya bahasa kekinian dan ilustrasi menarik yang bikin kamu betah berlama-lama!</p>
                    <div class="mt-6 text-center">
                        <span class="inline-block bg-quaternary text-primary px-4 py-2 rounded-full text-sm font-medium">
                            #SerúAbis
                        </span>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-secondary w-20 h-20 rounded-2xl flex items-center justify-center mb-8 mx-auto">
                        <i class="fas fa-map-marked-alt text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Jelajah Tempat 🗺️</h3>
                    <p class="text-gray-600 leading-relaxed text-center text-lg">Eksplorasi tempat-tempat bersejarah dengan peta interaktif dan info lengkap yang bisa jadi referensi jalan-jalan kamu!</p>
                    <div class="mt-6 text-center">
                        <span class="inline-block bg-tertiary/20 text-secondary px-4 py-2 rounded-full text-sm font-medium">
                            #JalanJalan
                        </span>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up md:col-span-2 lg:col-span-1" style="animation-delay: 0.4s;">
                    <div class="bg-tertiary w-20 h-20 rounded-2xl flex items-center justify-center mb-8 mx-auto">
                        <i class="fas fa-users text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Diskusi Bareng 👥</h3>
                    <p class="text-gray-600 leading-relaxed text-center text-lg">Gabung di kelas diskusi dengan teman-teman sebaya dan sharing pendapat tentang peristiwa sejarah yang menarik!</p>
                    <div class="mt-6 text-center">
                        <span class="inline-block bg-primary/20 text-primary px-4 py-2 rounded-full text-sm font-medium">
                            #BarengTeman
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        <button class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-xl transition-colors backdrop-blur-sm font-medium">
                            Baca Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Story Card 2 -->
                <div class="bg-secondary text-white rounded-3xl p-8 hover-lift fade-in-up relative overflow-hidden" style="animation-delay: 0.2s;">
                    <div class="absolute top-0 right-0 text-6xl opacity-20">⚔️</div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-6">🛡️</div>
                        <h3 class="text-2xl font-bold mb-4">Pahlawan Keren</h3>
                        <p class="text-white/90 leading-relaxed mb-6">Kisah heroik Cut Nyak Dien yang berani melawan penjajah! Inspiring banget deh pokoknya!</p>
                        <button class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-xl transition-colors backdrop-blur-sm font-medium">
                            Baca Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Story Card 3 -->
                <div class="bg-tertiary text-white rounded-3xl p-8 hover-lift fade-in-up relative overflow-hidden md:col-span-2 lg:col-span-1" style="animation-delay: 0.4s;">
                    <div class="absolute top-0 right-0 text-6xl opacity-20">🚢</div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-6">🌊</div>
                        <h3 class="text-2xl font-bold mb-4">Pelaut Legendaris</h3>
                        <p class="text-white/90 leading-relaxed mb-6">Petualangan seru di lautan luas! Gimana caranya nenek moyang kita bisa jago banget berlayar?</p>
                        <button class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-xl transition-colors backdrop-blur-sm font-medium">
                            Baca Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        
                        <button class="mt-10 bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 w-full">
                            <i class="fas fa-compass mr-3"></i>
                            Explore Sekarang!
                        </button>
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
                                    <div class="text-2xl mb-2">🏛️</div>
                                    <p class="text-primary font-bold">Candi</p>
                                </div>
                                <div class="bg-white rounded-2xl p-4">
                                    <div class="text-2xl mb-2">🏰</div>
                                    <p class="text-secondary font-bold">Istana</p>
                                </div>
                                <div class="bg-white rounded-2xl p-4">
                                    <div class="text-2xl mb-2">🗿</div>
                                    <p class="text-tertiary font-bold">Museum</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="lg:col-span-2">
                    <h3 class="text-3xl font-bold text-secondary mb-6">
                        <i class="fas fa-location-crosshairs mr-2"></i>
                        Sentara
                    </h3>
                    <p class="text-gray-400 text-lg leading-relaxed mb-6">Platform belajar sejarah Indonesia yang fun dan interaktif, khusus dirancang untuk generasi muda yang pengen tahu masa lalu dengan cara yang kekinian!</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-secondary transition-colors text-2xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-secondary transition-colors text-2xl">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-secondary transition-colors text-2xl">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-secondary transition-colors text-2xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-6 text-quaternary">Menu Utama</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#home" class="hover:text-white transition-colors text-lg">Beranda</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors text-lg">Fitur</a></li>
                        <li><a href="#stories" class="hover:text-white transition-colors text-lg">Cerita</a></li>
                        <li><a href="#places" class="hover:text-white transition-colors text-lg">Tempat</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-6 text-quaternary">Konten Seru</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors text-lg">Cerita Viral</a></li>
                        <li><a href="#" class="hover:text-white transition-colors text-lg">Virtual Tour</a></li>
                        <li><a href="#" class="hover:text-white transition-colors text-lg">Kelas Online</a></li>
                        <li><a href="#" class="hover:text-white transition-colors text-lg">Forum Diskusi</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p class="text-lg">&copy; {{ date('Y') }} Sentara. Dibuat dengan ❤️ untuk anak muda Indonesia yang cinta sejarah!</p>
            </div>
        </div>
    </footer>


    <!-- JavaScript for Interactivity -->
    <script>
        // Mobile menu functionality
        function initMobileMenu() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileBackdrop = document.getElementById('mobile-backdrop');
            const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

            function toggleMobileMenu() {
                const isOpen = mobileMenu.classList.contains('open');
                
                if (isOpen) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            }

            function openMobileMenu() {
                mobileMenu.classList.add('open');
                mobileBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                mobileBackdrop.classList.add('opacity-100');
                mobileMenuBtn.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                mobileMenu.classList.remove('open');
                mobileBackdrop.classList.add('opacity-0', 'pointer-events-none');
                mobileBackdrop.classList.remove('opacity-100');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = '';
            }

            mobileMenuBtn.addEventListener('click', toggleMobileMenu);
            mobileBackdrop.addEventListener('click', closeMobileMenu);

            // Close menu when clicking nav links
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', () => {
                    closeMobileMenu();
                    const targetId = link.getAttribute('href').substring(1);
                    setTimeout(() => scrollToSection(targetId), 300);
                });
            });
        }

        // Smooth scrolling function
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // Fade in animation on scroll
        function observeElements() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.fade-in-up').forEach((el) => {
                observer.observe(el);
            });
        }

        // Navigation active link update
        function updateActiveNavLink() {
            const sections = ['home', 'features', 'stories', 'places'];
            const navLinks = document.querySelectorAll('.nav-link');

            function updateLinks() {
                let current = 'home';
                
                sections.forEach(section => {
                    const element = document.getElementById(section);
                    if (element) {
                        const rect = element.getBoundingClientRect();
                        if (rect.top <= 100 && rect.bottom >= 100) {
                            current = section;
                        }
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('text-primary');
                    link.classList.add('text-gray-700');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.remove('text-gray-700');
                        link.classList.add('text-primary');
                    }
                });
            }

            window.addEventListener('scroll', updateLinks);
            updateLinks(); // Initial call
        }

        // Navbar background on scroll
        function handleNavbarScroll() {
            const navbar = document.querySelector('nav');
            
            function updateNavbar() {
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-xl');
                } else {
                    navbar.classList.remove('shadow-xl');
                }
            }

            window.addEventListener('scroll', updateNavbar);
            updateNavbar(); // Initial call
        }

        // Initialize bounce animations for hero elements
        function initBounceAnimations() {
            const bounceElements = document.querySelectorAll('.bounce-in');
            bounceElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                }, (index + 1) * 500);
            });
        }

        // Initialize all functions
        document.addEventListener('DOMContentLoaded', () => {
            initMobileMenu();
            observeElements();
            updateActiveNavLink();
            handleNavbarScroll();
            initBounceAnimations();
        });

        // Add click events to desktop nav links
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = link.getAttribute('href').substring(1);
                    scrollToSection(targetId);
                });
            });
        });

        // Add some fun interactions
        document.addEventListener('DOMContentLoaded', () => {
            // Add click effect to buttons
            const buttons = document.querySelectorAll('button, .bg-primary, .bg-secondary');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>
