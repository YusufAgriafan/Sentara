@extends('layouts.educator')

@section('page-title', 'Model 3D Geografi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Model 3D Geografi</h1>
                <p class="text-gray-600">Kelola koleksi model 3D geografi Anda</p>
            </div>
            <a href="{{ route('educator.dashboard') }}#geography-form" onclick="setTimeout(() => toggleGeographySection(), 500)" 
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Model 3D
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex">
                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Models Grid -->
        @if($geographyModels->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($geographyModels as $model)
                    <div class="bg-white rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                        <!-- Model Preview -->
                        <div class="aspect-video bg-gradient-to-br from-emerald-100 to-teal-100 rounded-t-lg flex items-center justify-center">
                            @if($model->embed_code)
                                <div class="w-full h-full rounded-t-lg overflow-hidden">
                                    {!! $model->safe_embed_code !!}
                                </div>
                            @else
                                <i class="fas fa-cube text-emerald-600 text-4xl"></i>
                            @endif
                        </div>
                        
                        <!-- Model Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $model->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($model->description, 100) }}</p>
                            
                            @if($model->category)
                                <span class="inline-block bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs mb-3">
                                    {{ ucfirst(str_replace('_', ' ', $model->category)) }}
                                </span>
                            @endif
                            
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                <span><i class="fas fa-eye mr-1"></i>{{ $model->views }} views</span>
                                <span><i class="fas fa-calendar mr-1"></i>{{ $model->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('educator.geography-models.show', $model) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm text-center transition-colors">
                                    <i class="fas fa-eye mr-1"></i>Lihat
                                </a>
                                <a href="{{ route('educator.geography-models.edit', $model) }}" 
                                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded text-sm text-center transition-colors">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <button onclick="shareModel({{ $model->id }})" 
                                        class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                    <i class="fas fa-share mr-1"></i>Bagikan
                                </button>
                                <button onclick="deleteModel({{ $model->id }}, '{{ addslashes($model->title) }}')" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $geographyModels->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
                <i class="fas fa-cube text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Model 3D</h3>
                <p class="text-gray-500 mb-6">Mulai buat model 3D pertama Anda untuk pembelajaran geografi yang lebih interaktif</p>
                <a href="{{ route('educator.dashboard') }}#geography-form" onclick="setTimeout(() => toggleGeographySection(), 500)" 
                   class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Model 3D Pertama
                </a>
            </div>
        @endif
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

function deleteModel(modelId, modelTitle) {
    document.getElementById('modelTitle').textContent = modelTitle;
    document.getElementById('deleteForm').action = `${window.location.origin}/educator/geography-models/${modelId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection