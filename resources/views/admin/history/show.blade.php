@extends('layouts.admin')

@section('page-title', 'Detail Sejarah')

@section('content')
<!-- Header Card -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
    <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-2">Detail Sejarah</h1>
                <p class="text-sm sm:text-base text-gray-600 truncate">{{ $history->title }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.history.edit', $history) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg flex items-center justify-center text-sm sm:text-base">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('admin.history.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg flex items-center justify-center text-sm sm:text-base">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Content Card -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Basic Information -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-info-circle text-primary mr-3"></i>
                Informasi Dasar
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 sm:p-6 rounded-xl border border-blue-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-heading text-blue-600 mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Judul</h4>
                    </div>
                    <p class="text-base sm:text-lg font-bold text-gray-900 break-words">{{ $history->title }}</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 sm:p-6 rounded-xl border border-green-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-{{ $history->is_active ? 'check-circle text-green-600' : 'times-circle text-red-600' }} mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Status</h4>
                    </div>
                    <span class="px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold {{ $history->is_active ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                        {{ $history->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 sm:p-6 rounded-xl border border-purple-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-sort-numeric-up text-purple-600 mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Urutan</h4>
                    </div>
                    <p class="text-base sm:text-lg font-bold text-gray-900">{{ $history->order_index }}</p>
                </div>
            </div>
        </div>

        <!-- Category Information -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-sitemap text-primary mr-3"></i>
                Kategorisasi
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 sm:p-6 rounded-xl border border-orange-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-folder text-orange-600 mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Kategori</h4>
                    </div>
                    <p class="text-base sm:text-lg font-semibold text-gray-900 break-words">{{ $history->category }}</p>
                </div>

                @if($history->subcategory)
                <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-4 sm:p-6 rounded-xl border border-teal-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-folder-open text-teal-600 mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Sub Kategori</h4>
                    </div>
                    <p class="text-base sm:text-lg font-semibold text-gray-900 break-words">{{ $history->subcategory }}</p>
                </div>
                @endif

                @if($history->sub_subcategory)
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-4 sm:p-6 rounded-xl border border-pink-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-file-alt text-pink-600 mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Sub Sub Kategori</h4>
                    </div>
                    <p class="text-base sm:text-lg font-semibold text-gray-900 break-words">{{ $history->sub_subcategory }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Content -->
        @if($history->content)
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-edit text-primary mr-3"></i>
                Konten
            </h3>
            
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 sm:p-6 lg:p-8 rounded-xl border border-gray-200">
                <div class="prose prose-sm sm:prose max-w-none text-gray-800 leading-relaxed">
                    {!! $history->content !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Timestamps -->
        <div class="pt-8 border-t border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-clock text-primary mr-3"></i>
                Riwayat Perubahan
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-4 sm:p-6 rounded-xl border border-indigo-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-plus-circle text-indigo-600 mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Dibuat</h4>
                    </div>
                    <p class="text-base sm:text-lg font-semibold text-gray-900">{{ $history->created_at->format('d M Y H:i') }}</p>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $history->created_at->diffForHumans() }}</p>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-4 sm:p-6 rounded-xl border border-amber-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-edit text-amber-600 mr-3 text-lg"></i>
                        <h4 class="text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wide">Diubah</h4>
                    </div>
                    <p class="text-base sm:text-lg font-semibold text-gray-900">{{ $history->updated_at->format('d M Y H:i') }}</p>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $history->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 sm:pt-8 mt-6 sm:mt-8 border-t border-gray-200">
            <form action="{{ route('admin.history.destroy', $history) }}" method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan!')" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg flex items-center justify-center text-sm sm:text-base">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.history.edit', $history) }}" 
               class="px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-primary to-secondary hover:from-primary-dark hover:to-secondary-dark text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-105 flex items-center justify-center text-sm sm:text-base">
                <i class="fas fa-edit mr-2"></i>
                Edit Data
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.prose table {
    border-collapse: collapse;
    width: 100%;
}

.prose table th,
.prose table td {
    border: 1px solid #e5e7eb;
    padding: 8px 12px;
}

.prose table th {
    background-color: #f9fafb;
    font-weight: 600;
}
</style>
@endpush