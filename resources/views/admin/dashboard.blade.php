@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Stats Overview -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Ringkasan Statistik</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Users Card -->
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <dt class="text-sm font-medium text-gray-600 truncate">Total Pengguna</dt>
                        <dd class="text-2xl font-bold text-primary">{{ $stats['total_users'] ?? 0 }}</dd>
                        <div class="text-xs text-green-600 font-medium flex items-center mt-1">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +12% dari bulan lalu
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Educators Card -->
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-secondary to-tertiary rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <dt class="text-sm font-medium text-gray-600 truncate">Pengajar</dt>
                        <dd class="text-2xl font-bold text-secondary">{{ $stats['total_educators'] ?? 0 }}</dd>
                        <div class="text-xs text-green-600 font-medium flex items-center mt-1">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +8% dari bulan lalu
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Students Card -->
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-tertiary to-quaternary rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <dt class="text-sm font-medium text-gray-600 truncate">Siswa</dt>
                        <dd class="text-2xl font-bold text-tertiary">{{ $stats['total_students'] ?? 0 }}</dd>
                        <div class="text-xs text-green-600 font-medium flex items-center mt-1">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            +25% dari bulan lalu
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Kelas</p>
                        <p class="text-xl font-bold text-gray-900">{{ $stats['total_classes'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Kelas Aktif</p>
                        <p class="text-xl font-bold text-gray-900">{{ $stats['active_classes'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-globe text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Model Geografi</p>
                        <p class="text-xl font-bold text-gray-900">{{ $stats['total_geography_models'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Cerita</p>
                        <p class="text-xl font-bold text-gray-900">{{ $stats['total_stories'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Statistics Chart -->
        <div class="mt-8 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-semibold text-white">Statistik Bulanan</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                    @php
                        $monthlyData = [
                            ['month' => 'Apr 2025', 'users' => 15, 'classes' => 3],
                            ['month' => 'Mei 2025', 'users' => 28, 'classes' => 5],
                            ['month' => 'Jun 2025', 'users' => 42, 'classes' => 8],
                            ['month' => 'Jul 2025', 'users' => 67, 'classes' => 12],
                            ['month' => 'Agu 2025', 'users' => 89, 'classes' => 18],
                            ['month' => 'Sep 2025', 'users' => 124, 'classes' => 25],
                        ];
                    @endphp
                    
                    @foreach($monthlyData as $data)
                    <div class="bg-gradient-to-b from-gray-50 to-white border border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow duration-200">
                        <div class="text-xs font-medium text-gray-500 mb-2">{{ $data['month'] }}</div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-center space-x-1">
                                <i class="fas fa-users text-primary text-xs"></i>
                                <span class="text-lg font-bold text-primary">{{ $data['users'] }}</span>
                            </div>
                            <div class="flex items-center justify-center space-x-1">
                                <i class="fas fa-chalkboard-teacher text-secondary text-xs"></i>
                                <span class="text-sm font-semibold text-secondary">{{ $data['classes'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <i class="fas fa-chart-line text-blue-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-blue-800">Pertumbuhan User</div>
                        <div class="text-xl font-bold text-blue-900">+127%</div>
                        <div class="text-xs text-blue-600">6 bulan terakhir</div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <i class="fas fa-graduation-cap text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-green-800">Kelas Aktif</div>
                        <div class="text-xl font-bold text-green-900">{{ $stats['active_classes'] ?? 18 }}</div>
                        <div class="text-xs text-green-600">dari {{ $stats['total_classes'] ?? 25 }} total</div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        <i class="fas fa-star text-purple-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-purple-800">Rating Rata-rata</div>
                        <div class="text-xl font-bold text-purple-900">4.8/5</div>
                        <div class="text-xs text-purple-600">dari 156 ulasan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Recent Activity -->
            <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-primary to-secondary">
                    <h3 class="text-lg font-semibold text-white">Aktivitas Terbaru</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($stats['recent_users'] as $user)
                        <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center shadow-sm">
                                <span class="text-xs font-semibold text-white">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }} mendaftar</p>
                                <p class="text-xs text-gray-500">
                                    @if($user->role === 'admin')
                                        Administrator
                                    @elseif($user->role === 'educator')
                                        Pengajar
                                    @elseif($user->role === 'student')
                                        Siswa
                                    @else
                                        {{ ucfirst($user->role) }}
                                    @endif
                                    • {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                   ($user->role === 'educator' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                @if($user->role === 'admin')
                                    Admin
                                @elseif($user->role === 'educator')
                                    Pengajar
                                @elseif($user->role === 'student')
                                    Siswa
                                @else
                                    {{ ucfirst($user->role) }}
                                @endif
                            </span>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">Belum ada aktivitas terbaru</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Content Activities -->
            <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-secondary to-tertiary">
                    <h3 class="text-lg font-semibold text-white">Aktivitas Konten Terbaru</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentGeographyModels as $model)
                        <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-secondary to-tertiary rounded-full flex items-center justify-center shadow-sm">
                                <i class="fas fa-globe text-white text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ Str::limit($model->title, 35) }}</p>
                                <p class="text-xs text-gray-500">oleh {{ $model->educator->name }} • {{ $model->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $model->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $model->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        @empty
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-book text-white text-xs"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Cerita "Kerajaan Majapahit" dipublikasi</p>
                                    <p class="text-xs text-gray-500">15 menit yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-chalkboard-teacher text-white text-xs"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Kelas baru "Sejarah Indonesia" dibuat</p>
                                    <p class="text-xs text-gray-500">1 jam yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-map-marked-alt text-white text-xs"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Lokasi "Candi Borobudur" ditambahkan</p>
                                    <p class="text-xs text-gray-500">3 jam yang lalu</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-tertiary to-orange-500">
                    <h3 class="text-lg font-semibold text-white">Aksi Cepat</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('admin.users') }}" 
                           class="flex flex-col items-center p-4 bg-gradient-to-br from-primary to-secondary rounded-lg hover:shadow-lg transition-all duration-200 group transform hover:-translate-y-1">
                            <i class="fas fa-users text-white text-2xl mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="text-sm font-medium text-white">Kelola Pengguna</span>
                        </a>
                        
                        <a href="{{ route('admin.classes') }}" 
                           class="flex flex-col items-center p-4 bg-gradient-to-br from-secondary to-tertiary rounded-lg hover:shadow-lg transition-all duration-200 group transform hover:-translate-y-1">
                            <i class="fas fa-chalkboard-teacher text-white text-2xl mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="text-sm font-medium text-white">Kelola Kelas</span>
                        </a>
                        
                        <a href="{{ route('admin.content') }}" 
                           class="flex flex-col items-center p-4 bg-gradient-to-br from-tertiary to-orange-500 rounded-lg hover:shadow-lg transition-all duration-200 group transform hover:-translate-y-1">
                            <i class="fas fa-book-open text-white text-2xl mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="text-sm font-medium text-white">Kelola Konten</span>
                        </a>
                        
                        <a href="{{ route('admin.settings') }}" 
                           class="flex flex-col items-center p-4 bg-gradient-to-br from-gray-600 to-gray-700 rounded-lg hover:shadow-lg transition-all duration-200 group transform hover:-translate-y-1">
                            <i class="fas fa-cogs text-white text-2xl mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="text-sm font-medium text-white">Pengaturan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection