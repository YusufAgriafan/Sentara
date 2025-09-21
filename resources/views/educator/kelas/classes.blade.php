@php
    /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClassModel> $classes */
@endphp
@extends('layouts.educator')

@section('page-title', 'Kelas Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Kelas Saya</h1>
            <a href="{{ route('educator.classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Buat Kelas Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @forelse($classes as $class)
            @if($loop->first)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @endif
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $class->name }}</h3>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Token Kelas:</p>
                            <div class="bg-gray-100 rounded p-2 text-center">
                                <span class="font-mono text-lg font-bold text-blue-600">{{ $class->token }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                            <span>{{ $class->classLists->count() }} siswa</span>
                            <span>Dibuat: {{ $class->created_at->format('j M Y') }}</span>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('educator.classes.content.index', $class) }}" 
                                   class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm text-center">
                                    Kelola Konten
                                </a>
                                <a href="{{ route('educator.classes.edit', $class) }}" 
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm text-center">
                                    Edit Kelas
                                </a>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('educator.classes.regenerate-token', $class) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm"
                                            onclick="return confirm('Buat token baru? Siswa akan membutuhkan token baru untuk bergabung.')">
                                        Token Baru
                                    </button>
                                </form>
                            </div>
                            <form action="{{ route('educator.classes.destroy', $class) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Tindakan ini tidak dapat dibatalkan.')">
                                    Hapus Kelas
                                </button>
                            </form>
                        </div>
                    </div>
            @if($loop->last)
            </div>
            @endif
        @empty
            <div class="text-center py-8">
                <div class="text-gray-500 mb-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada kelas</h3>
                <p class="text-gray-500 mb-4">Mulai dengan membuat kelas pertama Anda</p>
                <a href="{{ route('educator.classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-block">
                    Buat Kelas Pertama
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection