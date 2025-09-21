@extends('layouts.educator')

@section('page-title', $model->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('educator.geography-models.index') }}" 
                       class="mr-4 p-2 hover:bg-white hover:bg-opacity-20 rounded transition-colors">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $model->title }}</h1>
                        <p class="text-emerald-100 mt-1">{{ $model->category ? ucfirst(str_replace('_', ' ', $model->category)) : 'Model 3D' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-eye mr-1"></i>{{ $model->views }} views
                    </span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 m-6">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- 3D Model Display -->
        <div class="p-6">
            <div class="bg-gray-100 rounded-lg overflow-hidden mb-6" style="height: 500px;">
                @if($model->embed_code)
                    <div class="w-full h-full">
                        {!! $model->safe_embed_code !!}
                    </div>
                @else
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <i class="fas fa-cube text-gray-400 text-6xl mb-4"></i>
                            <p class="text-gray-500">Model 3D tidak tersedia</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Model Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi</h2>
                        @if($model->description)
                            <p class="text-gray-700 mb-4">{{ $model->description }}</p>
                        @endif
                        
                        @if($model->detailed_description)
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Penjelasan Lengkap</h3>
                            <div class="text-gray-700 leading-relaxed">
                                {!! nl2br(e($model->detailed_description)) !!}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Model Details -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Model</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Kategori:</span>
                                <p class="text-gray-900">{{ $model->category ? ucfirst(str_replace('_', ' ', $model->category)) : '-' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Status:</span>
                                <p class="text-gray-900">
                                    @if($model->is_active)
                                        <span class="inline-flex items-center bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                            <i class="fas fa-check mr-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                            <i class="fas fa-times mr-1"></i>Tidak Aktif
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Visibilitas:</span>
                                <p class="text-gray-900">{{ $model->is_public ? 'Publik' : 'Pribadi' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Dibuat:</span>
                                <p class="text-gray-900">{{ $model->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Diperbarui:</span>
                                <p class="text-gray-900">{{ $model->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3">
                        <a href="{{ route('educator.geography-models.edit', $model) }}" 
                           class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-lg font-medium transition-colors text-center block">
                            <i class="fas fa-edit mr-2"></i>Edit Model
                        </a>
                        
                        <button onclick="shareModel({{ $model->id }})" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-share mr-2"></i>Bagikan Model
                        </button>
                        
                        <button onclick="toggleStatus({{ $model->id }}, {{ $model->is_active ? 'false' : 'true' }})" 
                                class="w-full {{ $model->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-{{ $model->is_active ? 'pause' : 'play' }} mr-2"></i>
                            {{ $model->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                        
                        <button onclick="deleteModel({{ $model->id }}, '{{ addslashes($model->title) }}')" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-trash mr-2"></i>Hapus Model
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
            </div>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus model 3D "<span id="modelTitle"></span>"? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function shareModel(modelId) {
    const url = `${window.location.origin}/educator/geography-models/${modelId}`;
    
    if (navigator.share) {
        navigator.share({
            title: 'Model 3D Geografi',
            text: 'Lihat model 3D interaktif untuk pembelajaran geografi',
            url: url
        });
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin ke clipboard!');
        }).catch(() => {
            const tempInput = document.createElement('input');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Link berhasil disalin ke clipboard!');
        });
    }
}

function toggleStatus(modelId, newStatus) {
    fetch(`/educator/geography-models/${modelId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ is_active: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengubah status model');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function deleteModel(modelId, modelTitle) {
    document.getElementById('modelTitle').textContent = modelTitle;
    document.getElementById('deleteForm').action = `/educator/geography-models/${modelId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection