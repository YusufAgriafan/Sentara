@extends('layouts.admin')

@section('page-title', 'Pengelolaan Konten Geografi')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Konten Geografi</h1>
                <p class="text-gray-600 mt-1">Kelola penjelasan materi geografi terstruktur</p>
            </div>
            <a href="{{ route('admin.geography-content.create') }}" 
               class="bg-gradient-to-r from-primary to-secondary hover:from-primary-dark hover:to-secondary-dark text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:scale-105 shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Tambah Konten
            </a>
        </div>
    </div>

    <!-- Content List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Konten Geografi</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urutan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul & Deskripsi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dibuat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contents as $content)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($content->icon)
                                    <i class="{{ $content->icon }} text-2xl text-primary mr-3"></i>
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-book text-white text-sm"></i>
                                    </div>
                                @endif
                                <span class="text-lg font-bold text-gray-900">{{ $content->order_index }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $content->title }}</h3>
                                @if($content->description)
                                    <p class="text-sm text-gray-600">{{ Str::limit($content->description, 100) }}</p>
                                @endif
                                <div class="text-xs text-gray-400 mt-1">
                                    Slug: {{ $content->slug }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($content->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause-circle mr-1"></i>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $content->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.geography-content.edit', $content) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <button onclick="deleteContent({{ $content->id }}, '{{ addslashes($content->title) }}')" 
                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-800 rounded-lg transition-colors duration-200">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="text-6xl mb-4">📚</div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada konten geografi</h3>
                                <p class="text-gray-500 mb-6">Mulai dengan menambahkan konten geografi pertama</p>
                                <a href="{{ route('admin.geography-content.create') }}" 
                                   class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Konten Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($contents->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $contents->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 shadow-xl">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Hapus Konten Geografi</h3>
                    <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus konten ini?</p>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                <p class="text-sm font-medium text-gray-900" id="deleteContentTitle"></p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteContent(id, title) {
    document.getElementById('deleteContentTitle').textContent = title;
    document.getElementById('deleteForm').action = `/admin/geography-content/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection