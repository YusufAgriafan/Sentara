<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Sentara')) - Jelajahi Sejarah Indonesia</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin="" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
    @yield('styles')

</head>

<body class="font-sans antialiased bg-white overflow-x-hidden">
    <!-- Navigation -->
    <x-main.navigation />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <x-main.footer />

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
                    // Let the browser handle the normal navigation
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

        // Navigation active link update is handled by Laravel's request()->routeIs() in the navigation component

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
            handleNavbarScroll();
            initBounceAnimations();
        });

        // Desktop nav links work with normal Laravel routes - no special handling needed

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

        @yield('scripts')
    </script>
    
    @stack('scripts')
    
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
            crossorigin=""></script>
</body>
</html>