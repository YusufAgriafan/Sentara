<!-- Hero Section -->
<section id="home" class="pt-32 pb-20 px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            <div class="fade-in-up">
                <div class="mb-10">
                    <span class="inline-block bg-secondary text-primary px-8 py-3 rounded-full text-lg font-semibold mb-8 border-2 border-primary/20">
                        📚 Platform Pembelajaran Sejarah
                    </span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 mb-10 leading-tight">
                    Belajar 
                    <span class="text-primary">Sejarah</span> 
                    <span class="text-tertiary">Bersama</span> 
                    dalam Kelas
                </h1>
                
                <p class="text-xl lg:text-2xl text-gray-600 mb-14 leading-relaxed">
                    Platform pembelajaran sejarah Indonesia dengan sistem kelas virtual, tempat bersejarah interaktif, diskusi terarah, dan game edukatif yang menyenangkan! 🏫📖
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6">
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-primary/90 text-white px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg inline-flex items-center justify-center">
                        <i class="fas fa-user-graduate mr-3"></i>
                        Bergabung Sekarang
                    </a>
                    
                    <button onclick="scrollToSection('features')" class="bg-quaternary border-2 border-primary text-primary hover:bg-primary hover:text-white px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105 inline-flex items-center justify-center">
                        <i class="fas fa-info-circle mr-3"></i>
                        Pelajari Lebih Lanjut
                    </button>
                </div>
            </div>
            
            <div class="fade-in-up lg:order-first" style="animation-delay: 0.3s;">
                <div class="relative">
                    <!-- Main illustration container -->
                    <div class="bg-quaternary rounded-3xl p-16 text-center relative overflow-hidden">
                        <div class="absolute top-6 left-6 w-20 h-20 bg-secondary rounded-full"></div>
                        <div class="absolute bottom-6 right-6 w-24 h-24 bg-tertiary rounded-full"></div>
                        <div class="absolute top-1/2 right-10 w-16 h-16 bg-primary rounded-full"></div>
                        
                        <div class="relative z-10">
                            <div class="text-8xl mb-8">📚</div>
                            <h3 class="text-3xl font-bold text-primary mb-6">Sistem Pembelajaran</h3>
                            <p class="text-gray-700 text-xl leading-relaxed">Platform terstruktur untuk pembelajaran sejarah yang interaktif dan efektif</p>
                        </div>
                    </div>
                    
                    <!-- Floating elements -->
                    <div class="absolute -top-4 -right-4 bg-secondary text-primary px-6 py-3 rounded-2xl font-bold text-lg bounce-in shadow-lg" style="animation-delay: 1s;">
                        Edukatif! 🎓
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-tertiary text-white px-6 py-3 rounded-2xl font-bold text-lg bounce-in shadow-lg" style="animation-delay: 1.5s;">
                        Terstruktur! 📚
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>