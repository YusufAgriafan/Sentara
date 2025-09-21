@extends('layouts.educator')

@section('page-title', 'Manajemen Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Diskusi</h1>
                <p class="text-gray-600 mt-1">Kelola diskusi kelas untuk engagement aktif</p>
            </div>
            <a href="{{ route('educator.discussions.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Buat Diskusi Baru
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-comments text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Diskusi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $discussions->total() ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-play-circle text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Diskusi Aktif</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $discussions->where('status', 'active')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu Review</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $discussions->where('status', 'pending')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-reply text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Respon</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalResponses ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('educator.discussions.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Diskusi</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Judul diskusi atau topik..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Class Filter -->
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select id="class_id" name="class_id" class="w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kelas</option>
                        @foreach($myClasses ?? [] as $class)
                            @if(is_object($class) && isset($class->id))
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ isset($class->name) ? $class->name : '' }}{{ isset($class->grade) ? ' (' . $class->grade . ')' : '' }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                    <select id="sort" name="sort" class="w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="most_responses" {{ request('sort') == 'most_responses' ? 'selected' : '' }}>Paling Banyak Respon</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-2">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
                <a href="{{ route('educator.discussions.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Warning Section -->
    <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Panduan Manajemen Diskusi</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Diskusi yang dihapus akan menghilangkan semua respon siswa secara permanen</li>
                        <li>Mengubah status diskusi ke "Ditutup" akan mencegah siswa menambah respon baru</li>
                        <li>Diskusi "Pending" membutuhkan review sebelum dapat dilihat siswa</li>
                        <li>Pastikan untuk membalas respon siswa secara berkala untuk menjaga engagement</li>
                        <li>Gunakan filter untuk mengelola diskusi berdasarkan kelas dan status</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Discussions List -->
    <div class="space-y-4">
        @forelse($discussions ?? [] as $discussion)
            @if($discussion && is_object($discussion))
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <!-- Discussion Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $discussion->name ?? $discussion->title ?? 'Untitled Discussion' }}</h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-chalkboard mr-2"></i>
                                    <span>{{ $discussion->class->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>{{ $discussion->created_at ? $discussion->created_at->format('d M Y') : 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>{{ $discussion->created_at ? $discussion->created_at->diffForHumans() : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'closed' => 'bg-gray-100 text-gray-800'
                                ];
                                $statusIcons = [
                                    'active' => 'fa-play-circle',
                                    'pending' => 'fa-clock',
                                    'closed' => 'fa-stop-circle'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$discussion->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800' }}">
                                <i class="fas {{ $statusIcons[$discussion->status ?? 'pending'] ?? 'fa-question-circle' }} mr-1"></i>
                                {{ ucfirst($discussion->status ?? 'pending') }}
                            </span>
                        </div>
                    </div>

                    <!-- Discussion Content -->
                    <div class="mb-4">
                        <p class="text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($discussion->class_discussion_message ?? $discussion->description ?? 'Tidak ada deskripsi'), 150) }}</p>
                    </div>

                    <!-- Discussion Stats -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="fas fa-reply mr-1"></i>
                                <span>{{ $discussion->responses_count ?? 0 }} respon</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users mr-1"></i>
                                <span>{{ $discussion->participants_count ?? 0 }} partisipan</span>
                            </div>
                            @if(isset($discussion->deadline) && $discussion->deadline)
                                <div class="flex items-center {{ $discussion->deadline->isPast() ? 'text-red-500' : 'text-gray-500' }}">
                                    <i class="fas fa-hourglass-end mr-1"></i>
                                    <span>{{ $discussion->deadline->format('d M Y') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="flex items-center space-x-1">
                            @if(isset($discussion->id))
                                <a href="{{ route('educator.discussions.show', $discussion) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Lihat Diskusi">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('educator.discussions.edit', $discussion) }}" 
                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="toggleDiscussionStatus('{{ $discussion->id ?? '' }}', '{{ $discussion->status ?? 'pending' }}')"
                                        class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors"
                                        title="Ubah Status">
                                    <i class="fas fa-toggle-on text-sm"></i>
                                </button>
                                <button onclick="deleteDiscussion('{{ $discussion->id ?? '' }}', '{{ $discussion->name ?? $discussion->title ?? 'Discussion' }}')"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Responses Preview -->
                    @if(isset($discussion->recent_responses) && $discussion->recent_responses && $discussion->recent_responses->count() > 0)
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Respon Terbaru:</h4>
                            <div class="space-y-2">
                                @foreach($discussion->recent_responses->take(2) as $response)
                                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                                <span class="text-white text-xs font-medium">
                                                    {{ isset($response->student->name) ? substr($response->student->name, 0, 1) : 'S' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2">
                                                <p class="text-sm font-medium text-gray-900">{{ $response->student->name ?? 'Student' }}</p>
                                                <span class="text-xs text-gray-500">{{ isset($response->created_at) ? $response->created_at->diffForHumans() : 'N/A' }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($response->content, 100) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                @if(isset($discussion->responses_count) && $discussion->responses_count > 2)
                                    <div class="text-center">
                                        @if(isset($discussion->id))
                                            <a href="{{ route('educator.discussions.show', $discussion) }}" 
                                               class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                Lihat {{ ($discussion->responses_count ?? 0) - 2 }} respon lainnya
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        @empty
            <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <i class="fas fa-comments text-3xl"></i>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada diskusi</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat diskusi pertama untuk kelas Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('educator.discussions.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Buat Diskusi Baru
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($discussions) && $discussions->hasPages())
        <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
            {{ $discussions->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Status Change Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Ubah Status Diskusi</h3>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="statusModalContent">
                <form id="statusForm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="new_status" value="active" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-900">Aktif - Siswa dapat merespon</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="new_status" value="pending" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-900">Pending - Menunggu review</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="new_status" value="closed" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-900">Ditutup - Tidak dapat merespon</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeStatusModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                            <i class="fas fa-save mr-2"></i>Ubah Status
                        </button>
                    </div>
                </form>
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
                <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Diskusi</h3>
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
let currentDiscussionId = null;

// Status change functions
function toggleDiscussionStatus(discussionId, currentStatus) {
    currentDiscussionId = discussionId;
    document.getElementById('statusModal').classList.remove('hidden');
    
    // Pre-select current status
    const radios = document.querySelectorAll('input[name="new_status"]');
    radios.forEach(radio => {
        radio.checked = radio.value === currentStatus;
    });
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    currentDiscussionId = null;
}

document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const newStatus = formData.get('new_status');
    
    if (!newStatus) {
        alert('Pilih status baru');
        return;
    }
    
    fetch(`/educator/discussions/${currentDiscussionId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeStatusModal();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error updating status');
    });
});

// Delete modal functions
function deleteDiscussion(discussionId, discussionTitle) {
    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus diskusi "${discussionTitle}"? Semua respon akan ikut terhapus dan tindakan ini tidak dapat dibatalkan.`;
    document.getElementById('deleteForm').action = `/educator/discussions/${discussionId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modals on outside click
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) closeStatusModal();
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection