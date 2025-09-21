@extends('layouts.educator')

@section('page-title', 'Beranda')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Beranda Pengajar</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- My Classes Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500 truncate">Kelas Saya</dt>
                        <dd class="text-lg font-medium text-gray-900">5</dd>
                    </div>
                </div>
            </div>

            <!-- Total Students Card -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Siswa</dt>
                        <dd class="text-lg font-medium text-gray-900">125</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Menu Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('educator.classes') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>
                    Kelola Kelas
                </a>
                <a href="{{ route('educator.discussions.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                    <i class="fas fa-comments mr-2"></i>
                    Diskusi Kelas
                </a>
                <a href="{{ route('educator.content.library') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                    <i class="fas fa-book mr-2"></i>
                    Perpustakaan Materi
                </a>
                <a href="{{ route('educator.students') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    <i class="fas fa-users mr-2"></i>
                    Lihat Siswa
                </a>
            </div>
        </div>

        <!-- Geography 3D Models Section -->
        <div class="mt-8" id="geography-models">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="bg-emerald-600 p-3 rounded-lg mr-4">
                            <i class="fas fa-globe-americas text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Geografi & Model 3D</h3>
                            <p class="text-gray-600">Tambahkan penjelasan geografi dengan model 3D interaktif untuk pembelajaran yang lebih menarik</p>
                        </div>
                    </div>
                    <button onclick="toggleGeographySection()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Tambah Model 3D
                    </button>
                </div>

                <!-- 3D Model Input Form (Hidden by default) -->
                <div id="geography-form" class="hidden bg-white rounded-lg p-6 border border-emerald-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Tambah Model 3D Geografi</h4>
                    
                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
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
                    
                    <form action="{{ route('educator.geography-models.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Title -->
                            <div>
                                <label for="model_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Model</label>
                                <input type="text" id="model_title" name="model_title" 
                                       placeholder="Contoh: Struktur Internal Bumi"
                                       value="{{ old('model_title') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('model_title') border-red-500 @enderror">
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="model_category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <select id="model_category" name="model_category" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('model_category') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="geologi" {{ old('model_category') == 'geologi' ? 'selected' : '' }}>Geologi</option>
                                    <option value="astronomi" {{ old('model_category') == 'astronomi' ? 'selected' : '' }}>Astronomi</option>
                                    <option value="klimatologi" {{ old('model_category') == 'klimatologi' ? 'selected' : '' }}>Klimatologi</option>
                                    <option value="geografi_fisik" {{ old('model_category') == 'geografi_fisik' ? 'selected' : '' }}>Geografi Fisik</option>
                                    <option value="kartografi" {{ old('model_category') == 'kartografi' ? 'selected' : '' }}>Kartografi</option>
                                    <option value="lainnya" {{ old('model_category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="model_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea id="model_description" name="model_description" rows="2"
                                      placeholder="Deskripsi singkat untuk preview..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('model_description') border-red-500 @enderror">{{ old('model_description') }}</textarea>
                        </div>

                        <!-- Detailed Description -->
                        <div>
                            <label for="detailed_description" class="block text-sm font-medium text-gray-700 mb-2">Penjelasan Lengkap</label>
                            <textarea id="detailed_description" name="detailed_description" rows="4"
                                      placeholder="Jelaskan secara detail tentang model 3D ini, bagaimana menggunakannya dalam pembelajaran, konsep yang dipelajari, dll..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('detailed_description') border-red-500 @enderror">{{ old('detailed_description') }}</textarea>
                        </div>

                        <!-- Class Assignment -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pengaturan Akses</label>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Publik (dapat dilihat semua orang)</span>
                                </label>
                                
                                @if(isset($educatorClasses) && $educatorClasses->count() > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Atau assign ke kelas tertentu:</label>
                                    <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto">
                                        @foreach($educatorClasses as $class)
                                        <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50">
                                            <input type="checkbox" name="assigned_classes[]" value="{{ $class->id }}"
                                                   {{ in_array($class->id, old('assigned_classes', [])) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">{{ $class->name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Embed Code -->
                        <div>
                            <label for="embed_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Embed Model 3D
                                <span class="text-xs text-gray-500">(Sketchfab, ArtStation, atau platform 3D lainnya)</span>
                            </label>
                            <textarea id="embed_code" name="embed_code" rows="4"
                                      placeholder='<div class="sketchfab-embed-wrapper"><iframe title="Earth Internal Structure" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/..."></iframe></div>'
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-mono text-sm @error('embed_code') border-red-500 @enderror">{{ old('embed_code') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Salin kode embed dari platform seperti Sketchfab, ArtStation, atau platform 3D model lainnya
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-save mr-2"></i>Simpan Model 3D
                            </button>
                            <button type="button" onclick="previewModel()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="button" onclick="toggleGeographySection()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-times mr-2"></i>Batal
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Preview Section -->
                <div id="model-preview" class="hidden bg-white rounded-lg p-6 border border-emerald-200 mt-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Preview Model 3D</h4>
                    <div id="preview-content" class="min-h-[400px] bg-gray-50 rounded-lg flex items-center justify-center">
                        <p class="text-gray-500">Preview akan muncul di sini...</p>
                    </div>
                </div>

                <!-- Existing 3D Models Grid -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Model 3D yang Tersedia</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Display existing models -->
                        @if(isset($geographyModels) && $geographyModels->count() > 0)
                            @foreach($geographyModels as $model)
                                <div class="bg-white rounded-lg border border-emerald-200 p-4 hover:shadow-lg transition-shadow">
                                    <div class="aspect-video bg-gradient-to-br from-emerald-100 to-teal-100 rounded-lg mb-3 flex items-center justify-center">
                                        <i class="fas fa-cube text-emerald-600 text-3xl"></i>
                                    </div>
                                    <h5 class="font-semibold text-gray-900 mb-2">{{ $model->title }}</h5>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($model->description, 80) }}</p>
                                    @if($model->category)
                                        <span class="inline-block bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs mb-3">{{ ucfirst($model->category) }}</span>
                                    @endif
                                    <div class="text-xs text-gray-500 mb-3">
                                        <i class="fas fa-eye mr-1"></i>{{ $model->views }} views
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <a href="{{ route('educator.geography-models.show', $model) }}" 
                                           class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-sm transition-colors text-center">
                                            <i class="fas fa-eye mr-1"></i>Lihat
                                        </a>
                                        <a href="{{ route('educator.geography-models.edit', $model) }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors text-center">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 mt-2">
                                        <button onclick="shareModel({{ $model->id }})" 
                                                class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                            <i class="fas fa-share mr-1"></i>Bagikan
                                        </button>
                                        <a href="{{ route('educator.geography-models.index') }}" 
                                           class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm transition-colors text-center">
                                            <i class="fas fa-list mr-1"></i>Semua
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- No models message -->
                            <div class="col-span-full bg-white rounded-lg border-2 border-dashed border-emerald-300 p-8 text-center">
                                <i class="fas fa-cube text-emerald-400 text-4xl mb-4"></i>
                                <h5 class="font-semibold text-gray-700 mb-2">Belum Ada Model 3D</h5>
                                <p class="text-gray-500 mb-4">Mulai buat model 3D pertama Anda untuk pembelajaran geografi yang lebih interaktif</p>
                                <button onclick="toggleGeographySection()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-plus mr-2"></i>Tambah Model 3D
                                </button>
                            </div>
                        @endif

                        <!-- Add Model Card (only show if there are existing models) -->
                        @if(isset($geographyModels) && $geographyModels->count() > 0)
                            <div class="bg-white rounded-lg border-2 border-dashed border-emerald-300 p-4 hover:border-emerald-500 transition-colors cursor-pointer" onclick="toggleGeographySection()">
                                <div class="aspect-video bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg mb-3 flex items-center justify-center">
                                    <i class="fas fa-plus text-emerald-400 text-3xl"></i>
                                </div>
                                <h5 class="font-semibold text-emerald-600 mb-2 text-center">Tambah Model 3D</h5>
                                <p class="text-sm text-gray-500 text-center">Klik untuk menambahkan model 3D baru</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleGeographySection() {
    const form = document.getElementById('geography-form');
    const preview = document.getElementById('model-preview');
    
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        preview.classList.add('hidden');
        // Reset form
        form.querySelector('form').reset();
        document.getElementById('preview-content').innerHTML = '<p class="text-gray-500">Preview akan muncul di sini...</p>';
    } else {
        form.classList.add('hidden');
        preview.classList.add('hidden');
    }
}

function previewModel() {
    const embedCode = document.getElementById('embed_code').value.trim();
    const previewContent = document.getElementById('preview-content');
    const previewSection = document.getElementById('model-preview');
    
    if (!embedCode) {
        alert('Masukkan kode embed terlebih dahulu!');
        return;
    }
    
    // Sanitize and validate embed code
    if (embedCode.includes('<iframe') || embedCode.includes('<div')) {
        previewContent.innerHTML = embedCode;
        previewSection.classList.remove('hidden');
        
        // Scroll to preview
        previewSection.scrollIntoView({ behavior: 'smooth' });
    } else {
        alert('Kode embed tidak valid. Pastikan kode berisi iframe atau div embed.');
    }
}

// Auto-resize textarea
document.getElementById('embed_code').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// View model function
function viewModel(modelId, embedCode) {
    const previewContent = document.getElementById('preview-content');
    const previewSection = document.getElementById('model-preview');
    
    previewContent.innerHTML = embedCode;
    previewSection.classList.remove('hidden');
    
    // Scroll to preview
    previewSection.scrollIntoView({ behavior: 'smooth' });
}

// Share model function
function shareModel(modelId) {
    const url = `${window.location.origin}/educator/geography-models/${modelId}`;
    
    if (navigator.share) {
        navigator.share({
            title: 'Model 3D Geografi',
            text: 'Lihat model 3D interaktif untuk pembelajaran geografi',
            url: url
        });
    } else {
        // Fallback to clipboard
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin ke clipboard!');
        }).catch(() => {
            // Fallback for older browsers
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

// Example of 3D model interaction
function showExampleModel() {
    const exampleEmbed = `
        <div class="sketchfab-embed-wrapper" style="width: 100%; height: 400px;">
            <iframe title="Earth's Internal Structure – Core to Atmosphere" 
                    frameborder="0" 
                    allowfullscreen 
                    mozallowfullscreen="true" 
                    webkitallowfullscreen="true" 
                    allow="autoplay; fullscreen; xr-spatial-tracking" 
                    xr-spatial-tracking 
                    execution-while-out-of-viewport 
                    execution-while-not-rendered 
                    web-share 
                    style="width: 100%; height: 100%;"
                    src="https://sketchfab.com/models/e8d8a3c3e8f64b70b9b50b8b4c4b5d0f/embed">
            </iframe>
        </div>
    `;
    
    document.getElementById('embed_code').value = exampleEmbed;
    document.getElementById('model_title').value = "Struktur Internal Bumi";
    document.getElementById('model_category').value = "geologi";
    document.getElementById('model_description').value = "Model 3D interaktif yang menunjukkan lapisan-lapisan bumi mulai dari inti dalam, inti luar, mantel, hingga kerak bumi dan atmosfer.";
    
    toggleGeographySection();
}

// Show form if there are validation errors
@if ($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        toggleGeographySection();
    });
@endif
</script>
@endsection