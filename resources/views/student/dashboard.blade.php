@extends('layouts.student')

@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100 mt-1">{{ $currentClass ? 'Kelas: ' . $currentClass->name : 'Belum terdaftar di kelas' }}</p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <div class="text-center">
                        <i class="fas fa-graduation-cap text-3xl mb-2"></i>
                        <p class="font-semibold">{{ $currentClass?->grade ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($currentClass)
        <!-- Class Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-map-marker-alt text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tempat Wisata</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $assignedPlaces->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-book text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Cerita Tersedia</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $assignedStories->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <i class="fas fa-comments text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Diskusi Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $activeDiscussions->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <i class="fas fa-star text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pencapaian</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $achievements ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Assigned Places -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                        Tempat Wisata Kelas Anda
                    </h2>
                    <a href="{{ route('student.places') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="space-y-3">
                    @forelse($assignedPlaces->take(3) as $place)
                        <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="flex-shrink-0">
                                @php
                                    $eraIcons = [
                                        'prasejarah' => 'fa-mountain',
                                        'kerajaan' => 'fa-crown',
                                        'penjajahan' => 'fa-fort-awesome',
                                        'kemerdekaan' => 'fa-flag'
                                    ];
                                @endphp
                                <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center">
                                    <i class="fas {{ $eraIcons[$place->era] ?? 'fa-map-marker-alt' }} text-green-700"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $place->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $place->location }} • {{ ucfirst($place->era) }}</p>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('student.places.show', $place) }}" 
                                   class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada tempat wisata yang di-assign ke kelas Anda</p>
                    @endforelse
                </div>
            </div>

            <!-- Assigned Stories -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-book text-blue-600 mr-2"></i>
                        Cerita untuk Kelas Anda
                    </h2>
                    <a href="{{ route('student.stories') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="space-y-3">
                    @forelse($assignedStories->take(3) as $story)
                        <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-scroll text-blue-700"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $story->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $story->place->name }}</p>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('student.stories.show', $story) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada cerita yang di-assign ke kelas Anda</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Active Discussions -->
        @if($activeDiscussions->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-comments text-purple-600 mr-2"></i>
                        Diskusi Aktif
                    </h2>
                    <a href="{{ route('student.discussions') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="space-y-3">
                    @foreach($activeDiscussions->take(2) as $discussion)
                        <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-sm font-medium text-gray-900">{{ $discussion->title }}</h3>
                                <span class="text-xs text-purple-600 bg-purple-100 px-2 py-1 rounded">
                                    {{ $discussion->responses_count ?? 0 }} respon
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($discussion->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">{{ $discussion->created_at->diffForHumans() }}</span>
                                <a href="{{ route('student.discussions.show', $discussion) }}" 
                                   class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                    Ikut Diskusi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-clock text-gray-600 mr-2"></i>
                Aktivitas Terbaru
            </h2>
            
            <div class="space-y-3">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="flex items-center p-3 border-l-4 {{ $activity['type'] === 'story' ? 'border-blue-400 bg-blue-50' : ($activity['type'] === 'place' ? 'border-green-400 bg-green-50' : 'border-purple-400 bg-purple-50') }}">
                        <div class="flex-shrink-0">
                            <i class="fas {{ $activity['type'] === 'story' ? 'fa-book' : ($activity['type'] === 'place' ? 'fa-map-marker-alt' : 'fa-comments') }} {{ $activity['type'] === 'story' ? 'text-blue-600' : ($activity['type'] === 'place' ? 'text-green-600' : 'text-purple-600') }}"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-900">{{ $activity['message'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>

    @else
        <!-- Not Enrolled in Class -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
            <div class="mx-auto h-16 w-16 text-gray-400 mb-4">
                <i class="fas fa-user-graduate text-4xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Terdaftar di Kelas</h3>
            <p class="text-gray-600 mb-6">Anda belum terdaftar di kelas manapun. Hubungi guru Anda untuk mendapatkan token kelas.</p>
            
            <div class="max-w-md mx-auto">
                <form action="{{ route('student.join-class') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="text" 
                           name="token" 
                           placeholder="Masukkan token kelas"
                           class="flex-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           required>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Join Kelas
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection