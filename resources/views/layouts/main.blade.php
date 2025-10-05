<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#ffffff">
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
            /* Prevent bounce effect on iOS and Android */
            overscroll-behavior: none;
            /* Prevent text selection on mobile */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            /* Improve touch handling */
            -webkit-touch-callout: none;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Fix for Android viewport issues */
        html {
            height: 100%;
            overflow-x: hidden;
        }
        
        /* Improve touch targets for mobile */
        button, a {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Fix for mobile menu positioning on Android */
        .mobile-menu {
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            height: 100vh !important;
            height: calc(var(--vh, 1vh) * 100) !important; /* Use custom viewport height variable */
            height: 100dvh !important; /* Use dynamic viewport height for mobile */
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Fix backdrop positioning */
        .mobile-backdrop {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            height: calc(var(--vh, 1vh) * 100) !important;
            height: 100dvh !important;
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
        
        /* Fallback for older Android browsers */
        @supports not (height: 100dvh) {
            .mobile-menu {
                height: calc(var(--vh, 1vh) * 100) !important;
            }
            .mobile-backdrop {
                height: calc(var(--vh, 1vh) * 100) !important;
            }
        }
        
        @supports not (height: calc(var(--vh, 1vh) * 100)) {
            .mobile-menu {
                height: 100vh !important;
            }
            .mobile-backdrop {
                height: 100vh !important;
            }
        }
        
        /* Fix for older Android WebView - Remove conflicting mobile-menu styles */
        /* Let Tailwind handle the transforms */
        
        /* Improve performance on mobile */
        .mobile-menu, .mobile-backdrop {
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }
        
        /* Ensure hamburger button is clickable */
        .hamburger {
            z-index: 10000;
            position: relative;
            cursor: pointer;
        }
        
        .hamburger span {
            display: block;
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

    <!-- Mobile/Android compatibility polyfills -->
    <script>
        // Polyfill for older Android browsers
        (function() {
            // Touch events polyfill
            if (!('ontouchstart' in window) && !window.navigator.msPointerEnabled) {
                // Add basic touch event support for older browsers
                var addTouchEvent = function(el, event, handler) {
                    if (el.addEventListener) {
                        el.addEventListener(event.replace('touch', 'mouse').replace('start', 'down').replace('end', 'up'), handler, false);
                    }
                };
                
                window.addTouchEvent = addTouchEvent;
            }
            
            // Viewport height fix for older mobile browsers
            function fixViewportHeight() {
                var vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', vh + 'px');
            }
            
            window.addEventListener('resize', fixViewportHeight);
            window.addEventListener('orientationchange', function() {
                setTimeout(fixViewportHeight, 100);
            });
            fixViewportHeight();
            
            // classList polyfill for older Android
            if (!("classList" in document.documentElement)) {
                Object.defineProperty(HTMLElement.prototype, 'classList', {
                    get: function() {
                        var self = this;
                        function update(fn) {
                            return function(value) {
                                var classes = self.className.split(/\s+/g),
                                    index = classes.indexOf(value);
                                fn(classes, index, value);
                                self.className = classes.join(" ");
                            };
                        }
                        return {
                            add: update(function(classes, index, value) {
                                if (!~index) classes.push(value);
                            }),
                            remove: update(function(classes, index) {
                                if (~index) classes.splice(index, 1);
                            }),
                            toggle: update(function(classes, index, value) {
                                if (~index)
                                    classes.splice(index, 1);
                                else
                                    classes.push(value);
                            }),
                            contains: function(value) {
                                return !!~self.className.split(/\s+/g).indexOf(value);
                            }
                        };
                    }
                });
            }
        })();
    </script>

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
            observeElements();
            handleNavbarScroll();
            initBounceAnimations();
        });

        // Desktop nav links work with normal Laravel routes - no special handling needed

        // Add some fun interactions
        document.addEventListener('DOMContentLoaded', () => {
            // Add click effect to buttons (but exclude mobile menu button)
            const buttons = document.querySelectorAll('button:not(#mobile-menu-btn), .bg-primary, .bg-secondary');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
            
            // Test mobile menu functionality
            setTimeout(() => {
                const mobileMenuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                const mobileBackdrop = document.getElementById('mobile-backdrop');
                
                if (mobileMenuBtn && mobileMenu && mobileBackdrop) {
                    console.log('✅ Mobile menu elements found and ready');
                } else {
                    console.error('❌ Mobile menu elements missing:', {
                        btn: !!mobileMenuBtn,
                        menu: !!mobileMenu, 
                        backdrop: !!mobileBackdrop
                    });
                }
            }, 1000);
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