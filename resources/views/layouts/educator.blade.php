<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Educator</title>

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
<body class="font-inter antialiased bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-600 to-indigo-700 transform transition-transform duration-300 ease-in-out lg:translate-x-0" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-6 bg-black bg-opacity-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                        </div>
                    </div>
                    <span class="ml-2 text-xl font-semibold text-white">Sentara Educator</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-300 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-6 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('educator.dashboard') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.dashboard') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-home mr-3"></i>
                    Beranda
                </a>

                <!-- Divider -->
                <div class="border-t border-white border-opacity-20 my-3"></div>

                <!-- CLASS MANAGEMENT -->
                <div class="px-3 py-2">
                    <h3 class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Manajemen Kelas</h3>
                </div>
                
                <!-- My Classes -->
                <a href="{{ route('educator.classes') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.classes*') && !request()->routeIs('educator.classes.content*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-chalkboard mr-3"></i>
                    Kelas Saya
                </a>

                <!-- Students Management -->
                <a href="{{ route('educator.students') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.students*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-user-graduate mr-3"></i>
                    Semua Siswa
                </a>

                <!-- Divider -->
                <div class="border-t border-white border-opacity-20 my-3"></div>

                <!-- CONTENT MANAGEMENT -->
                <div class="px-3 py-2">
                    <h3 class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Manajemen Materi</h3>
                </div>

                <!-- Content Library -->
                <a href="{{ route('educator.content.library') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.content.library*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-book-open mr-3"></i>
                    Perpustakaan Materi
                </a>

                <!-- Class Content Assignment -->
                <a href="{{ route('educator.content.assignments') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.content.assignments*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-tasks mr-3"></i>
                    Pembagian Materi
                </a>

                <!-- Historical Places -->
                <a href="{{ route('educator.places.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.places*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-map-marked-alt mr-3"></i>
                    Tempat Bersejarah
                </a>

                <!-- Stories & Materials -->
                <a href="{{ route('educator.stories.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.stories*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-scroll mr-3"></i>
                    Cerita & Materi
                </a>

                <!-- Geography 3D Models -->
                <a href="{{ route('educator.geography-models.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.geography-models*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-globe-americas mr-3"></i>
                    Model 3D Geografi
                </a>

                <!-- Divider -->
                <div class="border-t border-white border-opacity-20 my-3"></div>

                <!-- ACTIVITIES -->
                <div class="px-3 py-2">
                    <h3 class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Aktivitas</h3>
                </div>

                <!-- Discussions -->
                <a href="{{ route('educator.discussions.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.discussions*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-comments mr-3"></i>
                    Diskusi Kelas
                </a>

                <!-- Divider -->
                <div class="border-t border-white border-opacity-30 my-4"></div>

                <!-- Profile -->
                <a href="{{ route('educator.profile') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('educator.profile') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20 hover:text-white' }}">
                    <i class="fas fa-user-circle mr-3"></i>
                    Profil
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 text-white hover:bg-red-500 hover:bg-opacity-90 hover:text-white hover:shadow-lg">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="lg:ml-64">
            <!-- Top Navigation Bar -->
            <header class="bg-gradient-to-r from-white to-blue-50 shadow-lg border-b border-blue-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true" class="lg:hidden text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 min-w-0">
                            <h1 class="text-lg font-bold text-blue-700 truncate">
                                @yield('page-title', 'Beranda Pengajar')
                            </h1>
                        </div>

                        <!-- Header Actions -->
                        <div class="flex items-center space-x-4">

                            <!-- User Avatar -->
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden md:block">
                                    <span class="text-sm font-medium text-blue-700">{{ Auth::user()->name }}</span>
                                    <p class="text-xs text-gray-500">Pengajar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
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

                @if (session('info'))
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 text-blue-800 px-4 py-3 rounded-r-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ session('info') }}
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
