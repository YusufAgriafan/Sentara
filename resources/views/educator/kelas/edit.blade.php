@extends('layouts.educator')

@section('page-title', 'Edit Kelas')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                            <div class="bg-white border rounded-md p-3">
                                <span class="text-gray-900">{{ $class->created_at->format('j F Y \\p\\a\\d\\a H:i') }}</span>
                            </div>
                        </div>on('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('educator.classes') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kelas</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Edit Form -->
            <div>
                <form action="{{ route('educator.classes.update', $class) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kelas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $class->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan nama kelas"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Perbarui Kelas
                        </button>
                        <a href="{{ route('educator.classes') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Class Info -->
            <div>
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kelas</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Token Saat Ini</label>
                            <div class="bg-white border rounded-md p-3">
                                <span class="font-mono text-lg font-bold text-blue-600">{{ $class->token }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Siswa Terdaftar</label>
                            <div class="bg-white border rounded-md p-3">
                                <span class="text-gray-900">{{ $class->classLists->count() }} siswa</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                            <div class="bg-white border rounded-md p-3">
                                <span class="text-gray-900">{{ $class->created_at->format('d F Y \p\u\k\u\l H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <form action="{{ route('educator.classes.regenerate-token', $class) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    onclick="return confirm('Buat token baru? Siswa akan membutuhkan token baru untuk bergabung.')">
                                Buat Token Baru
                            </button>
                        </form>
                        
                        <form action="{{ route('educator.classes.destroy', $class) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Tindakan ini tidak dapat dibatalkan.')">
                                Hapus Kelas
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection