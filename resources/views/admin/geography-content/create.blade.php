@extends('layouts.admin')

@section('page-title', 'Tambah Konten Geografi')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Konten Geografi</h1>
                <p class="text-gray-600 mt-1">Buat penjelasan materi geografi terstruktur baru</p>
            </div>
            <a href="{{ route('admin.geography-content.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.geography-content.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Materi <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       placeholder="Contoh: PENGETAHUAN DASAR GEOGRAFI"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-red-500 @enderror"
                       required>
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Singkat
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          placeholder="Penjelasan singkat tentang materi ini..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Konten Materi <span class="text-red-500">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          class="summernote @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Order Index -->
                <div>
                    <label for="order_index" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan
                    </label>
                    <input type="number" 
                           id="order_index" 
                           name="order_index" 
                           value="{{ old('order_index', 0) }}"
                           min="0"
                           placeholder="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('order_index') border-red-500 @enderror">
                    @error('order_index')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Angka untuk menentukan urutan tampil</p>
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon (Font Awesome)
                    </label>
                    <input type="text" 
                           id="icon" 
                           name="icon" 
                           value="{{ old('icon') }}"
                           placeholder="fas fa-globe"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('icon') border-red-500 @enderror">
                    @error('icon')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Contoh: fas fa-globe, fas fa-mountain</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select id="is_active" 
                            name="is_active" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('is_active') border-red-500 @enderror">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.geography-content.index') }}" 
               class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="bg-gradient-to-r from-primary to-secondary hover:from-primary-dark hover:to-secondary-dark text-white px-8 py-3 rounded-lg font-medium transition-all duration-300 hover:scale-105 shadow-lg">
                <i class="fas fa-save mr-2"></i>
                Simpan Konten
            </button>
        </div>
    </form>
</div>

<!-- Icon Preview Modal -->
<div id="iconPreviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 shadow-xl">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Icon</h3>
            <div class="text-center py-8">
                <i id="iconPreview" class="text-6xl text-primary mb-4"></i>
                <p class="text-sm text-gray-600">Icon yang dipilih</p>
            </div>
            <div class="flex justify-end">
                <button onclick="closeIconPreview()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Summernote
    $('.summernote').summernote({
        height: 400,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        placeholder: 'Masukkan konten materi geografi di sini...\n\nAnda bisa menggunakan berbagai format seperti:\n- Teks berformat\n- Daftar dengan bullet points\n- Gambar\n- Tabel untuk data\n- Link ke sumber referensi',
        tabsize: 2,
        focus: false,
        disableResizeEditor: true
    });

    // Auto-generate slug from title
    $('#title').on('input', function() {
        let title = $(this).val();
        let slug = title.toLowerCase()
                       .replace(/[^a-z0-9\s]/g, '')
                       .replace(/\s+/g, '-')
                       .replace(/-+/g, '-');
        // Display slug preview (you can add a slug field if needed)
    });

    // Icon preview
    $('#icon').on('input', function() {
        let iconClass = $(this).val();
        if (iconClass) {
            $('#iconPreview').attr('class', iconClass + ' text-6xl text-primary mb-4');
            $('#iconPreviewModal').removeClass('hidden').addClass('flex');
            
            // Auto-close preview after 2 seconds
            setTimeout(function() {
                closeIconPreview();
            }, 2000);
        }
    });
});

function closeIconPreview() {
    $('#iconPreviewModal').addClass('hidden').removeClass('flex');
}

// Close modal when clicking outside
document.getElementById('iconPreviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeIconPreview();
    }
});
</script>
@endpush
@endsection