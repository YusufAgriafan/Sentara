@extends('layouts.educator')

@section('page-title', 'Detail Cerita')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $story->title }}</h1>
                    @if($story->is_published)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Published
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>Draft
                        </span>
                    @endif
                </div>
                
                <div class="flex items-center text-gray-600 space-x-4">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $story->place->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>{{ $story->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        <span>{{ $story->classes->count() }} kelas terpasang</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <a href="{{ route('educator.stories.edit', $story) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('educator.stories.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Story Content -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Isi Cerita</h2>
                </div>
                
                <div class="p-6">
                    @if($story->illustration)
                        <div class="mb-6">
                            <img src="{{ $story->illustration }}" 
                                 alt="Ilustrasi {{ $story->title }}" 
                                 class="w-full h-64 object-cover rounded-lg shadow-sm"
                                 onerror="this.style.display='none'">
                        </div>
                    @endif
                    
                    <div class="prose max-w-none">
                        <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $story->content }}</div>
                    </div>
                    
                    <!-- Story Stats -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Jumlah kata:</span>
                                <span>{{ str_word_count(strip_tags($story->content)) }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Jumlah karakter:</span>
                                <span>{{ strlen($story->content) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Classes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">Kelas yang Terpasang</h2>
                        <button onclick="openAssignModal('{{ $story->id }}', '{{ $story->title }}')"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>Atur Kelas
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($story->classes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($story->classes as $class)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $class->name }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Kelas {{ $class->grade }} • {{ $class->subject }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $class->classLists->count() }} siswa
                                            </p>
                                        </div>
                                        <button onclick="unassignFromClass('{{ $story->id }}', '{{ $class->id }}')"
                                                class="text-red-600 hover:text-red-800 p-1"
                                                title="Hapus dari kelas">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                                <i class="fas fa-chalkboard text-3xl"></i>
                            </div>
                            <h3 class="text-sm font-medium text-gray-900 mb-1">Belum ada kelas terpasang</h3>
                            <p class="text-sm text-gray-500 mb-4">Cerita ini belum dipasang ke kelas manapun.</p>
                            <button onclick="openAssignModal('{{ $story->id }}', '{{ $story->title }}')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Pasang ke Kelas
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Place Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Tempat</h2>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">{{ $story->place->name }}</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    <span>{{ $story->place->location }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                               bg-{{ $story->place->era === 'prasejarah' ? 'green' : ($story->place->era === 'kerajaan' ? 'blue' : ($story->place->era === 'penjajahan' ? 'red' : 'purple')) }}-100 
                                               text-{{ $story->place->era === 'prasejarah' ? 'green' : ($story->place->era === 'kerajaan' ? 'blue' : ($story->place->era === 'penjajahan' ? 'red' : 'purple')) }}-800">
                                        Era {{ ucfirst($story->place->era) }}
                                    </span>
                                </div>
                                @if($story->place->coordinate)
                                    <div class="flex items-center">
                                        <i class="fas fa-globe mr-2 text-gray-400"></i>
                                        <span>{{ $story->place->coordinate->latitude }}, {{ $story->place->coordinate->longitude }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($story->place->description)
                            <div class="pt-4 border-t border-gray-200">
                                <h4 class="font-medium text-gray-900 mb-2">Deskripsi Tempat</h4>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $story->place->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Story Metadata -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Cerita</h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Status:</span>
                        <span class="text-sm text-gray-900">
                            @if($story->is_published)
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Published</span>
                            @else
                                <span class="text-yellow-600"><i class="fas fa-clock mr-1"></i>Draft</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Dibuat:</span>
                        <span class="text-sm text-gray-900">{{ $story->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Diperbarui:</span>
                        <span class="text-sm text-gray-900">{{ $story->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Kelas terpasang:</span>
                        <span class="text-sm text-gray-900">{{ $story->classes->count() }} kelas</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat</h2>
                </div>
                
                <div class="p-6 space-y-3">
                    <a href="{{ route('educator.stories.edit', $story) }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                        <i class="fas fa-edit mr-2"></i>Edit Cerita
                    </a>
                    
                    <button onclick="duplicateStory('{{ $story->id }}')"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-copy mr-2"></i>Duplikasi Cerita
                    </button>
                    
                    <button onclick="togglePublishStatus('{{ $story->id }}', {{ $story->is_published ? 'false' : 'true' }})"
                            class="w-full bg-{{ $story->is_published ? 'yellow' : 'green' }}-600 hover:bg-{{ $story->is_published ? 'yellow' : 'green' }}-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-{{ $story->is_published ? 'eye-slash' : 'eye' }} mr-2"></i>
                        {{ $story->is_published ? 'Ubah ke Draft' : 'Publish Cerita' }}
                    </button>
                    
                    <button onclick="deleteStory('{{ $story->id }}', '{{ $story->title }}')"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i>Hapus Cerita
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal placeholders and JavaScript functions can be added here -->
<script>
function openAssignModal(storyId, storyTitle) {
    // Placeholder for assign modal functionality
    alert('Fitur assign kelas akan segera hadir untuk cerita: ' + storyTitle);
}

function unassignFromClass(storyId, classId) {
    if (confirm('Apakah Anda yakin ingin menghapus cerita dari kelas ini?')) {
        // Placeholder for unassign functionality
        alert('Fitur unassign akan segera hadir');
    }
}

function duplicateStory(storyId) {
    if (confirm('Apakah Anda yakin ingin menduplikasi cerita ini?')) {
        // Placeholder for duplicate functionality
        alert('Fitur duplikasi akan segera hadir');
    }
}

function togglePublishStatus(storyId, newStatus) {
    const action = newStatus === 'true' ? 'publish' : 'unpublish';
    if (confirm(`Apakah Anda yakin ingin ${action} cerita ini?`)) {
        // Placeholder for toggle publish functionality
        alert('Fitur toggle publish akan segera hadir');
    }
}

function deleteStory(storyId, storyTitle) {
    if (confirm(`Apakah Anda yakin ingin menghapus cerita "${storyTitle}"? Tindakan ini tidak dapat dibatalkan.`)) {
        // Placeholder for delete functionality
        alert('Fitur hapus akan segera hadir');
    }
}
</script>
@endsection