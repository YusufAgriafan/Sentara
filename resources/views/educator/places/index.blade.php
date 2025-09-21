@extends('layouts.educator')

@section('page-title', 'Historical Places')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Historical Places</h1>
                <p class="text-gray-600 mt-1">Kelola semua tempat wisata sejarah</p>
            </div>
            <a href="{{ route('educator.places.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Tempat Baru
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('educator.places.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Tempat</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nama atau lokasi..."
                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="era" class="block text-sm font-medium text-gray-700 mb-1">Era</label>
                <select id="era" 
                        name="era"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Era</option>
                    <option value="prasejarah" {{ request('era') == 'prasejarah' ? 'selected' : '' }}>Prasejarah</option>
                    <option value="kerajaan" {{ request('era') == 'kerajaan' ? 'selected' : '' }}>Kerajaan</option>
                    <option value="penjajahan" {{ request('era') == 'penjajahan' ? 'selected' : '' }}>Penjajahan</option>
                    <option value="kemerdekaan" {{ request('era') == 'kemerdekaan' ? 'selected' : '' }}>Kemerdekaan</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
            
            <div class="flex items-end">
                <a href="{{ route('educator.places.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Places Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($places as $place)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <!-- Place Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $place->name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                   bg-{{ $place->era === 'prasejarah' ? 'green' : ($place->era === 'kerajaan' ? 'blue' : ($place->era === 'penjajahan' ? 'red' : 'purple')) }}-100 
                                   text-{{ $place->era === 'prasejarah' ? 'green' : ($place->era === 'kerajaan' ? 'blue' : ($place->era === 'penjajahan' ? 'red' : 'purple')) }}-800">
                            {{ ucfirst($place->era) }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                            <span>{{ $place->location }}</span>
                        </div>
                        
                        @if($place->coordinate)
                            <div class="flex items-center">
                                <i class="fas fa-globe mr-2 text-gray-400"></i>
                                <span>{{ $place->coordinate->latitude }}, {{ $place->coordinate->longitude }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center">
                            <i class="fas fa-scroll mr-2 text-gray-400"></i>
                            <span>{{ $place->stories->count() }} cerita</span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-chalkboard mr-2 text-gray-400"></i>
                            <span>{{ $place->classes->count() }} kelas menggunakan</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($place->description)
                    <div class="p-4 border-b border-gray-200">
                        <p class="text-sm text-gray-700">{{ Str::limit($place->description, 120) }}</p>
                    </div>
                @endif

                <!-- Actions -->
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="{{ route('educator.places.show', $place) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat Detail
                            </a>
                        </div>
                        
                        <!-- Quick Assign Button -->
                        <button type="button" 
                                onclick="openQuickAssignModal({{ $place->id }}, '{{ $place->name }}')"
                                class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded font-medium">
                            <i class="fas fa-plus mr-1"></i>Assign
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                    <i class="fas fa-map-marked-alt text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada tempat</h3>
                    <p class="text-gray-600 mb-4">Mulai dengan menambahkan tempat wisata sejarah pertama</p>
                    <a href="{{ route('educator.places.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Tambah Tempat Pertama
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($places->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            {{ $places->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Quick Assign Modal -->
<div id="quickAssignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Quick Assign</h3>
                <button onclick="closeQuickAssignModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="quickAssignForm" method="POST">
                @csrf
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-3">Assign <span id="placeName" class="font-medium"></span> ke kelas:</p>
                    
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($myClasses as $class)
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="class_ids[]" 
                                       value="{{ $class->id }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ $class->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeQuickAssignModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openQuickAssignModal(placeId, placeName) {
    document.getElementById('placeName').textContent = placeName;
    document.getElementById('quickAssignForm').action = `/educator/places/${placeId}/quick-assign`;
    document.getElementById('quickAssignModal').classList.remove('hidden');
    document.getElementById('quickAssignModal').classList.add('flex');
}

function closeQuickAssignModal() {
    document.getElementById('quickAssignModal').classList.add('hidden');
    document.getElementById('quickAssignModal').classList.remove('flex');
    // Reset form
    document.getElementById('quickAssignForm').reset();
}

// Close modal when clicking outside
document.getElementById('quickAssignModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickAssignModal();
    }
});
</script>
@endsection