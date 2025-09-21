@extends('layouts.educator')

@section('page-title', 'Buat Diskusi Baru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Buat Diskusi Baru</h1>
                <p class="text-gray-600 mt-1">Buat topik diskusi untuk melibatkan siswa dalam pembelajaran</p>
            </div>
            <a href="{{ route('educator.discussions.index') }}" 
               class="text-gray-600 hover:text-gray-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('educator.discussions.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Pilih Kelas -->
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="class_id" id="class_id" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('class_id') ? 'border-red-500' : 'border-gray-300' }}">
                        <option value="">-- Pilih Kelas --</option>
                        @if(isset($classes) && (is_array($classes) || $classes instanceof \Illuminate\Support\Collection))
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled>Data kelas tidak tersedia</option>
                        @endif
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama/Topik Diskusi -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Topik Diskusi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                           placeholder="Masukkan topik diskusi yang menarik">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pesan Diskusi -->
                <div>
                    <label for="class_discussion_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi/Pertanyaan Diskusi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="class_discussion_message" 
                              id="class_discussion_message" 
                              rows="6"
                              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('class_discussion_message') ? 'border-red-500' : 'border-gray-300' }}"
                              placeholder="Tulis pertanyaan atau deskripsi diskusi yang akan memicu partisipasi aktif siswa...">{{ old('class_discussion_message') }}</textarea>
                    @error('class_discussion_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Tips: Buat pertanyaan yang mendorong siswa untuk berpikir kritis dan berbagi pengalaman
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('educator.discussions.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Buat Diskusi
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">
            <i class="fas fa-lightbulb mr-2"></i>Tips Membuat Diskusi Efektif
        </h3>
        <ul class="space-y-2 text-blue-800">
            <li class="flex items-start">
                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                Gunakan pertanyaan terbuka yang mendorong pemikiran kritis
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                Hubungkan topik dengan pengalaman sehari-hari siswa
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                Berikan konteks yang jelas dan mudah dipahami
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                Dorong siswa untuk memberikan contoh konkret
            </li>
        </ul>
    </div>
</div>
@endsection