@extends('layouts.educator')

@section('page-title', 'Perpustakaan Materi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Perpustakaan Materi</h1>
                <p class="text-gray-600 mt-1">Kelola semua materi pembelajaran sejarah</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('educator.places.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Tempat
                </a>
                <a href="{{ route('educator.stories.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Cerita
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Places -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Tempat</p>
                    <p class="text-3xl font-bold">{{ $totalPlaces }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-map-marked-alt text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('educator.places.index') }}" 
                   class="text-blue-100 hover:text-white text-sm font-medium transition-colors">
                    Kelola Tempat <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Total Stories -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Cerita</p>
                    <p class="text-3xl font-bold">{{ $totalStories }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-scroll text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('educator.stories.index') }}" 
                   class="text-green-100 hover:text-white text-sm font-medium transition-colors">
                    Kelola Cerita <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- My Classes -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Kelas Saya</p>
                    <p class="text-3xl font-bold">{{ $myClasses }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-chalkboard text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('educator.content.assignments') }}" 
                   class="text-purple-100 hover:text-white text-sm font-medium transition-colors">
                    Lihat Assignment <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Places -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Tempat Terbaru</h2>
                    <a href="{{ route('educator.places.index') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                @forelse($recentPlaces as $place)
                    <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $place->name }}</p>
                                <p class="text-xs text-gray-500">{{ $place->location }} • {{ ucfirst($place->era) }}</p>
                                <p class="text-xs text-gray-400">{{ $place->stories->count() }} cerita</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('educator.places.show', $place) }}" 
                               class="text-blue-600 hover:text-blue-800 text-xs">
                                Lihat
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-map-marked-alt text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Belum ada tempat</p>
                        <a href="{{ route('educator.places.create') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Tambah tempat pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Stories -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Cerita Terbaru</h2>
                    <a href="{{ route('educator.stories.index') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                @forelse($recentStories as $story)
                    <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-book-open text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $story->title }}</p>
                                <p class="text-xs text-gray-500">{{ $story->place->name }}</p>
                                <p class="text-xs text-gray-400">{{ Str::limit($story->content, 50) }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('educator.stories.show', $story) }}" 
                               class="text-blue-600 hover:text-blue-800 text-xs">
                                Lihat
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-scroll text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Belum ada cerita</p>
                        <a href="{{ route('educator.stories.create') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Tambah cerita pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Access Menu -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Akses Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('educator.places.index') }}" 
               class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center mb-2">
                    <i class="fas fa-map-marked-alt text-blue-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-900">Kelola Tempat</span>
            </a>
            
            <a href="{{ route('educator.stories.index') }}" 
               class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="h-12 w-12 rounded-lg bg-green-100 flex items-center justify-center mb-2">
                    <i class="fas fa-scroll text-green-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-900">Kelola Cerita</span>
            </a>
            
            <a href="{{ route('educator.content.assignments') }}" 
               class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="h-12 w-12 rounded-lg bg-purple-100 flex items-center justify-center mb-2">
                    <i class="fas fa-tasks text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-900">Assignment</span>
            </a>
            
            <a href="{{ route('educator.discussions.index') }}" 
               class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="h-12 w-12 rounded-lg bg-yellow-100 flex items-center justify-center mb-2">
                    <i class="fas fa-comments text-yellow-600 text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-900">Diskusi</span>
            </a>
        </div>
    </div>
</div>
@endsection