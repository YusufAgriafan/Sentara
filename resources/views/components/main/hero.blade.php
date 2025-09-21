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
                    <a href="{{ route('sejarah') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-book-open mr-3"></i>
                        Mulai Jelajah
                    </a>
                    
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