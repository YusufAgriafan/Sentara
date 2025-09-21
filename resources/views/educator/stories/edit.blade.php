@extends('layouts.educator')

@section('page-title', 'Edit Cerita')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Cerita</h1>
                <p class="text-gray-600 mt-1">Ubah cerita untuk tempat wisata sejarah</p>
            </div>
            <a href="{{ route('educator.stories.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('educator.stories.update', $story) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Place Selection -->
            <div>
                <label for="historical_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Tempat <span class="text-red-500">*</span>
                </label>
                <select id="historical_id" 
                        name="historical_id" 
                        required
                        class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('historical_id') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">Pilih Tempat untuk Cerita Ini</option>
                    @foreach($places as $place)
                        <option value="{{ $place->id }}" 
                                data-era="{{ $place->era }}"
                                data-location="{{ $place->location }}"
                                {{ old('historical_id', $story->historical_id) == $place->id ? 'selected' : '' }}>
                            {{ $place->name }} - {{ $place->location }} ({{ ucfirst($place->era) }})
                        </option>
                    @endforeach
                </select>
                @error('historical_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Cerita akan dikaitkan dengan tempat yang dipilih</p>
            </div>

            <!-- Place Info Display -->
            <div id="placeInfo" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-blue-500 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800" id="placeInfoName"></h4>
                        <p class="text-sm text-blue-600" id="placeInfoDetails"></p>
                    </div>
                </div>
            </div>

            <!-- Story Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Cerita <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $story->title) }}"
                       required
                       class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }}"
                       placeholder="Contoh: Legenda Roro Jonggrang dan Candi Prambanan">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Story Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Isi Cerita <span class="text-red-500">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="12"
                          required
                          class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('content') ? 'border-red-500' : 'border-gray-300' }}"
                          placeholder="Tulis cerita yang menarik dan edukatif. Ceritakan sejarah, legenda, atau fakta menarik tentang tempat ini...">{{ old('content', $story->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="flex justify-between mt-1">
                    <p class="text-sm text-gray-500">Cerita yang baik biasanya 200-1000 kata</p>
                    <p class="text-sm text-gray-500" id="wordCount">0 kata</p>
                </div>
            </div>

            <!-- Writing Tips -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-green-400 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Tips Menulis Cerita yang Menarik:</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Mulai dengan konteks sejarah yang jelas</li>
                                <li>Gunakan bahasa yang mudah dipahami siswa</li>
                                <li>Sertakan fakta menarik atau legenda lokal</li>
                                <li>Hubungkan dengan pelajaran sejarah yang relevan</li>
                                <li>Akhiri dengan pesan moral atau pembelajaran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Illustration URL -->
            <div>
                <label for="illustration" class="block text-sm font-medium text-gray-700 mb-2">
                    URL Ilustrasi
                </label>
                <input type="url" 
                       id="illustration" 
                       name="illustration" 
                       value="{{ old('illustration', $story->illustration) }}"
                       class="w-full rounded-lg focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('illustration') ? 'border-red-500' : 'border-gray-300' }}"
                       placeholder="https://example.com/image.jpg">
                @error('illustration')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Opsional - URL gambar yang relevan dengan cerita</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('educator.stories.index') }}" 
                   class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Cerita
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Cerita</h3>
        <div id="storyPreview" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500">
            <i class="fas fa-eye text-2xl mb-2"></i>
            <p>Preview akan muncul setelah Anda mengisi form</p>
        </div>
    </div>
</div>

<script>
// Word counter
function updateWordCount() {
    const content = document.getElementById('content').value;
    const words = content.trim() === '' ? 0 : content.trim().split(/\s+/).length;
    document.getElementById('wordCount').textContent = words + ' kata';
}

// Place info display
function updatePlaceInfo() {
    const select = document.getElementById('historical_id');
    const selectedOption = select.options[select.selectedIndex];
    const placeInfo = document.getElementById('placeInfo');
    
    if (selectedOption.value) {
        const era = selectedOption.dataset.era;
        const location = selectedOption.dataset.location;
        
        document.getElementById('placeInfoName').textContent = selectedOption.text.split(' - ')[0];
        document.getElementById('placeInfoDetails').textContent = `${location} • Era ${era.charAt(0).toUpperCase() + era.slice(1)}`;
        placeInfo.classList.remove('hidden');
    } else {
        placeInfo.classList.add('hidden');
    }
}

// Real-time preview
function updatePreview() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const select = document.getElementById('historical_id');
    const selectedOption = select.options[select.selectedIndex];
    const illustration = document.getElementById('illustration').value;
    
    const preview = document.getElementById('storyPreview');
    
    if (title || content || selectedOption.value) {
        let placeName = '';
        let era = '';
        
        if (selectedOption.value) {
            placeName = selectedOption.text.split(' - ')[0];
            era = selectedOption.dataset.era;
        }
        
        const eraColors = {
            'prasejarah': 'green',
            'kerajaan': 'blue', 
            'penjajahan': 'red',
            'kemerdekaan': 'purple'
        };
        
        const eraColor = eraColors[era] || 'gray';
        
        preview.innerHTML = `
            <div class="text-left">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-900">${title || 'Judul Cerita'}</h3>
                    ${era ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-${eraColor}-100 text-${eraColor}-800">${era.charAt(0).toUpperCase() + era.slice(1)}</span>` : ''}
                </div>
                
                ${placeName ? `<div class="flex items-center text-sm text-gray-600 mb-4"><i class="fas fa-map-marker-alt mr-2"></i>${placeName}</div>` : ''}
                
                ${illustration ? `<div class="mb-4"><img src="${illustration}" alt="Ilustrasi" class="w-full h-48 object-cover rounded-lg" onerror="this.style.display='none'"></div>` : ''}
                
                <div class="prose max-w-none">
                    ${content ? `<p class="text-gray-700 leading-relaxed">${content.substring(0, 300)}${content.length > 300 ? '...' : ''}</p>` : '<p class="text-gray-500 italic">Isi cerita akan muncul di sini</p>'}
                </div>
            </div>
        `;
    } else {
        preview.innerHTML = `
            <i class="fas fa-eye text-2xl mb-2"></i>
            <p>Preview akan muncul setelah Anda mengisi form</p>
        `;
    }
}

// Event listeners
document.getElementById('content').addEventListener('input', function() {
    updateWordCount();
    updatePreview();
});

document.getElementById('historical_id').addEventListener('change', function() {
    updatePlaceInfo();
    updatePreview();
});

document.getElementById('title').addEventListener('input', updatePreview);
document.getElementById('illustration').addEventListener('input', updatePreview);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateWordCount();
    updatePlaceInfo();
    updatePreview();
});
</script>
@endsection