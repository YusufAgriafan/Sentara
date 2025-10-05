@extends('layouts.main')

@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <!-- Welcome Section -->
        <div class="bg-primary rounded-3xl p-6 sm:p-8 text-white mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-blue-100 text-lg">{{ $currentClass ? 'Kelas: ' . $currentClass->name : 'Belum terdaftar di kelas' }}</p>
                </div>
                <div class="hidden sm:block">
                    <div class="bg-white bg-opacity-20 rounded-2xl p-4 sm:p-6 text-center">
                        <div class="bg-white w-12 h-12 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-graduation-cap text-primary text-xl sm:text-2xl"></i>
                        </div>
                        <p class="font-semibold text-sm sm:text-base">{{ $currentClass?->grade ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($currentClass)
            <!-- Class Statistics -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border-2 border-quaternary hover:border-green-300 transition-colors">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="bg-green-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mb-3 sm:mb-0 sm:mr-4">
                            <i class="fas fa-map-marker-alt text-white text-lg sm:text-xl"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Tempat Wisata</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $assignedPlaces->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border-2 border-quaternary hover:border-blue-300 transition-colors">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="bg-blue-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mb-3 sm:mb-0 sm:mr-4">
                            <i class="fas fa-book text-white text-lg sm:text-xl"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Cerita Tersedia</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $assignedStories->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border-2 border-quaternary hover:border-purple-300 transition-colors">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="bg-purple-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mb-3 sm:mb-0 sm:mr-4">
                            <i class="fas fa-comments text-white text-lg sm:text-xl"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Diskusi Aktif</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $activeDiscussions->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border-2 border-quaternary hover:border-yellow-300 transition-colors">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="bg-yellow-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mb-3 sm:mb-0 sm:mr-4">
                            <i class="fas fa-star text-white text-lg sm:text-xl"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Pencapaian</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $achievements ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-6 sm:mb-8">
                <!-- Assigned Places -->
                <div class="bg-white rounded-2xl border-2 border-quaternary p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <div class="bg-green-500 w-10 h-10 rounded-2xl flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                                Tempat Wisata Kelas Anda
                            </h2>
                        </div>
                        <a href="{{ route('student.places') }}" class="text-green-600 hover:text-green-800 text-sm font-semibold bg-green-50 px-4 py-2 rounded-2xl transition-colors">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($assignedPlaces->take(3) as $place)
                            <div class="flex items-center p-4 bg-green-50 border-2 border-green-100 rounded-2xl hover:bg-green-100 transition-colors">
                                <div class="flex-shrink-0">
                                    @php
                                        $eraIcons = [
                                            'prasejarah' => 'fa-mountain',
                                            'kerajaan' => 'fa-crown',
                                            'penjajahan' => 'fa-fort-awesome',
                                            'kemerdekaan' => 'fa-flag'
                                        ];
                                        $eraColors = [
                                            'prasejarah' => 'bg-amber-500',
                                            'kerajaan' => 'bg-yellow-500',
                                            'penjajahan' => 'bg-red-500',
                                            'kemerdekaan' => 'bg-blue-500'
                                        ];
                                    @endphp
                                    <div class="w-12 h-12 {{ $eraColors[$place->era] ?? 'bg-green-500' }} rounded-2xl flex items-center justify-center">
                                        <i class="fas {{ $eraIcons[$place->era] ?? 'fa-map-marker-alt' }} text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $place->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $place->location }} • {{ ucfirst($place->era) }}</p>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('student.places.show', $place) }}" 
                                       class="bg-green-500 text-white w-8 h-8 rounded-xl flex items-center justify-center hover:bg-green-600 transition-colors">
                                        <i class="fas fa-chevron-right text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="bg-gray-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500">Belum ada tempat wisata yang di-assign ke kelas Anda</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Assigned Stories -->
                <div class="bg-white rounded-2xl border-2 border-quaternary p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <div class="bg-blue-500 w-10 h-10 rounded-2xl flex items-center justify-center mr-3">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                                Cerita untuk Kelas Anda
                            </h2>
                        </div>
                        <a href="{{ route('student.stories') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold bg-blue-50 px-4 py-2 rounded-2xl transition-colors">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($assignedStories->take(3) as $story)
                            <div class="flex items-center p-4 bg-blue-50 border-2 border-blue-100 rounded-2xl hover:bg-blue-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-scroll text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $story->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $story->place->name }}</p>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('student.stories.show', $story) }}" 
                                       class="bg-blue-500 text-white w-8 h-8 rounded-xl flex items-center justify-center hover:bg-blue-600 transition-colors">
                                        <i class="fas fa-chevron-right text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="bg-gray-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-book text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500">Belum ada cerita yang di-assign ke kelas Anda</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Active Discussions -->
            @if($activeDiscussions->count() > 0)
                <div class="bg-white rounded-2xl border-2 border-quaternary p-6 sm:p-8 mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <div class="bg-purple-500 w-10 h-10 rounded-2xl flex items-center justify-center mr-3">
                                <i class="fas fa-comments text-white"></i>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                                Diskusi Aktif
                            </h2>
                        </div>
                        <a href="{{ route('student.discussions') }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold bg-purple-50 px-4 py-2 rounded-2xl transition-colors">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($activeDiscussions->take(2) as $discussion)
                            <div class="p-6 bg-purple-50 border-2 border-purple-100 rounded-2xl">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between mb-4">
                                    <h3 class="font-semibold text-gray-900 mb-2 sm:mb-0">{{ $discussion->title }}</h3>
                                    <div class="bg-purple-500 text-white px-3 py-1 rounded-2xl text-sm font-semibold flex items-center">
                                        <i class="fas fa-comments mr-2"></i>
                                        {{ $discussion->responses_count ?? 0 }} respon
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit($discussion->description, 100) }}</p>
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                    <span class="text-sm text-gray-500 mb-2 sm:mb-0">{{ $discussion->created_at->diffForHumans() }}</span>
                                    <a href="{{ route('student.discussions.show', $discussion) }}" 
                                       class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-2xl text-sm font-semibold transition-colors">
                                        Ikut Diskusi
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl border-2 border-quaternary p-6 sm:p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-gray-500 w-10 h-10 rounded-2xl flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                        Aktivitas Terbaru
                    </h2>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentActivities ?? [] as $activity)
                        <div class="flex items-start p-4 border-l-4 {{ $activity['type'] === 'story' ? 'border-blue-500 bg-blue-50' : ($activity['type'] === 'place' ? 'border-green-500 bg-green-50' : 'border-purple-500 bg-purple-50') }} rounded-r-2xl">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 {{ $activity['type'] === 'story' ? 'bg-blue-500' : ($activity['type'] === 'place' ? 'bg-green-500' : 'bg-purple-500') }} rounded-2xl flex items-center justify-center">
                                    <i class="fas {{ $activity['type'] === 'story' ? 'fa-book' : ($activity['type'] === 'place' ? 'fa-map-marker-alt' : 'fa-comments') }} text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-900 font-medium">{{ $activity['message'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="bg-gray-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clock text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500">Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>

        @else
            <!-- Not Enrolled in Class -->
            <div class="bg-white rounded-3xl border-2 border-quaternary p-8 sm:p-12 text-center">
                <div class="bg-gray-100 w-20 h-20 sm:w-24 sm:h-24 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-graduate text-gray-400 text-2xl sm:text-3xl"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Belum Terdaftar di Kelas</h3>
                <p class="text-gray-600 mb-8 leading-relaxed max-w-md mx-auto">Anda belum terdaftar di kelas manapun. Hubungi guru Anda untuk mendapatkan token kelas.</p>
                
                <div class="max-w-lg mx-auto">
                    <form action="{{ route('student.classes.join.submit') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <input type="text" 
                               name="class_token" 
                               placeholder="Masukkan token kelas"
                               class="flex-1 border-2 border-gray-300 rounded-2xl px-4 py-3 focus:ring-primary focus:border-primary transition-colors"
                               required>
                        <button type="submit" 
                                class="bg-primary hover:bg-blue-600 text-white px-6 py-3 rounded-2xl font-semibold transition-all duration-200 hover:scale-105 transform">
                            Join Kelas
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection