@extends('layouts.educator')

@section('page-title', 'Edit Model 3D')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('educator.geography-models.show', $model) }}" 
                   class="mr-4 p-2 hover:bg-gray-100 rounded transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Model 3D</h1>
                    <p class="text-gray-600">{{ $model->title }}</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex">
                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                    <div>
                        <h5 class="font-semibold mb-1">Terdapat kesalahan:</h5>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('educator.geography-models.update', $model) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Model <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" 
                               placeholder="Contoh: Struktur Internal Bumi"
                               value="{{ old('title', $model->title) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title') border-red-500 @enderror"
                               required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select id="category" name="category" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('category') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="geologi" {{ old('category', $model->category) == 'geologi' ? 'selected' : '' }}>Geologi</option>
                            <option value="geografi_fisik" {{ old('category', $model->category) == 'geografi_fisik' ? 'selected' : '' }}>Geografi Fisik</option>
                            <option value="geomorfologi" {{ old('category', $model->category) == 'geomorfologi' ? 'selected' : '' }}>Geomorfologi</option>
                            <option value="hidrologi" {{ old('category', $model->category) == 'hidrologi' ? 'selected' : '' }}>Hidrologi</option>
                            <option value="klimatologi" {{ old('category', $model->category) == 'klimatologi' ? 'selected' : '' }}>Klimatologi</option>
                            <option value="biogeografi" {{ old('category', $model->category) == 'biogeografi' ? 'selected' : '' }}>Biogeografi</option>
                            <option value="geografi_manusia" {{ old('category', $model->category) == 'geografi_manusia' ? 'selected' : '' }}>Geografi Manusia</option>
                            <option value="kartografi" {{ old('category', $model->category) == 'kartografi' ? 'selected' : '' }}>Kartografi</option>
                            <option value="astronomi" {{ old('category', $model->category) == 'astronomi' ? 'selected' : '' }}>Astronomi</option>
                            <option value="lainnya" {{ old('category', $model->category) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                        <textarea id="description" name="description" rows="3"
                                  placeholder="Deskripsi singkat untuk preview..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description') border-red-500 @enderror">{{ old('description', $model->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Detailed Description -->
                    <div>
                        <label for="detailed_description" class="block text-sm font-medium text-gray-700 mb-2">Penjelasan Lengkap</label>
                        <textarea id="detailed_description" name="detailed_description" rows="6"
                                  placeholder="Jelaskan secara detail tentang model 3D ini, bagaimana menggunakannya dalam pembelajaran, konsep yang dipelajari, dll..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('detailed_description') border-red-500 @enderror">{{ old('detailed_description', $model->detailed_description) }}</textarea>
                        @error('detailed_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Settings -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Pengaturan</h3>
                        
                        <!-- Public/Private -->
                        <div class="flex items-center">
                            <input type="checkbox" id="is_public" name="is_public" value="1" 
                                   {{ old('is_public', $model->is_public) ? 'checked' : '' }}
                                   class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                            <label for="is_public" class="ml-2 block text-sm text-gray-700">
                                Model dapat dilihat publik
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Embed Code -->
                    <div>
                        <label for="embed_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Embed Model 3D <span class="text-red-500">*</span>
                            <span class="text-xs text-gray-500">(Sketchfab, ArtStation, atau platform 3D lainnya)</span>
                        </label>
                        <textarea id="embed_code" name="embed_code" rows="8"
                                  placeholder='<div class="sketchfab-embed-wrapper"><iframe title="Earth Internal Structure" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/..."></iframe></div>'
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-mono text-sm @error('embed_code') border-red-500 @enderror"
                                  required>{{ old('embed_code', $model->embed_code) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Salin kode embed dari platform seperti Sketchfab, ArtStation, atau platform 3D model lainnya
                        </p>
                        @error('embed_code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preview Button -->
                    <div>
                        <button type="button" onclick="previewModel()" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-eye mr-2"></i>Preview Model
                        </button>
                    </div>

                    <!-- Preview Section -->
                    <div id="model-preview" class="hidden">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Preview Model 3D</h4>
                        <div id="preview-content" class="min-h-[300px] bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center">
                            <p class="text-gray-500">Preview akan muncul di sini...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    <a href="{{ route('educator.geography-models.show', $model) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" onclick="resetForm()" 
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-undo mr-2"></i>Reset
                    </button>
                    <button type="submit" 
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewModel() {
    const embedCode = document.getElementById('embed_code').value.trim();
    const previewContent = document.getElementById('preview-content');
    const previewSection = document.getElementById('model-preview');
    
    if (!embedCode) {
        alert('Masukkan kode embed terlebih dahulu');
        return;
    }
    
    try {
        previewContent.innerHTML = embedCode;
        previewSection.classList.remove('hidden');
        previewSection.scrollIntoView({ behavior: 'smooth' });
    } catch (error) {
        alert('Kode embed tidak valid');
        console.error('Preview error:', error);
    }
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.')) {
        // Reset to original values
        document.getElementById('title').value = '{{ $model->title }}';
        document.getElementById('category').value = '{{ $model->category }}';
        document.getElementById('description').value = '{{ $model->description }}';
        document.getElementById('detailed_description').value = '{{ $model->detailed_description }}';
        document.getElementById('embed_code').value = `{{ $model->embed_code }}`;
        document.getElementById('is_public').checked = {{ $model->is_public ? 'true' : 'false' }};
        
        // Hide preview
        document.getElementById('model-preview').classList.add('hidden');
        document.getElementById('preview-content').innerHTML = '<p class="text-gray-500">Preview akan muncul di sini...</p>';
    }
}

// Auto-save draft (optional enhancement)
let autoSaveTimer;
function autoSave() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        // Save to localStorage as draft
        const formData = {
            title: document.getElementById('title').value,
            category: document.getElementById('category').value,
            description: document.getElementById('description').value,
            detailed_description: document.getElementById('detailed_description').value,
            embed_code: document.getElementById('embed_code').value,
            is_public: document.getElementById('is_public').checked
        };
        localStorage.setItem('edit_model_{{ $model->id }}_draft', JSON.stringify(formData));
    }, 2000);
}

// Add event listeners for auto-save
document.querySelectorAll('input, textarea, select').forEach(element => {
    element.addEventListener('input', autoSave);
});

// Load draft on page load
window.addEventListener('load', () => {
    const draft = localStorage.getItem('edit_model_{{ $model->id }}_draft');
    if (draft) {
        const data = JSON.parse(draft);
        if (confirm('Ditemukan draft yang belum disimpan. Apakah Anda ingin memulihkannya?')) {
            document.getElementById('title').value = data.title || '';
            document.getElementById('category').value = data.category || '';
            document.getElementById('description').value = data.description || '';
            document.getElementById('detailed_description').value = data.detailed_description || '';
            document.getElementById('embed_code').value = data.embed_code || '';
            document.getElementById('is_public').checked = data.is_public || false;
        }
    }
});

// Clear draft on successful submit
document.querySelector('form').addEventListener('submit', () => {
    localStorage.removeItem('edit_model_{{ $model->id }}_draft');
});
</script>
@endsection