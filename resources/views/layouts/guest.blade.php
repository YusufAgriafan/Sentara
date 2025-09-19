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
            
            /* Custom animations */
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            
            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
            
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            
            .shimmer {
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                background-size: 200% 100%;
                animation: shimmer 2s infinite;
            }
            
            /* Enhanced input focus effects */
            .input-group:focus-within .input-icon {
                color: #6A2634;
                transform: scale(1.1);
            }
            
            /* Gradient text animation */
            .gradient-text {
                background: linear-gradient(-45deg, #6A2634, #943939, #E18237, #FFE0A3);
                background-size: 400% 400%;
                animation: gradient 4s ease infinite;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            /* Button hover effects */
            .btn-primary {
                position: relative;
                overflow: hidden;
            }
            
            .btn-primary::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s;
            }
            
            .btn-primary:hover::before {
                left: 100%;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white min-h-screen">
        <!-- Enhanced Background Pattern -->
        <div class="fixed inset-0 bg-gradient-to-br from-quaternary/30 via-white to-primary/5">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmOWZhZmIiIGZpbGwtb3BhY2l0eT0iMC4zIj48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIxLjUiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
            <!-- Add floating historical elements -->
            <div class="absolute top-10 left-10 text-quaternary/20 animate-pulse">
                <i class="fas fa-scroll text-4xl transform rotate-12"></i>
            </div>
            <div class="absolute top-32 right-16 text-quaternary/20 animate-pulse delay-1000">
                <i class="fas fa-location-crosshairs text-3xl transform -rotate-12"></i>
            </div>
            <div class="absolute bottom-20 left-20 text-quaternary/20 animate-pulse delay-2000">
                <i class="fas fa-crown text-3xl transform rotate-6"></i>
            </div>
            <div class="absolute bottom-32 right-10 text-quaternary/20 animate-pulse delay-500">
                <i class="fas fa-feather text-2xl transform -rotate-6"></i>
            </div>
        </div>

        <!-- Main Content with Split Layout -->
        <main class="relative z-10 min-h-screen flex">
            <!-- Left Side - Welcome Content -->
            <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 relative overflow-hidden">
                <!-- Background Image/Pattern -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary via-secondary to-tertiary">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48ZyBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMSI+PGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
                </div>
                
                <!-- Content -->
                <div class="relative flex flex-col justify-center px-12 xl:px-16 text-white">
                    <!-- Logo -->
                    <div class="mb-8">
                        <div class="inline-flex items-center space-x-4">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                <i class="fas fa-location-crosshairs text-white text-2xl"></i>
                            </div>
                            <h1 class="text-4xl font-bold">Sentara</h1>
                        </div>
                    </div>
                    
                    <!-- Welcome Text -->
                    <div class="space-y-6">
                        <h2 class="text-5xl xl:text-6xl font-bold leading-tight">
                            Jelajahi<br/>
                            <span class="text-quaternary">Sejarah</span><br/>
                            Indonesia
                        </h2>
                        <p class="text-xl text-white/80 leading-relaxed max-w-lg">
                            Temukan kisah-kisah menarik dari masa lalu Indonesia melalui pengalaman interaktif yang tak terlupakan.
                        </p>
                        
                        <!-- Features -->
                        <div class="space-y-4 mt-8">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-quaternary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-map-marked-alt text-quaternary text-sm"></i>
                                </div>
                                <span class="text-white/90">Peta interaktif tempat bersejarah</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-quaternary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book-open text-quaternary text-sm"></i>
                                </div>
                                <span class="text-white/90">Cerita sejarah yang menarik</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-quaternary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-quaternary text-sm"></i>
                                </div>
                                <span class="text-white/90">Komunitas pembelajar sejarah</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Historical Quote -->
                    <div class="mt-12 p-6 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20">
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-quote-left text-quaternary text-2xl mt-1"></i>
                            <div>
                                <p class="text-white/90 font-medium italic leading-relaxed">
                                    "Bangsa yang besar adalah bangsa yang menghargai sejarahnya"
                                </p>
                                <p class="text-quaternary font-semibold mt-2">- Ir. Soekarno</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute top-10 right-10 text-white/10 animate-float">
                    <i class="fas fa-scroll text-6xl transform rotate-12"></i>
                </div>
                <div class="absolute bottom-20 right-20 text-white/10 animate-float" style="animation-delay: 2s;">
                    <i class="fas fa-crown text-4xl transform -rotate-12"></i>
                </div>
            </div>
            
            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo (Hidden on Desktop) -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                            <i class="fas fa-location-crosshairs text-white text-2xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">Sentara</h1>
                    </div>
                    
                    <!-- Form Container -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl shadow-gray-200/50 p-8 lg:p-10 border border-gray-100 relative overflow-hidden">
                        <!-- Decorative corner elements -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-quaternary/20 to-transparent rounded-bl-3xl"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-tr from-quaternary/20 to-transparent rounded-tr-3xl"></div>
                        
                        {{ $slot }}
                    </div>

                    <!-- Footer Links -->
                    <div class="text-center mt-8">
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 border border-gray-100 shadow-lg">
                            <p class="text-sm text-gray-500 leading-relaxed">
                                <i class="fas fa-shield-alt text-primary mr-1"></i>
                                Dengan masuk, Anda menyetujui 
                                <a href="#" class="text-primary hover:text-secondary transition-colors duration-300 font-medium underline decoration-dotted">
                                    Syarat & Ketentuan
                                </a> 
                                dan 
                                <a href="#" class="text-primary hover:text-secondary transition-colors duration-300 font-medium underline decoration-dotted">
                                    Kebijakan Privasi
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
