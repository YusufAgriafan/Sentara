@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Konten Kelas</h1>
                <p class="text-gray-600 mt-1">{{ $class->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('educator.classes') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Kelas
                </a>
                <a href="{{ route('educator.classes.content.create', $class) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Konten
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Tempat</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $assignedPlaces->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Cerita</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $assignedPlaces->sum(function($place) { return $place->stories->count(); }) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tersedia</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $availablePlaces->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Konten yang Sudah Ditambahkan</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Daftar tempat dan cerita yang tersedia untuk kelas ini</p>
        </div>

        @if($assignedPlaces->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($assignedPlaces as $place)
                    <li>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="flex items-center">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $place->name }}</h4>
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $place->era === 'prasejarah' ? 'green' : ($place->era === 'kerajaan' ? 'blue' : ($place->era === 'penjajahan' ? 'red' : 'purple')) }}-100 text-{{ $place->era === 'prasejarah' ? 'green' : ($place->era === 'kerajaan' ? 'blue' : ($place->era === 'penjajahan' ? 'red' : 'purple')) }}-800">
                                                {{ ucfirst($place->era) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $place->location }}</p>
                                        <p class="text-sm text-gray-500">{{ $place->stories->count() }} cerita tersedia</p>
                                        @if($place->description)
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($place->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button type="button" onclick="toggleStories({{ $place->id }})" 
                                            class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Lihat Cerita
                                    </button>
                                    <form action="{{ route('educator.classes.content.destroy', [$class, $place]) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus konten ini dari kelas?')"
                                                class="text-red-600 hover:text-red-900 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Stories List (Hidden by default) -->
                            <div id="stories-{{ $place->id }}" class="hidden mt-4 pl-14">
                                <div class="border-l-2 border-gray-200 pl-4">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Cerita untuk {{ $place->name }}:</h5>
                                    @forelse($place->stories as $story)
                                        <div class="mb-2 p-3 bg-gray-50 rounded">
                                            <h6 class="text-sm font-medium text-gray-900">{{ $story->title }}</h6>
                                            <p class="text-xs text-gray-600">{{ Str::limit($story->content, 150) }}</p>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">Belum ada cerita untuk tempat ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="px-4 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada konten</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan tempat dan cerita untuk kelas ini.</p>
                <div class="mt-6">
                    <a href="{{ route('educator.classes.content.create', $class) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Tambah Konten Pertama
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function toggleStories(placeId) {
    const storiesDiv = document.getElementById('stories-' + placeId);
    if (storiesDiv.classList.contains('hidden')) {
        storiesDiv.classList.remove('hidden');
    } else {
        storiesDiv.classList.add('hidden');
    }
}
</script>
@endsection