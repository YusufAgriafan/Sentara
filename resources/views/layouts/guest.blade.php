<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
            
            /* Mobile drawer animation */
            .mobile-drawer {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .mobile-drawer.open {
                transform: translateX(0);
            }
            
            /* Hamburger animation */
            .hamburger span {
                transition: all 0.3s ease;
                transform-origin: center;
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
            
            /* Smooth button hover */
            .btn-hover {
                transition: all 0.2s ease;
            }
            
            .btn-hover:hover {
                transform: translateY(-1px);
            }
            
            /* Fun floating animation for decorative elements */
            @keyframes float {
                0%, 100% { 
                    transform: translateY(0px) rotate(0deg); 
                }
                50% { 
                    transform: translateY(-8px) rotate(2deg); 
                }
            }
            
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
            
            .animate-float-delayed {
                animation: float 4s ease-in-out infinite;
                animation-delay: 2s;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white min-h-screen">
        <!-- Clean Background -->
        <div class="fixed inset-0 bg-white">
            <!-- Fun decorative elements with flat colors -->
            <div class="absolute top-8 left-8 w-24 h-24 bg-secondary rounded-full opacity-60 animate-float"></div>
            <div class="absolute top-32 right-12 w-16 h-16 bg-tertiary rounded-2xl opacity-40 animate-float-delayed"></div>
            <div class="absolute bottom-20 left-16 w-20 h-20 bg-primary/20 rounded-full opacity-50 animate-float"></div>
            <div class="absolute bottom-40 right-8 w-12 h-12 bg-quaternary rounded-xl opacity-60 animate-float-delayed"></div>
        </div>

        <!-- Mobile Navigation Overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>
        
        <!-- Mobile Navigation Drawer -->
        <div id="mobile-drawer" class="mobile-drawer fixed top-0 left-0 h-full w-80 bg-white z-50 shadow-2xl lg:hidden">
            <div class="p-6">
                <!-- Mobile Logo -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                            <i class="fas fa-map-marked-alt text-white text-lg"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900">Sentara</h1>
                    </div>
                    <button id="close-drawer" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Mobile Navigation Items -->
                <nav class="space-y-4">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-quaternary transition-colors">
                        <i class="fas fa-home text-primary w-5"></i>
                        <span class="font-medium text-gray-700">Beranda</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-quaternary transition-colors">
                        <i class="fas fa-map text-primary w-5"></i>
                        <span class="font-medium text-gray-700">Peta Sejarah</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-quaternary transition-colors">
                        <i class="fas fa-book text-primary w-5"></i>
                        <span class="font-medium text-gray-700">Cerita</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-quaternary transition-colors">
                        <i class="fas fa-info-circle text-primary w-5"></i>
                        <span class="font-medium text-gray-700">Tentang</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <main class="relative z-10 min-h-screen">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white border-b border-quaternary p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marked-alt text-white text-sm"></i>
                        </div>
                        <h1 class="text-lg font-bold text-gray-900">Sentara</h1>
                    </div>
                    
                    <!-- Hamburger Menu -->
                    <button id="hamburger" class="hamburger flex flex-col space-y-1 p-2 transition-all">
                        <span class="w-6 h-0.5 bg-gray-700 rounded"></span>
                        <span class="w-6 h-0.5 bg-gray-700 rounded"></span>
                        <span class="w-6 h-0.5 bg-gray-700 rounded"></span>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex min-h-screen lg:min-h-auto">
                <!-- Left Side - Welcome Content (Desktop Only) -->
                <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 bg-primary relative overflow-hidden">
                    <!-- Content -->
                    <div class="relative flex flex-col justify-center px-12 xl:px-16 text-white w-full">
                        <!-- Logo -->
                        <div class="mb-12">
                            <div class="inline-flex items-center space-x-4">
                                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-map-marked-alt text-primary text-2xl"></i>
                                </div>
                                <h1 class="text-4xl font-bold">Sentara</h1>
                            </div>
                        </div>
                        
                        <!-- Welcome Text -->
                        <div class="space-y-8 max-w-lg">
                            <h2 class="text-5xl xl:text-6xl font-bold leading-tight">
                                Jelajahi<br/>
                                <span class="text-secondary">Sejarah</span><br/>
                                Indonesia
                            </h2>
                            <p class="text-xl text-white/90 leading-relaxed">
                                Temukan kisah-kisah menarik dari masa lalu Indonesia melalui pengalaman interaktif yang tak terlupakan.
                            </p>
                            
                            <!-- Features -->
                            <div class="space-y-6 mt-12">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-map-marked-alt text-secondary text-lg"></i>
                                    </div>
                                    <span class="text-white/90 font-medium">Peta interaktif tempat bersejarah</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-book-open text-secondary text-lg"></i>
                                    </div>
                                    <span class="text-white/90 font-medium">Cerita sejarah yang menarik</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-users text-secondary text-lg"></i>
                                    </div>
                                    <span class="text-white/90 font-medium">Komunitas pembelajar sejarah</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Historical Quote -->
                        <div class="mt-16 p-8 bg-white/10 backdrop-blur-sm rounded-3xl border border-white/20">
                            <div class="flex items-start space-x-4">
                                <i class="fas fa-quote-left text-secondary text-3xl mt-1"></i>
                                <div>
                                    <p class="text-white/95 font-medium italic leading-relaxed text-lg">
                                        "Bangsa yang besar adalah bangsa yang menghargai sejarahnya"
                                    </p>
                                    <p class="text-secondary font-semibold mt-3 text-lg">- Ir. Soekarno</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute top-12 right-12 text-white/10 animate-float">
                        <i class="fas fa-scroll text-5xl"></i>
                    </div>
                    <div class="absolute bottom-24 right-24 text-white/10 animate-float-delayed">
                        <i class="fas fa-crown text-4xl"></i>
                    </div>
                </div>
                
                <!-- Right Side - Form Area -->
                <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center p-6 lg:p-12">
                    <div class="w-full max-w-md">
                        <!-- Mobile Welcome (Hidden on Desktop) -->
                        <div class="lg:hidden text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                                Selamat Datang di 
                                <span class="text-primary">Sentara</span>
                            </h2>
                            <p class="text-gray-600">Jelajahi sejarah Indonesia dengan cara yang menyenangkan</p>
                        </div>
                        
                        <!-- Form Container -->
                        <div class="bg-white rounded-3xl shadow-lg border border-quaternary p-8 lg:p-10 relative overflow-hidden">
                            <!-- Decorative corner elements -->
                            <div class="absolute top-0 right-0 w-16 h-16 bg-secondary/30 rounded-bl-3xl"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-tertiary/30 rounded-tr-3xl"></div>
                            
                            {{ $slot }}
                        </div>

                        <!-- Footer Links -->
                        <div class="text-center mt-8">
                            <div class="bg-quaternary/50 rounded-2xl p-4">
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    <i class="fas fa-shield-alt text-primary mr-2"></i>
                                    Dengan masuk, Anda menyetujui 
                                    <a href="#" class="text-primary hover:text-primary/80 transition-colors font-medium underline decoration-dotted">
                                        Syarat & Ketentuan
                                    </a> 
                                    dan 
                                    <a href="#" class="text-primary hover:text-primary/80 transition-colors font-medium underline decoration-dotted">
                                        Kebijakan Privasi
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- JavaScript for Mobile Navigation -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hamburger = document.getElementById('hamburger');
                const mobileDrawer = document.getElementById('mobile-drawer');
                const mobileOverlay = document.getElementById('mobile-overlay');
                const closeDrawer = document.getElementById('close-drawer');

                function openDrawer() {
                    mobileDrawer.classList.add('open');
                    mobileOverlay.classList.remove('hidden');
                    hamburger.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }

                function closeDrawerFunc() {
                    mobileDrawer.classList.remove('open');
                    mobileOverlay.classList.add('hidden');
                    hamburger.classList.remove('active');
                    document.body.style.overflow = '';
                }

                hamburger.addEventListener('click', function() {
                    if (mobileDrawer.classList.contains('open')) {
                        closeDrawerFunc();
                    } else {
                        openDrawer();
                    }
                });

                closeDrawer.addEventListener('click', closeDrawerFunc);
                mobileOverlay.addEventListener('click', closeDrawerFunc);
            });
        </script>
    </body>
</html>
