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
</head>
<body class="font-inter antialiased bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-primary to-secondary transform transition-transform duration-300 ease-in-out lg:translate-x-0" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-6 bg-black bg-opacity-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-quaternary rounded-lg flex items-center justify-center">
                            <i class="fas fa-location-crosshairs text-primary"></i>
                        </div>
                    </div>
                    <span class="ml-2 text-xl font-semibold text-white">Sentara Admin</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-6 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-quaternary text-primary shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-quaternary' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>

                <!-- User Management -->
                <a href="{{ route('admin.users') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-quaternary text-primary shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-quaternary' }}">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>

                <!-- Content Management -->
                <a href="{{ route('admin.content') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.content*') ? 'bg-quaternary text-primary shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-quaternary' }}">
                    <i class="fas fa-file-alt mr-3"></i>
                    Content Management
                </a>

                <!-- Reports & Analytics -->
                <a href="{{ route('admin.reports') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.reports*') ? 'bg-quaternary text-primary shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-quaternary' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Reports & Analytics
                </a>

                <!-- Classes -->
                <a href="{{ route('admin.classes') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.classes*') ? 'bg-quaternary text-primary shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-quaternary' }}">
                    <i class="fas fa-chalkboard-teacher mr-3"></i>
                    Classes
                </a>

                <!-- Settings -->
                <a href="{{ route('admin.settings') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-quaternary text-primary shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-quaternary' }}">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>

                <!-- Divider -->
                <div class="border-t border-white border-opacity-30 my-4"></div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 text-white hover:bg-red-500 hover:bg-opacity-90 hover:text-white hover:shadow-lg">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="lg:ml-64">
            <!-- Top Navigation Bar -->
            <header class="bg-gradient-to-r from-white to-gray-50 shadow-lg border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true" class="lg:hidden text-primary hover:text-secondary transition-colors duration-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 min-w-0">
                            <h1 class="text-lg font-bold text-primary truncate">
                                @yield('page-title', 'Admin Dashboard')
                            </h1>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <button class="text-primary hover:text-secondary relative transition-colors duration-200">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 block h-2 w-2 bg-tertiary rounded-full ring-2 ring-white"></span>
                            </button>

                            <!-- User Avatar -->
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-primary">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 bg-gradient-to-br from-gray-50 to-white min-h-screen">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-800 px-4 py-3 rounded-r-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-800 px-4 py-3 rounded-r-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @yield('content')
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
             class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
             @click="sidebarOpen = false"></div>
    </div>
</body>
</html>
