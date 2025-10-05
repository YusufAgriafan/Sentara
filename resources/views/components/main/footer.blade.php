<footer class="bg-gray-900 text-white py-16 px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div class="lg:col-span-2">
                <h3 class="text-3xl font-bold text-secondary mb-6">
                    <i class="fas fa-location-crosshairs mr-2"></i>
                    Sentara
                </h3>
                <p class="text-gray-400 text-lg leading-relaxed mb-6">Platform pembelajaran sejarah Indonesia yang modern dan interaktif, dirancang khusus untuk pendidikan yang efektif dan menyenangkan!</p>
                <div class="flex space-x-4">
                    <a href="#" class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white hover:bg-primary/80 transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-secondary rounded-2xl flex items-center justify-center text-primary hover:bg-secondary/80 transition-colors">
                        <i class="fab fa-tiktok text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-tertiary rounded-2xl flex items-center justify-center text-white hover:bg-tertiary/80 transition-colors">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-quaternary rounded-2xl flex items-center justify-center text-gray-900 hover:bg-quaternary/80 transition-colors">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-xl font-bold mb-6 text-quaternary">Menu Utama</h4>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="{{ route('index') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('sejarah') }}" class="hover:text-white transition-colors">Sejarah</a></li>
                    <li><a href="{{ route('geografi') }}" class="hover:text-white transition-colors">Geografi</a></li>
                    <li><a href="{{ route('kelas') }}" class="hover:text-white transition-colors">Kelas</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-xl font-bold mb-6 text-quaternary">Konten Unggulan</h4>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Materi Terbaru</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Tempat Bersejarah</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Diskusi Kelas</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Event & News</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
            <p class="text-lg">&copy; {{ date('Y') }} Sentara. Dibuat dengan ❤️ untuk pendidikan sejarah Indonesia yang lebih baik!</p>
        </div>
    </div>
</footer>