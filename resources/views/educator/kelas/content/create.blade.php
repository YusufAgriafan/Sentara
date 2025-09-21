@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Konten ke Kelas</h1>
                <p class="text-gray-600 mt-1">{{ $class->name }}</p>
            </div>
            <a href="{{ route('educator.classes.content.index', $class) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>

    @if($availablePlaces->count() > 0)
        <form action="{{ route('educator.classes.content.store', $class) }}" method="POST">
            @csrf
            
            <!-- Search and Filter -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Cari Tempat</label>
                        <input type="text" id="search" placeholder="Nama tempat atau lokasi..."
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               onkeyup="filterPlaces()">
                    </div>
                    <div>
                        <label for="era-filter" class="block text-sm font-medium text-gray-700">Filter Era</label>
                        <select id="era-filter" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                onchange="filterPlaces()">
                            <option value="">Semua Era</option>
                            <option value="prasejarah">Prasejarah</option>
                            <option value="kerajaan">Kerajaan</option>
                            <option value="penjajahan">Penjajahan</option>
                            <option value="kemerdekaan">Kemerdekaan</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="selectAll()" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Pilih Semua
                        </button>
                        <button type="button" onclick="deselectAll()" 
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal Pilih
                        </button>
                    </div>
                </div>
            </div>

            <!-- Selected Count -->
            <div class="mb-4">
                <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                    <p class="text-sm text-blue-800">
                        <span id="selected-count">0</span> tempat dipilih untuk ditambahkan ke kelas.
                    </p>
                </div>
            </div>

            <!-- Places Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6" id="places-grid">
                @foreach($availablePlaces as $place)
                    <div class="place-item bg-white rounded-lg shadow-md overflow-hidden" 
                         data-name="{{ strtolower($place->name) }}" 
                         data-location="{{ strtolower($place->location) }}" 
                         data-era="{{ $place->era }}">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           name="place_ids[]" 
                                           value="{{ $place->id }}" 
                                           id="place-{{ $place->id }}"
                                           class="place-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                           onchange="updateSelectedCount()">
                                    <label for="place-{{ $place->id }}" class="ml-3 text-lg font-semibold text-gray-900 cursor-pointer">
                                        {{ $place->name }}
                                    </label>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                           bg-{{ $place->era === 'prasejarah' ? 'green' : ($place->era === 'kerajaan' ? 'blue' : ($place->era === 'penjajahan' ? 'red' : 'purple')) }}-100 
                                           text-{{ $place->era === 'prasejarah' ? 'green' : ($place->era === 'kerajaan' ? 'blue' : ($place->era === 'penjajahan' ? 'red' : 'purple')) }}-800">
                                    {{ ucfirst($place->era) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <p class="text-sm text-gray-600">
                                    <svg class="inline h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $place->location }}
                                </p>
                                @if($place->coordinate)
                                    <p class="text-xs text-gray-500">
                                        Koordinat: {{ $place->coordinate->latitude }}, {{ $place->coordinate->longitude }}
                                    </p>
                                @endif
                            </div>

                            @if($place->description)
                                <p class="text-sm text-gray-700 mb-3">{{ Str::limit($place->description, 100) }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    {{ $place->stories->count() }} cerita
                                </div>
                                <button type="button" onclick="togglePlaceStories({{ $place->id }})" 
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat Cerita
                                </button>
                            </div>

                            <!-- Stories Preview (Hidden by default) -->
                            <div id="place-stories-{{ $place->id }}" class="hidden mt-3 pt-3 border-t border-gray-200">
                                @forelse($place->stories as $story)
                                    <div class="mb-2 p-2 bg-gray-50 rounded text-sm">
                                        <h6 class="font-medium text-gray-900">{{ $story->title }}</h6>
                                        <p class="text-gray-600 text-xs">{{ Str::limit($story->content, 80) }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada cerita untuk tempat ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ada tempat yang sesuai dengan kriteria pencarian.</p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('educator.classes.content.index', $class) }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded"
                        id="submit-btn" disabled>
                    Tambah ke Kelas
                </button>
            </div>
        </form>
    @else
        <!-- No Available Places -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4.5M9 6h6" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Semua konten sudah ditambahkan</h3>
                <p class="mt-1 text-sm text-gray-500">Semua tempat yang tersedia sudah ditambahkan ke kelas ini.</p>
                <div class="mt-6">
                    <a href="{{ route('educator.classes.content.index', $class) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Kembali ke Kelola Konten
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function filterPlaces() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const eraFilter = document.getElementById('era-filter').value;
    const placeItems = document.querySelectorAll('.place-item');
    let visibleCount = 0;

    placeItems.forEach(item => {
        const name = item.dataset.name;
        const location = item.dataset.location;
        const era = item.dataset.era;

        const matchesSearch = name.includes(searchTerm) || location.includes(searchTerm);
        const matchesEra = !eraFilter || era === eraFilter;

        if (matchesSearch && matchesEra) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Show/hide no results message
    const noResults = document.getElementById('no-results');
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }
}

function selectAll() {
    const visibleCheckboxes = document.querySelectorAll('.place-item:not([style*="display: none"]) .place-checkbox');
    visibleCheckboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    updateSelectedCount();
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('.place-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkedBoxes = document.querySelectorAll('.place-checkbox:checked');
    const count = checkedBoxes.length;
    
    document.getElementById('selected-count').textContent = count;
    
    // Enable/disable submit button
    const submitBtn = document.getElementById('submit-btn');
    if (count > 0) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

function togglePlaceStories(placeId) {
    const storiesDiv = document.getElementById('place-stories-' + placeId);
    if (storiesDiv.classList.contains('hidden')) {
        storiesDiv.classList.remove('hidden');
    } else {
        storiesDiv.classList.add('hidden');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedCount();
});
</script>
@endsection