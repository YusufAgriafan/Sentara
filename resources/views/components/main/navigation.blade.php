<nav class="fixed top-0 w-full z-[9999] bg-white shadow-lg border-b-4 border-primary">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-3xl font-bold text-primary">
                        <i class="fas fa-location-crosshairs mr-2 text-secondary"></i>
                        Sentara
                    </h1>
                </div>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:block">
                <div class="ml-10 flex items-center space-x-2">
                    <a href="{{ route('index') }}" class="nav-link text-gray-700 hover:text-primary px-5 py-3 rounded-2xl text-lg font-medium transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('index') ? 'bg-primary text-white font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('sejarah') }}" class="nav-link text-gray-700 hover:text-primary px-5 py-3 rounded-2xl text-lg font-medium transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('sejarah') ? 'bg-primary text-white font-bold' : '' }}">Sejarah</a>
                    <a href="{{ route('geografi') }}" class="nav-link text-gray-700 hover:text-primary px-5 py-3 rounded-2xl text-lg font-medium transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('geografi') ? 'bg-primary text-white font-bold' : '' }}">Geografi</a>
                    @if (Route::has('login'))
                        <a href="{{ route('game.index') }}" class="nav-link text-gray-700 hover:text-primary px-5 py-3 rounded-2xl text-lg font-medium transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('game.*') ? 'bg-primary text-white font-bold' : '' }}">Game</a>
                    @endif
                    <a href="{{ route('kelas') }}" class="nav-link text-gray-700 hover:text-primary px-5 py-3 rounded-2xl text-lg font-medium transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('kelas') ? 'bg-primary text-white font-bold' : '' }}">Kelas</a>
                </div>
            </div>
            
            <!-- Auth Buttons -->
            <div class="hidden lg:flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        @php
                            $dashboardRoute = match(auth()->user()->role) {
                                'admin' => route('admin.dashboard'),
                                'educator' => route('educator.dashboard'),
                                'student' => route('dashboard'),
                                default => route('dashboard'),
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="bg-primary text-white hover:bg-primary/90 px-6 py-3 rounded-2xl text-lg font-medium transition-all duration-300 hover:scale-105 shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary px-5 py-3 rounded-2xl text-lg font-medium transition-colors">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-2xl text-lg font-medium transition-all duration-300 hover:scale-105 shadow-lg">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button id="mobile-menu-btn" class="hamburger p-3 rounded-2xl hover:bg-quaternary transition-colors">
                    <span class="block w-6 h-0.5 bg-gray-700 mb-1.5 rounded-full transition-all duration-300"></span>
                    <span class="block w-6 h-0.5 bg-gray-700 mb-1.5 rounded-full transition-all duration-300"></span>
                    <span class="block w-6 h-0.5 bg-gray-700 rounded-full transition-all duration-300"></span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu Drawer -->
    <div id="mobile-menu" class="fixed top-0 right-0 h-screen w-80 bg-white shadow-2xl lg:hidden z-[9998] transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
        <div class="p-8 pt-24">
            <!-- Close Button -->
            <button id="close-mobile-menu" class="absolute top-6 right-6 p-2 rounded-2xl hover:bg-quaternary transition-colors">
                <i class="fas fa-times text-2xl text-gray-700"></i>
            </button>
            
            <div class="space-y-4">
                <a href="{{ route('index') }}" class="mobile-nav-link block text-gray-700 hover:text-primary text-xl font-medium py-4 px-6 rounded-2xl transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('index') ? 'bg-primary text-white font-bold' : '' }}">Beranda</a>
                <a href="{{ route('sejarah') }}" class="mobile-nav-link block text-gray-700 hover:text-primary text-xl font-medium py-4 px-6 rounded-2xl transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('sejarah') ? 'bg-primary text-white font-bold' : '' }}">Sejarah</a>
                <a href="{{ route('geografi') }}" class="mobile-nav-link block text-gray-700 hover:text-primary text-xl font-medium py-4 px-6 rounded-2xl transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('geografi') ? 'bg-primary text-white font-bold' : '' }}">Geografi</a>
                <a href="{{ route('game.index') }}" class="mobile-nav-link block text-gray-700 hover:text-primary text-xl font-medium py-4 px-6 rounded-2xl transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('game.*') ? 'bg-primary text-white font-bold' : '' }}">Game</a>
                <a href="{{ route('kelas') }}" class="mobile-nav-link block text-gray-700 hover:text-primary text-xl font-medium py-4 px-6 rounded-2xl transition-all duration-300 hover:bg-quaternary {{ request()->routeIs('kelas') ? 'bg-primary text-white font-bold' : '' }}">Kelas</a>
            </div>
            
            <div class="mt-8 space-y-4">
                @if (Route::has('login'))
                    @auth
                        @php
                            $dashboardRoute = match(auth()->user()->role) {
                                'admin' => route('admin.dashboard'),
                                'educator' => route('educator.dashboard'),
                                'student' => route('index'),
                                default => route('index'),
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="block bg-primary text-white hover:bg-primary/90 px-6 py-4 rounded-2xl text-lg font-medium text-center transition-all duration-300 shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block text-gray-700 hover:text-primary px-6 py-4 rounded-2xl text-lg font-medium text-center transition-colors border-2 border-quaternary hover:border-primary">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block bg-primary hover:bg-primary/90 text-white px-6 py-4 rounded-2xl text-lg font-medium text-center transition-all duration-300 shadow-lg">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu Backdrop -->
    <div id="mobile-backdrop" class="fixed inset-0 bg-black/50 z-[9997] lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation script loaded'); // Debug log
    
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const closeMobileMenu = document.getElementById('close-mobile-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    
    // Debug: Check if elements exist
    console.log('Elements found:', {
        mobileMenuBtn: !!mobileMenuBtn,
        closeMobileMenu: !!closeMobileMenu,
        mobileMenu: !!mobileMenu,
        mobileBackdrop: !!mobileBackdrop
    });
    
    if (!mobileMenuBtn || !mobileMenu || !mobileBackdrop) {
        console.error('Required elements not found!');
        return;
    }
    
    // Simple toggle function
    function toggleMobileMenu() {
        console.log('Toggle menu clicked'); // Debug log
        
        const isHidden = mobileMenu.classList.contains('translate-x-full');
        
        if (isHidden) {
            // Show menu
            mobileMenu.classList.remove('translate-x-full');
            mobileBackdrop.classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
            
            // Animate hamburger to X
            const spans = mobileMenuBtn.querySelectorAll('span');
            spans[0].style.transform = 'rotate(45deg) translate(6px, 6px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translate(6px, -6px)';
            
            console.log('Menu opened');
        } else {
            // Hide menu
            closeMobileMenuHandler();
        }
    }
    
    // Close mobile menu
    function closeMobileMenuHandler() {
        console.log('Closing menu'); // Debug log
        
        mobileMenu.classList.add('translate-x-full');
        mobileBackdrop.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
        
        // Reset hamburger
        const spans = mobileMenuBtn.querySelectorAll('span');
        spans[0].style.transform = 'none';
        spans[1].style.opacity = '1';
        spans[2].style.transform = 'none';
        
        console.log('Menu closed');
    }
    
    // Event listeners
    mobileMenuBtn.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Mobile menu button clicked');
        toggleMobileMenu();
    });
    
    // Close menu when backdrop is clicked
    mobileBackdrop.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Backdrop clicked');
        closeMobileMenuHandler();
    });
    
    // Close menu when close button is clicked
    if (closeMobileMenu) {
        closeMobileMenu.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Close button clicked');
            closeMobileMenuHandler();
        });
    }
    
    // Close menu when a link is clicked
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            console.log('Nav link clicked');
            closeMobileMenuHandler();
        });
    });
    
    // Handle orientation change and resize
    window.addEventListener('orientationchange', function() {
        setTimeout(closeMobileMenuHandler, 100);
    });
    
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) { // lg breakpoint
            closeMobileMenuHandler();
        }
    });
});
</script>