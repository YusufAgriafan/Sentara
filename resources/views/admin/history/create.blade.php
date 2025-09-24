@extends('layouts.admin')

@section('page-title', 'Tambah Data Sejarah')

@section('content')
<!-- H                    <select name="subcategory" id="subcategory" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('subcategory') border-red-500 @else border-gray-300 @enderror"
                            onchange="updateSubSubcategories()">
                        <option value="">Pilih Sub Kategori</option>
                    </select> Card -->
<d                    <select name="sub_subcategory" id="sub_subcategory" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('sub_subcategory') border-red-500 @else border-gray-300 @enderror">
                        <option value="">Pilih Sub Sub Kategori</option>
                    </select>lass="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-2">Tambah Data Sejarah</h1>
                <p class="text-sm sm:text-base text-gray-600">Buat konten sejarah baru dengan editor yang lengkap</p>
            </div>
            <a href="{{ route('admin.history.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg flex items-center justify-center text-sm sm:text-base">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200">
    <form action="{{ route('admin.history.store') }}" method="POST" class="p-4 sm:p-6 lg:p-8">
        @csrf
        
        <!-- Basic Information -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-info-circle text-primary mr-3"></i>
                Informasi Dasar
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-primary mr-2"></i>
                        Judul *
                    </label>
                    <input type="text" name="title" id="title" 
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('title') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('title') }}" placeholder="Masukkan judul sejarah" required>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="order_index" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-sort-numeric-up text-primary mr-2"></i>
                        Urutan *
                    </label>
                    <input type="number" name="order_index" id="order_index" min="0"
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('order_index') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('order_index', 0) }}" required>
                    @error('order_index')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Category Selection -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-sitemap text-primary mr-3"></i>
                Kategorisasi
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-folder text-primary mr-2"></i>
                        Kategori *
                    </label>
                    <select name="category" id="category" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('category') border-red-500 @else border-gray-300 @enderror"
                            required onchange="updateSubcategories()">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="subcategory" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-folder-open text-primary mr-2"></i>
                        Sub Kategori
                    </label>
                    <select name="subcategory" id="subcategory" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('subcategory') border-red-500 @else border-gray-300 @enderror"
                            onchange="updateSubSubcategories()">
                        <option value="">Pilih Sub Kategori</option>
                    </select>
                    @error('subcategory')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="sub_subcategory" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt text-primary mr-2"></i>
                        Sub Sub Kategori
                    </label>
                    <select name="sub_subcategory" id="sub_subcategory" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('sub_subcategory') border-red-500 @else border-gray-300 @enderror">
                        <option value="">Pilih Sub Sub Kategori</option>
                    </select>
                    @error('sub_subcategory')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-toggle-on text-primary mr-3"></i>
                Pengaturan
            </h3>
            
            <div class="bg-gray-50 p-4 sm:p-6 rounded-xl">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 sm:h-5 sm:w-5 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="is_active" class="ml-3 flex items-center text-sm font-medium text-gray-900">
                        <i class="fas fa-eye text-green-500 mr-2"></i>
                        Status Aktif (Tampilkan di halaman publik)
                    </label>
                </div>
            </div>
        </div>

        <!-- Content Editor -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-edit text-primary mr-3"></i>
                Konten
            </h3>
            
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-paragraph text-primary mr-2"></i>
                    Konten Sejarah
                </label>
                <textarea name="content" id="content" rows="10"
                          class="summernote w-full px-3 sm:px-4 py-2 sm:py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 text-sm sm:text-base @error('content') border-red-500 @else border-gray-300 @enderror"
                          placeholder="Masukkan konten sejarah dengan detail yang lengkap...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Gunakan editor untuk menambahkan format teks, gambar, dan media lainnya
                </p>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4 sm:pt-6 border-t border-gray-200">
            <button type="button" onclick="window.history.back()" 
                    class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg flex items-center justify-center text-sm sm:text-base">
                <i class="fas fa-times mr-2"></i>
                Batal
            </button>
            <button type="submit" 
                    class="px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-primary to-secondary hover:from-primary-dark hover:to-secondary-dark text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105 flex items-center justify-center text-sm sm:text-base">
                <i class="fas fa-save mr-2"></i>
                Simpan Data
            </button>
        </div>
    </form>
<script>
    // Data subcategories dan sub-subcategories
    const subcategories = @json($subcategories);
    const subSubcategories = @json($subSubcategories);

    function updateSubcategories() {
        const category = document.getElementById('category').value;
        const subcategorySelect = document.getElementById('subcategory');
        const subSubcategorySelect = document.getElementById('sub_subcategory');
        
        // Reset subcategory and sub-subcategory
        subcategorySelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
        subSubcategorySelect.innerHTML = '<option value="">Pilih Sub Sub Kategori</option>';
        
        if (category && subcategories[category]) {
            subcategories[category].forEach(function(subcategory) {
                const option = document.createElement('option');
                option.value = subcategory;
                option.textContent = subcategory;
                if ('{{ old('subcategory') }}' === subcategory) {
                    option.selected = true;
                }
                subcategorySelect.appendChild(option);
            });
        }
        
        // Update sub-subcategories jika ada subcategory yang dipilih
        updateSubSubcategories();
    }

    function updateSubSubcategories() {
        const subcategory = document.getElementById('subcategory').value;
        const subSubcategorySelect = document.getElementById('sub_subcategory');
        
        // Reset sub-subcategory
        subSubcategorySelect.innerHTML = '<option value="">Pilih Sub Sub Kategori</option>';
        
        if (subcategory && subSubcategories[subcategory]) {
            subSubcategories[subcategory].forEach(function(subSubcategory) {
                const option = document.createElement('option');
                option.value = subSubcategory;
                option.textContent = subSubcategory;
                if ('{{ old('sub_subcategory') }}' === subSubcategory) {
                    option.selected = true;
                }
                subSubcategorySelect.appendChild(option);
            });
        }
    }

    // Initialize pada page load
    document.addEventListener('DOMContentLoaded', function() {
        updateSubcategories();
    });
</script>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Summernote
    $('.summernote').summernote({
        height: 350,
        placeholder: 'Masukkan konten sejarah dengan detail yang lengkap...',
        tabsize: 2,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                uploadImage(files[0]);
            }
        }
    });
    
    console.log('Summernote initialized for create page');
});

function uploadImage(file) {
    let data = new FormData();
    data.append("file", file);
    data.append("_token", "{{ csrf_token() }}");
    
    $.ajax({
        url: "{{ route('admin.history.upload-image') }}",
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            $('.summernote').summernote('insertImage', response.url);
        },
        error: function() {
            alert('Error uploading image');
        }
    });
}
</script>
@endpush