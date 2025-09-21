@extends('layouts.educator')

@section('page-title', 'Edit Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Diskusi</h1>
                <p class="text-gray-600 mt-1">Perbarui topik diskusi dan deskripsi</p>
            </div>
            <a href="{{ route('educator.discussions.show', $discussion) }}" 
               class="text-gray-600 hover:text-gray-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('educator.discussions.update', $discussion) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                                <option value="{{ $class->id }}" {{ (old('class_id', $discussion->class_id) == $class->id) ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
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
                           value="{{ old('name', $discussion->name) }}"
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
                              placeholder="Tulis pertanyaan atau deskripsi diskusi yang akan memicu partisipasi aktif siswa...">{{ old('class_discussion_message', $discussion->class_discussion_message) }}</textarea>
                    @error('class_discussion_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Tips: Buat pertanyaan yang mendorong siswa untuk berpikir kritis dan berbagi pengalaman
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('educator.discussions.show', $discussion) }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Warning Section -->
    <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Mengubah topik atau deskripsi diskusi akan mempengaruhi semua pesan yang terkait dengan diskusi ini. Pastikan perubahan yang Anda buat tidak mengganggu konteks diskusi yang sedang berlangsung.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Discussion Preview -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-eye mr-2"></i>Preview Diskusi Saat Ini
        </h3>
        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <h4 class="font-medium text-gray-900 mb-2">{{ $discussion->name }}</h4>
            <p class="text-gray-700 leading-relaxed mb-3">{{ $discussion->class_discussion_message }}</p>
            <div class="flex items-center text-sm text-gray-500">
                <span>Kelas: {{ $discussion->class->name ?? 'N/A' }}</span>
                <span class="mx-3">•</span>
                <span>Dibuat: {{ $discussion->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection