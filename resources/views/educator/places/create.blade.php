@extends('layouts.educator')

@section('page-title', 'Tambah Tempat Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Tempat Sejarah Baru</h1>
                <p class="text-gray-600 mt-1">Tambahkan tempat wisata sejarah ke dalam koleksi konten</p>
            </div>
            <a href="{{ route('educator.places.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('educator.places.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Tempat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                           placeholder="Contoh: Candi Borobudur">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           value="{{ old('location') }}"
                           required
                           class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('location') ? 'border-red-500' : 'border-gray-300' }}"
                           placeholder="Contoh: Magelang, Jawa Tengah">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Era Selection -->
            <div>
                <label for="era" class="block text-sm font-medium text-gray-700 mb-2">
                    Era Sejarah <span class="text-red-500">*</span>
                </label>
                <select id="era" 
                        name="era" 
                        required
                        class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('era') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">Pilih Era</option>
                    <option value="prasejarah" {{ old('era') == 'prasejarah' ? 'selected' : '' }}>Prasejarah</option>
                    <option value="kerajaan" {{ old('era') == 'kerajaan' ? 'selected' : '' }}>Kerajaan</option>
                    <option value="penjajahan" {{ old('era') == 'penjajahan' ? 'selected' : '' }}>Penjajahan</option>
                    <option value="kemerdekaan" {{ old('era') == 'kemerdekaan' ? 'selected' : '' }}>Kemerdekaan</option>
                </select>
                @error('era')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Coordinates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Latitude <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="latitude" 
                           name="latitude" 
                           value="{{ old('latitude') }}"
                           step="any"
                           required
                           class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('latitude') ? 'border-red-500' : 'border-gray-300' }}"
                           placeholder="Contoh: -7.608126">
                    @error('latitude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Longitude <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="longitude" 
                           name="longitude" 
                           value="{{ old('longitude') }}"
                           step="any"
                           required
                           class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('longitude') ? 'border-red-500' : 'border-gray-300' }}"
                           placeholder="Contoh: 110.203751">
                    @error('longitude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Helper for coordinates -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Tips untuk mendapatkan koordinat:</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Buka Google Maps dan cari lokasi tempat wisata</li>
                                <li>Klik kanan pada lokasi yang tepat</li>
                                <li>Koordinat akan muncul di bagian atas (latitude, longitude)</li>
                                <li>Copy dan paste ke form ini</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }}"
                          placeholder="Deskripsikan tempat ini, sejarahnya, dan mengapa penting untuk dipelajari...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Opsional - Deskripsi akan membantu siswa memahami konteks tempat ini</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('educator.places.index') }}" 
                   class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Tempat
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Tempat</h3>
        <div id="placePreview" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500">
            <i class="fas fa-eye text-2xl mb-2"></i>
            <p>Preview akan muncul setelah Anda mengisi form</p>
        </div>
    </div>
</div>

<script>
// Real-time preview
function updatePreview() {
    const name = document.getElementById('name').value;
    const location = document.getElementById('location').value;
    const era = document.getElementById('era').value;
    const latitude = document.getElementById('latitude').value;
    const longitude = document.getElementById('longitude').value;
    const description = document.getElementById('description').value;
    
    const preview = document.getElementById('placePreview');
    
    if (name || location || era) {
        const eraColors = {
            'prasejarah': 'green',
            'kerajaan': 'blue', 
            'penjajahan': 'red',
            'kemerdekaan': 'purple'
        };
        
        const eraColor = eraColors[era] || 'gray';
        
        preview.innerHTML = `
            <div class="text-left">
                <div class="flex justify-between items-start mb-3">
                    <h4 class="text-lg font-semibold text-gray-900">${name || 'Nama Tempat'}</h4>
                    ${era ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-${eraColor}-100 text-${eraColor}-800">${era.charAt(0).toUpperCase() + era.slice(1)}</span>` : ''}
                </div>
                
                <div class="space-y-2 text-sm text-gray-600">
                    ${location ? `<div class="flex items-center"><i class="fas fa-map-marker-alt mr-2 text-gray-400"></i><span>${location}</span></div>` : ''}
                    ${latitude && longitude ? `<div class="flex items-center"><i class="fas fa-globe mr-2 text-gray-400"></i><span>${latitude}, ${longitude}</span></div>` : ''}
                </div>
                
                ${description ? `<div class="mt-3 p-3 bg-gray-50 rounded text-sm text-gray-700">${description}</div>` : ''}
            </div>
        `;
    } else {
        preview.innerHTML = `
            <i class="fas fa-eye text-2xl mb-2"></i>
            <p>Preview akan muncul setelah Anda mengisi form</p>
        `;
    }
}

// Add event listeners
document.getElementById('name').addEventListener('input', updatePreview);
document.getElementById('location').addEventListener('input', updatePreview);
document.getElementById('era').addEventListener('change', updatePreview);
document.getElementById('latitude').addEventListener('input', updatePreview);
document.getElementById('longitude').addEventListener('input', updatePreview);
document.getElementById('description').addEventListener('input', updatePreview);
</script>
@endsection