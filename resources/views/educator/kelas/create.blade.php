@extends('layouts.educator')

@section('page-title', 'Buat Kelas Baru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('educator.classes') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Buat Kelas Baru</h1>
        </div>

        <form action="{{ route('educator.classes.store') }}" method="POST" class="max-w-md">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                       placeholder="Masukkan nama kelas"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-medium text-blue-900 mb-2">Tentang Token Kelas</h3>
                <p class="text-sm text-blue-700">
                    Token unik akan dibuat secara otomatis untuk kelas ini. Siswa akan menggunakan token ini untuk bergabung dengan kelas Anda.
                </p>
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Buat Kelas
                </button>
                <a href="{{ route('educator.classes') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection