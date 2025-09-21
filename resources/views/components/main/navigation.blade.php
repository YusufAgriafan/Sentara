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
                    <a href="{{ route('index') }}" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('index') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('sejarah') }}" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('sejarah') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Sejarah</a>
                    <a href="{{ route('geografi') }}" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('geografi') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Geografi</a>
                    <a href="{{ route('kelas') }}" class="nav-link text-white hover:text-quaternary px-4 py-2 rounded-xl text-lg font-medium transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('kelas') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Kelas</a>
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
                <a href="{{ route('index') }}" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('index') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Beranda</a>
                <a href="{{ route('sejarah') }}" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('sejarah') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Sejarah</a>
                <a href="{{ route('geografi') }}" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('geografi') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Geografi</a>
                <a href="{{ route('kelas') }}" class="mobile-nav-link block text-white hover:text-quaternary text-xl font-medium py-3 px-4 rounded-xl transition-all duration-300 hover:bg-white/10 {{ request()->routeIs('kelas') ? 'bg-white/20 text-quaternary font-bold' : '' }}">Kelas</a>
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

<style>
.nav-link.active,
.mobile-nav-link.active {
    background-color: rgba(255, 255, 255, 0.2) !important;
    color: var(--quaternary-color) !important;
    font-weight: bold !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    
    // Toggle mobile menu
    mobileMenuBtn?.addEventListener('click', function() {
        mobileMenu.classList.toggle('translate-x-full');
        mobileBackdrop.classList.toggle('opacity-0');
        mobileBackdrop.classList.toggle('pointer-events-none');
    });
    
    // Close mobile menu when backdrop is clicked
    mobileBackdrop?.addEventListener('click', function() {
        mobileMenu.classList.add('translate-x-full');
        mobileBackdrop.classList.add('opacity-0');
        mobileBackdrop.classList.add('pointer-events-none');
    });
    
    // Close mobile menu when a link is clicked
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.add('translate-x-full');
            mobileBackdrop.classList.add('opacity-0');
            mobileBackdrop.classList.add('pointer-events-none');
        });
    });
});
</script>