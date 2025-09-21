@extends('layouts.educator')

@section('page-title', 'Manajemen Cerita')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Cerita</h1>
                <p class="text-gray-600 mt-1">Kelola cerita untuk tempat wisata sejarah</p>
            </div>
            <a href="{{ route('educator.stories.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Cerita
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-book text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Cerita</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stories->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sudah Dipublish</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stories->where('is_published', true)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Draft</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stories->where('is_published', false)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tempat Tercakup</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stories->pluck('historical_id')->unique()->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('educator.stories.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Cerita</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Judul cerita atau tempat..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Era Filter -->
                <div>
                    <label for="era" class="block text-sm font-medium text-gray-700 mb-1">Era</label>
                    <select id="era" name="era" class="w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Era</option>
                        <option value="prasejarah" {{ request('era') == 'prasejarah' ? 'selected' : '' }}>Prasejarah</option>
                        <option value="kerajaan" {{ request('era') == 'kerajaan' ? 'selected' : '' }}>Kerajaan</option>
                        <option value="penjajahan" {{ request('era') == 'penjajahan' ? 'selected' : '' }}>Penjajahan</option>
                        <option value="kemerdekaan" {{ request('era') == 'kemerdekaan' ? 'selected' : '' }}>Kemerdekaan</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublish</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                    <select id="sort" name="sort" class="w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                        <option value="place" {{ request('sort') == 'place' ? 'selected' : '' }}>Tempat A-Z</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-2">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
                <a href="{{ route('educator.stories.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Stories Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($stories as $story)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Story Header -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 line-clamp-2 mb-2">{{ $story->title }}</h3>
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $story->place->name }}</span>
                            </div>
                        </div>
                        @php
                            $eraColors = [
                                'prasejarah' => 'bg-green-100 text-green-800',
                                'kerajaan' => 'bg-blue-100 text-blue-800',
                                'penjajahan' => 'bg-red-100 text-red-800',
                                'kemerdekaan' => 'bg-purple-100 text-purple-800'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $eraColors[$story->place->era] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($story->place->era) }}
                        </span>
                    </div>

                    <!-- Story Preview -->
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($story->content), 120) }}
                    </p>

                    <!-- Story Stats -->
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-1"></i>
                            <span>{{ $story->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            <span>{{ $story->views ?? 0 }} views</span>
                        </div>
                    </div>

                    <!-- Status and Actions -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($story->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Published
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Draft
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center space-x-1">
                            <a href="{{ route('educator.stories.show', $story) }}" 
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                               title="Lihat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('educator.stories.edit', $story) }}" 
                               class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                               title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <button onclick="deleteStory('{{ $story->id }}', '{{ $story->title }}')"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Assign Section -->
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1"></i>
                            {{ $story->classes->count() }} kelas terpasang
                        </span>
                        <button onclick="openAssignModal('{{ $story->id }}', '{{ $story->title }}')"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i>Atur Kelas
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-book text-3xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada cerita</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat cerita pertama Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('educator.stories.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>Tambah Cerita
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($stories->hasPages())
        <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
            {{ $stories->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Quick Assign Modal -->
<div id="assignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Atur Kelas untuk Cerita</h3>
                <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="assignModalContent">
                <p class="text-gray-600 mb-4">Loading...</p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center mb-4">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Cerita</h3>
                <p class="text-sm text-gray-500 mb-4" id="deleteMessage"></p>
                <div class="flex justify-center space-x-3">
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Quick assign modal functions
function openAssignModal(storyId, storyTitle) {
    document.getElementById('assignModal').classList.remove('hidden');
    document.getElementById('assignModalContent').innerHTML = '<p class="text-gray-600">Loading...</p>';
    
    // Load classes for assignment
    fetch(`/educator/stories/${storyId}/classes`)
        .then(response => response.json())
        .then(data => {
            let content = `
                <p class="text-gray-600 mb-4">Pilih kelas untuk cerita: <strong>${storyTitle}</strong></p>
                <form id="assignForm" onsubmit="assignClasses(event, ${storyId})">
                    <div class="space-y-2 max-h-64 overflow-y-auto">
            `;
            
            data.classes.forEach(classItem => {
                const isAssigned = data.assignedClasses.includes(classItem.id);
                content += `
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer ${isAssigned ? 'bg-blue-50 border-blue-200' : 'border-gray-200'}">
                        <input type="checkbox" 
                               name="classes[]" 
                               value="${classItem.id}"
                               ${isAssigned ? 'checked' : ''}
                               class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">${classItem.name}</div>
                            <div class="text-sm text-gray-500">${classItem.grade} • ${classItem.students_count} siswa</div>
                        </div>
                    </label>
                `;
            });
            
            content += `
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeAssignModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            `;
            
            document.getElementById('assignModalContent').innerHTML = content;
        })
        .catch(error => {
            document.getElementById('assignModalContent').innerHTML = '<p class="text-red-600">Error loading data</p>';
        });
}

function closeAssignModal() {
    document.getElementById('assignModal').classList.add('hidden');
}

function assignClasses(event, storyId) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const classes = formData.getAll('classes[]');
    
    fetch(`/educator/stories/${storyId}/assign-classes`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ classes: classes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeAssignModal();
            location.reload(); // Refresh to show updated class counts
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error assigning classes');
    });
}

// Delete modal functions
function deleteStory(storyId, storyTitle) {
    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus cerita "${storyTitle}"? Tindakan ini tidak dapat dibatalkan.`;
    document.getElementById('deleteForm').action = `/educator/stories/${storyId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modals on outside click
document.getElementById('assignModal').addEventListener('click', function(e) {
    if (e.target === this) closeAssignModal();
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>


    <!-- Pagination -->
    @if($stories->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            {{ $stories->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection