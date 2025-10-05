<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- jQuery (required for some plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-inter antialiased bg-white">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r-2 border-quaternary transform transition-transform duration-300 ease-in-out lg:translate-x-0 shadow-xl" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-20 px-8 border-b border-quaternary">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-primary rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-location-crosshairs text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-primary">Sentara</span>
                        <p class="text-sm text-gray-500 font-medium">Admin Panel</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-primary transition-colors duration-200 p-2 rounded-lg hover:bg-quaternary">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="px-6 py-8 space-y-3">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-lg' : 'text-gray-700 hover:bg-quaternary hover:text-primary' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-20' : 'bg-secondary' }}">
                        <i class="fas fa-tachometer-alt {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-primary' }}"></i>
                    </div>
                    Dashboard
                </a>

                <!-- User Management -->
                <a href="{{ route('admin.users') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-primary text-white shadow-lg' : 'text-gray-700 hover:bg-quaternary hover:text-primary' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 {{ request()->routeIs('admin.users*') ? 'bg-white bg-opacity-20' : 'bg-secondary' }}">
                        <i class="fas fa-users {{ request()->routeIs('admin.users*') ? 'text-white' : 'text-primary' }}"></i>
                    </div>
                    Pengguna
                </a>

                <!-- Classes -->
                <a href="{{ route('admin.classes') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.classes*') ? 'bg-primary text-white shadow-lg' : 'text-gray-700 hover:bg-quaternary hover:text-primary' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 {{ request()->routeIs('admin.classes*') ? 'bg-white bg-opacity-20' : 'bg-secondary' }}">
                        <i class="fas fa-chalkboard-teacher {{ request()->routeIs('admin.classes*') ? 'text-white' : 'text-primary' }}"></i>
                    </div>
                    Kelas
                </a>

                <!-- Content Management -->
                <a href="{{ route('admin.content') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.content*') ? 'bg-primary text-white shadow-lg' : 'text-gray-700 hover:bg-quaternary hover:text-primary' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 {{ request()->routeIs('admin.content*') ? 'bg-white bg-opacity-20' : 'bg-secondary' }}">
                        <i class="fas fa-file-alt {{ request()->routeIs('admin.content*') ? 'text-white' : 'text-primary' }}"></i>
                    </div>
                    Pengelolaan Konten
                </a>

                <!-- Geography Content -->
                <a href="{{ route('admin.geography-content.index') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.geography-content*') ? 'bg-primary text-white shadow-lg' : 'text-gray-700 hover:bg-quaternary hover:text-primary' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 {{ request()->routeIs('admin.geography-content*') ? 'bg-white bg-opacity-20' : 'bg-secondary' }}">
                        <i class="fas fa-globe-americas {{ request()->routeIs('admin.geography-content*') ? 'text-white' : 'text-primary' }}"></i>
                    </div>
                    Konten Geografi
                </a>

                <!-- History Management -->
                <a href="{{ route('admin.history.index') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.history*') ? 'bg-primary text-white shadow-lg' : 'text-gray-700 hover:bg-quaternary hover:text-primary' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 {{ request()->routeIs('admin.history*') ? 'bg-white bg-opacity-20' : 'bg-secondary' }}">
                        <i class="fas fa-history {{ request()->routeIs('admin.history*') ? 'text-white' : 'text-primary' }}"></i>
                    </div>
                    Konten Sejarah
                </a>

                <!-- Settings -->
                <a href="{{ route('admin.settings') }}" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-primary text-white shadow-lg' : 'text-gray-700 hover:bg-quaternary hover:text-primary' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 {{ request()->routeIs('admin.settings') ? 'bg-white bg-opacity-20' : 'bg-secondary' }}">
                        <i class="fas fa-cog {{ request()->routeIs('admin.settings') ? 'text-white' : 'text-primary' }}"></i>
                    </div>
                    Pengaturan
                </a>

                <!-- Divider -->
                <div class="border-t border-quaternary my-6"></div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-gray-700 hover:bg-red-50 hover:text-red-600">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg mr-4 bg-red-100">
                            <i class="fas fa-sign-out-alt text-red-500"></i>
                        </div>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="lg:ml-72">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm border-b-2 border-quaternary sticky top-0 z-40">
                <div class="px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true" class="lg:hidden text-primary hover:text-gray-700 transition-colors duration-200 p-3 rounded-xl hover:bg-quaternary">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 min-w-0 lg:ml-0 ml-4">
                            <h1 class="text-2xl font-bold text-primary">
                                @yield('page-title', 'Admin Dashboard')
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">Kelola aplikasi Sentara dengan mudah</p>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-6">
                            <!-- Notifications -->
                            <button class="relative text-gray-600 hover:text-primary transition-colors duration-200 p-3 rounded-xl hover:bg-quaternary">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 h-5 w-5 bg-tertiary text-primary text-xs font-bold rounded-full flex items-center justify-center">3</span>
                            </button>

                            <!-- User Avatar -->
                            <div class="flex items-center space-x-3 bg-quaternary rounded-2xl px-4 py-2">
                                <div class="h-10 w-10 rounded-xl bg-primary flex items-center justify-center">
                                    <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-sm font-semibold text-primary">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8 bg-quaternary min-h-screen">
                @if (session('success'))
                    <div class="mb-8 bg-green-50 border-l-4 border-green-400 text-green-800 px-6 py-4 rounded-r-2xl shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                            </div>
                            <span class="ml-3 font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 bg-red-50 border-l-4 border-red-400 text-red-800 px-6 py-4 rounded-r-2xl shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-red-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-times-circle text-red-500"></i>
                                </div>
                            </div>
                            <span class="ml-3 font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-3xl shadow-sm p-8 min-h-96">
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden backdrop-blur-sm"
             @click="sidebarOpen = false"></div>
    </div>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
