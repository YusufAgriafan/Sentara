@extends('layouts.admin')

@section('page-title', 'Manajemen Sejarah')

@section('content')
<!-- Header Card -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-2">Konten Sejarah</h1>
                <p class="text-sm sm:text-base text-gray-600">Kelola konten sejarah Indonesia dengan struktur hierarkis</p>
            </div>
            <a href="{{ route('admin.history.create') }}" 
               class="bg-gradient-to-r from-primary to-secondary hover:from-primary-dark hover:to-secondary-dark text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:scale-105 flex items-center justify-center text-sm sm:text-base">
                <i class="fas fa-plus mr-2"></i>
                <span class="hidden sm:inline">Tambah Data Sejarah</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>
    </div>
    
    <div class="p-4 sm:p-6 lg:p-8">
        @if($histories->count() > 0)
            @foreach($histories as $category => $categoryData)
                <div class="mb-12">
                    <!-- Category Header -->
                    <div class="flex items-center mb-6">
                        <div class="h-1 w-8 bg-gradient-to-r from-primary to-secondary rounded-full mr-4"></div>
                        <h2 class="text-2xl font-bold text-primary">
                            {{ $category }}
                        </h2>
                        <div class="flex-1 h-px bg-gray-200 ml-4"></div>
                    </div>
                    
                    @foreach($categoryData as $subcategory => $items)
                        @if($subcategory)
                            <!-- Subcategory Section -->
                            <div class="mb-6 sm:mb-8 ml-3 sm:ml-6">
                                <div class="flex items-center mb-3 sm:mb-4">
                                    <i class="fas fa-chevron-right text-secondary mr-2 sm:mr-3"></i>
                                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800">
                                        {{ $subcategory }}
                                    </h3>
                                </div>
                                
                                <div class="ml-4 sm:ml-8 space-y-3">
                                    @foreach($items as $item)
                                        <div class="bg-gradient-to-r from-gray-50 to-white p-3 sm:p-4 rounded-lg border border-gray-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center flex-wrap gap-2">
                                                        <i class="fas fa-file-text text-primary"></i>
                                                        <span class="font-semibold text-gray-800 truncate">{{ $item->title }}</span>
                                                        @if($item->sub_subcategory)
                                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full whitespace-nowrap">{{ $item->sub_subcategory }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="flex flex-wrap items-center mt-2 text-xs sm:text-sm text-gray-500 gap-2 sm:gap-4">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-sort-numeric-up mr-1"></i>
                                                            <span>Urutan: {{ $item->order_index }}</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <i class="fas fa-{{ $item->is_active ? 'check-circle text-green-500' : 'times-circle text-red-500' }} mr-1"></i>
                                                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex flex-wrap sm:flex-nowrap gap-2">
                                                    <a href="{{ route('admin.history.show', $item) }}" 
                                                       class="bg-green-500 hover:bg-green-600 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center justify-center flex-1 sm:flex-initial">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        <span class="hidden sm:inline">Lihat</span>
                                                    </a>
                                                    <a href="{{ route('admin.history.edit', $item) }}" 
                                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center justify-center flex-1 sm:flex-initial">
                                                        <i class="fas fa-edit mr-1"></i>
                                                        <span class="hidden sm:inline">Edit</span>
                                                    </a>
                                                    <form action="{{ route('admin.history.destroy', $item) }}" method="POST" 
                                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="flex-1 sm:flex-initial">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="w-full bg-red-500 hover:bg-red-600 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center justify-center">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            <span class="hidden sm:inline">Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- Items tanpa subcategory --}}
                            <div class="space-y-3 ml-3 sm:ml-6">
                                @foreach($items as $item)
                                    <div class="bg-gradient-to-r from-gray-50 to-white p-3 sm:p-4 rounded-lg border border-gray-100 hover:shadow-md transition-all duration-200">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-text text-primary mr-3"></i>
                                                    <span class="font-semibold text-gray-800 truncate">{{ $item->title }}</span>
                                                </div>
                                                <div class="flex flex-wrap items-center mt-2 text-xs sm:text-sm text-gray-500 gap-2 sm:gap-4">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-sort-numeric-up mr-1"></i>
                                                        <span>Urutan: {{ $item->order_index }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-{{ $item->is_active ? 'check-circle text-green-500' : 'times-circle text-red-500' }} mr-1"></i>
                                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap sm:flex-nowrap gap-2">
                                                <a href="{{ route('admin.history.show', $item) }}" 
                                                   class="bg-green-500 hover:bg-green-600 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center justify-center flex-1 sm:flex-initial">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    <span class="hidden sm:inline">Lihat</span>
                                                </a>
                                                <a href="{{ route('admin.history.edit', $item) }}" 
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center justify-center flex-1 sm:flex-initial">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </a>
                                                <form action="{{ route('admin.history.destroy', $item) }}" method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="flex-1 sm:flex-initial">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="w-full bg-red-500 hover:bg-red-600 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center justify-center">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        <span class="hidden sm:inline">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mb-6">
                    <i class="fas fa-history text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-600 mb-4">Belum ada data sejarah</h3>
                <p class="text-gray-500 mb-8">Mulai menambahkan konten sejarah Indonesia untuk pembelajaran yang lebih interaktif</p>
                <a href="{{ route('admin.history.create') }}" 
                   class="bg-gradient-to-r from-primary to-secondary hover:from-primary-dark hover:to-secondary-dark text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:scale-105 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Data Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection