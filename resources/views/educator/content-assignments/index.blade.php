@extends('layouts.educator')

@section('page-title', 'Pembagian Materi Kelas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pembagian Materi Kelas</h1>
                <p class="text-gray-600 mt-1">Ringkasan distribusi materi pembelajaran ke setiap kelas</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('educator.content.library') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Perpustakaan
                </a>
                <button onclick="openBulkAssignModal()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-layer-group mr-2"></i>Bagikan ke Banyak Kelas
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-chalkboard text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kelas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ count($classes ?? []) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-map-marker-alt text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tempat</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ count($places ?? []) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-book text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Cerita</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ count($stories ?? []) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-link text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pembagian Materi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $assignments ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Distribution Matrix -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Tabel Pembagian Materi</h2>
        
        <!-- Legend -->
        <div class="flex flex-wrap gap-4 mb-6 text-sm">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-200 rounded mr-2"></div>
                <span class="text-gray-600">Tempat Terpasang</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-blue-200 rounded mr-2"></div>
                <span class="text-gray-600">Cerita Tersedia</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-gray-100 border border-gray-300 rounded mr-2"></div>
                <span class="text-gray-600">Belum Dipasang</span>
            </div>
        </div>

        <!-- Matrix Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left p-3 font-medium text-gray-900">Kelas</th>
                        <th class="text-center p-3 font-medium text-gray-900">Grade</th>
                        <th class="text-center p-3 font-medium text-gray-900">Siswa</th>
                        <th class="text-center p-3 font-medium text-gray-900">Tempat</th>
                        <th class="text-center p-3 font-medium text-gray-900">Cerita</th>
                        <th class="text-center p-3 font-medium text-gray-900">Aktivitas</th>
                        <th class="text-center p-3 font-medium text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="p-3">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $class->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $class->subject ?? 'Tidak ada mata pelajaran' }}</div>
                                </div>
                            </td>
                            <td class="p-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $class->grade ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="p-3 text-center text-gray-600">{{ $class->classLists->count() }}</td>
                            <td class="p-3 text-center">
                                <div class="flex justify-center">
                                    @php
                                        $placesCount = $class->places->count();
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $placesCount > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $placesCount }} tempat
                                    </span>
                                </div>
                            </td>
                            <td class="p-3 text-center">
                                <div class="flex justify-center">
                                    @php
                                        $storiesCount = $class->stories->count();
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $storiesCount > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $storiesCount }} cerita
                                    </span>
                                </div>
                            </td>
                            <td class="p-3 text-center">
                                <div class="flex justify-center">
                                    @php
                                        $discussionsCount = $class->discussions->count();
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $discussionsCount > 0 ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $discussionsCount }} diskusi
                                    </span>
                                </div>
                            </td>
                            <td class="p-3 text-center">
                                <div class="flex justify-center space-x-1">
                                    <button onclick="viewClassDetails('{{ $class->id }}', '{{ addslashes($class->name) }}')"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Lihat Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    <button onclick="assignContentToClass('{{ $class->id }}', '{{ addslashes($class->name) }}')"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                            title="Assign Konten">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                    <a href="{{ route('educator.classes.edit', $class) }}"
                                       class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                       title="Kelola Kelas">
                                        <i class="fas fa-cog text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p>Belum ada kelas yang tersedia.</p>
                                <a href="{{ route('educator.classes.create') }}" class="inline-flex items-center mt-2 text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus mr-1"></i>Buat Kelas Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
            </table>
        </div>
    </div>

    <!-- Content Usage Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Most Used Places -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tempat Paling Banyak Digunakan</h3>
            <div class="space-y-3">
                @foreach($places->sortByDesc(function($place) { return $place->classes->count(); })->take(5) as $place)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $place->name }}</div>
                            <div class="text-sm text-gray-500">{{ $place->location }} • {{ ucfirst($place->era) }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">{{ $place->classes->count() }} kelas</div>
                            <div class="text-sm text-gray-500">{{ $place->stories->count() }} cerita</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Assignment Gaps -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kelas Perlu Perhatian</h3>
            <div class="space-y-3">
                @php
                    $classesNeedingAttention = $classes->filter(function($class) {
                        return $class->places->count() == 0 || $class->stories->count() == 0;
                    });
                @endphp
                
                @forelse($classesNeedingAttention->take(5) as $class)
                    <div class="flex items-center justify-between p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $class->name }}</div>
                            <div class="text-sm text-gray-500">{{ $class->grade ?? 'N/A' }} • {{ $class->classLists->count() }} siswa</div>
                        </div>
                        <div class="text-right">
                            @if($class->places->count() == 0)
                                <div class="text-sm text-red-600">Belum ada tempat</div>
                            @endif
                            @if($class->stories->count() == 0)
                                <div class="text-sm text-red-600">Belum ada cerita</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-center">
                        <i class="fas fa-check-circle text-green-500 text-lg mb-2"></i>
                        <p class="text-green-700">Semua kelas sudah memiliki konten!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Class Details Modal -->
<div id="classDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Detail Materi Kelas</h3>
                <button onclick="closeClassDetailsModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="classDetailsContent">
                <p class="text-gray-600">Loading...</p>
            </div>
        </div>
    </div>
</div>

<!-- Assign Content Modal -->
<div id="assignContentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-lg w-full p-6 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Bagikan Materi ke Kelas</h3>
                <button onclick="closeAssignContentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="assignContentContent">
                <p class="text-gray-600">Loading...</p>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Assignment Modal -->
<div id="bulkAssignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full p-6 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Bagikan Materi ke Banyak Kelas</h3>
                <button onclick="closeBulkAssignModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="bulkAssignContent">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Pilih Kelas</h4>
                        <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-300 rounded-lg p-3">
                            @forelse($classes as $class)
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                    <input type="checkbox" name="bulk_classes[]" value="{{ $class->id }}" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $class->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $class->grade ?? 'N/A' }} • {{ $class->classLists->count() }} siswa</div>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500 text-center py-4">Tidak ada kelas tersedia</p>
                            @endforelse
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Pilih Materi</h4>
                        <div class="space-y-4">
                            <div>
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Tempat</h5>
                                <div class="space-y-1 max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-2">
                                    @foreach($places as $place)
                                        <label class="flex items-center p-1 hover:bg-gray-50 rounded cursor-pointer">
                                            <input type="checkbox" name="bulk_places[]" value="{{ $place->id }}" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                            <span class="ml-2 text-sm text-gray-900">{{ $place->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div>
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Cerita</h5>
                                <div class="space-y-1 max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-2">
                                    @foreach($stories as $story)
                                        <label class="flex items-center p-1 hover:bg-gray-50 rounded cursor-pointer">
                                            <input type="checkbox" name="bulk_stories[]" value="{{ $story->id }}" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-900">{{ $story->title }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                    <button onclick="closeBulkAssignModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button onclick="executeBulkAssignment()" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        <i class="fas fa-layer-group mr-2"></i>Bagikan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Class details modal
function viewClassDetails(classId, className) {
    document.getElementById('classDetailsModal').classList.remove('hidden');
    document.getElementById('classDetailsContent').innerHTML = '<p class="text-gray-600">Loading...</p>';
    
    fetch(`/educator/content/class/${classId}/details`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                let content = `
                    <div class="space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-medium text-blue-900">${className}</h4>
                            <p class="text-sm text-blue-700">${data.class.grade || 'N/A'} • ${data.class.students_count} siswa • ${data.class.subject || 'N/A'}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h5 class="font-medium text-gray-900 mb-2">Tempat (${data.places.length})</h5>
                                <div class="space-y-2 max-h-32 overflow-y-auto">
                `;
                
                if (data.places.length > 0) {
                    data.places.forEach(place => {
                        content += `
                            <div class="p-2 bg-green-50 border border-green-200 rounded text-sm">
                                <div class="font-medium text-green-900">${place.name}</div>
                                <div class="text-green-700">${place.location} • ${place.era}</div>
                            </div>
                        `;
                    });
                } else {
                    content += '<p class="text-gray-500 text-center py-4">Belum ada tempat yang di-assign</p>';
                }
                
                content += `
                                </div>
                            </div>
                            
                            <div>
                                <h5 class="font-medium text-gray-900 mb-2">Cerita (${data.stories.length})</h5>
                                <div class="space-y-2 max-h-32 overflow-y-auto">
                `;
                
                if (data.stories.length > 0) {
                    data.stories.forEach(story => {
                        content += `
                            <div class="p-2 bg-blue-50 border border-blue-200 rounded text-sm">
                                <div class="font-medium text-blue-900">${story.title}</div>
                                <div class="text-blue-700">${story.place.name}</div>
                            </div>
                        `;
                    });
                } else {
                    content += '<p class="text-gray-500 text-center py-4">Belum ada cerita yang di-assign</p>';
                }
                
                content += `
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                document.getElementById('classDetailsContent').innerHTML = content;
            } else {
                document.getElementById('classDetailsContent').innerHTML = '<p class="text-red-600">Error: ' + (data.message || 'Unknown error') + '</p>';
            }
        })
        .catch(error => {
            console.error('Error loading class details:', error);
            document.getElementById('classDetailsContent').innerHTML = '<p class="text-red-600">Gagal memuat data. Silakan coba lagi.</p>';
        });
}

function closeClassDetailsModal() {
    document.getElementById('classDetailsModal').classList.add('hidden');
}

// Assign content modal
function assignContentToClass(classId, className) {
    document.getElementById('assignContentModal').classList.remove('hidden');
    document.getElementById('assignContentContent').innerHTML = '<p class="text-gray-600">Loading...</p>';
    
    fetch(`/educator/content/class/${classId}/available`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let content = `
                    <form id="assignContentForm">
                        <input type="hidden" name="class_id" value="${classId}">
                        <div class="space-y-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-medium text-blue-900">Bagikan Materi ke: ${className}</h4>
                            </div>
                            
                            <div>
                                <h5 class="font-medium text-gray-900 mb-2">Tempat Tersedia (${data.available_places.length})</h5>
                                <div class="space-y-2 max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-3">
                `;
                
                if (data.available_places.length > 0) {
                    data.available_places.forEach(place => {
                        content += `
                            <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <input type="checkbox" name="place_ids[]" value="${place.id}" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">${place.name}</div>
                                    <div class="text-sm text-gray-500">${place.location} • ${place.era}</div>
                                </div>
                            </label>
                        `;
                    });
                } else {
                    content += '<p class="text-gray-500 text-center py-4">Semua tempat sudah dibagikan</p>';
                }
                
                content += `
                                </div>
                            </div>
                            
                            <div>
                                <h5 class="font-medium text-gray-900 mb-2">Cerita Tersedia (${data.available_stories.length})</h5>
                                <div class="space-y-2 max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-3">
                `;
                
                if (data.available_stories.length > 0) {
                    data.available_stories.forEach(story => {
                        content += `
                            <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <input type="checkbox" name="story_ids[]" value="${story.id}" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">${story.title}</div>
                                    <div class="text-sm text-gray-500">${story.place_name}</div>
                                </div>
                            </label>
                        `;
                    });
                } else {
                    content += '<p class="text-gray-500 text-center py-4">Semua cerita sudah dibagikan</p>';
                }
                
                content += `
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                            <button type="button" onclick="closeAssignContentModal()" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Batal
                            </button>
                            <button type="button" onclick="executeAssignment()" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i>Bagikan Sekarang
                            </button>
                        </div>
                    </form>
                `;
                
                document.getElementById('assignContentContent').innerHTML = content;
            } else {
            document.getElementById('assignContentContent').innerHTML = '<p class="text-red-600">Gagal memuat materi yang tersedia</p>';
            }
        })
        .catch(error => {
            document.getElementById('assignContentContent').innerHTML = '<p class="text-red-600">Gagal memuat data</p>';
        });
}

function closeAssignContentModal() {
    document.getElementById('assignContentModal').classList.add('hidden');
}

// Bulk assignment modal
function openBulkAssignModal() {
    document.getElementById('bulkAssignModal').classList.remove('hidden');
}

function closeBulkAssignModal() {
    document.getElementById('bulkAssignModal').classList.add('hidden');
}

function executeBulkAssignment() {
    const classes = Array.from(document.querySelectorAll('input[name="bulk_classes[]"]:checked')).map(cb => cb.value);
    const places = Array.from(document.querySelectorAll('input[name="bulk_places[]"]:checked')).map(cb => cb.value);
    const stories = Array.from(document.querySelectorAll('input[name="bulk_stories[]"]:checked')).map(cb => cb.value);
    
    if (classes.length === 0) {
        alert('Pilih minimal satu kelas');
        return;
    }
    
    if (places.length === 0 && stories.length === 0) {
        alert('Pilih minimal satu materi untuk dibagikan');
        return;
    }
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    button.disabled = true;
    
    fetch('/educator/content/bulk-assign', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            classes: classes,
            places: places,
            stories: stories
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeBulkAssignModal();
            
            // Show success message
            const successDiv = document.createElement('div');
            successDiv.className = 'mb-6 bg-green-50 border-l-4 border-green-400 text-green-800 px-4 py-3 rounded-r-lg shadow-sm';
            successDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    ${data.message}
                </div>
            `;
            
            // Insert success message at top of content
            const contentDiv = document.querySelector('main > div');
            contentDiv.insertBefore(successDiv, contentDiv.firstChild);
            
            // Reload page after short delay
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            alert('Error: ' + (data.message || 'Unknown error occurred'));
        }
    })
    .catch(error => {
        console.error('Error executing bulk assignment:', error);
        alert('Error executing bulk assignment. Please try again.');
    })
    .finally(() => {
        // Restore button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Execute individual assignment
function executeAssignment() {
    const form = document.getElementById('assignContentForm');
    const formData = new FormData(form);
    const classId = formData.get('class_id');
    const placeIds = formData.getAll('place_ids[]');
    const storyIds = formData.getAll('story_ids[]');
    
    if (placeIds.length === 0 && storyIds.length === 0) {
        alert('Pilih minimal satu materi untuk dibagikan');
        return;
    }
    
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    button.disabled = true;
    
    let assignmentPromises = [];
    
    // Assign places if any selected
    if (placeIds.length > 0) {
        assignmentPromises.push(
            fetch('/educator/content/assign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    class_id: classId,
                    content_type: 'places',
                    content_ids: placeIds
                })
            })
        );
    }
    
    // Assign stories if any selected
    if (storyIds.length > 0) {
        assignmentPromises.push(
            fetch('/educator/content/assign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    class_id: classId,
                    content_type: 'stories',
                    content_ids: storyIds
                })
            })
        );
    }
    
    // Execute all assignments
    Promise.all(assignmentPromises)
        .then(responses => Promise.all(responses.map(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })))
        .then(results => {
            const hasError = results.some(result => !result.success);
            
            if (hasError) {
                const errorMessages = results.filter(result => !result.success).map(result => result.message);
                alert('Some assignments failed: ' + errorMessages.join(', '));
            } else {
                closeAssignContentModal();
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'mb-6 bg-green-50 border-l-4 border-green-400 text-green-800 px-4 py-3 rounded-r-lg shadow-sm';
                successDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Konten berhasil di-assign ke kelas
                    </div>
                `;
                
                // Insert success message at top of content
                const contentDiv = document.querySelector('main > div');
                contentDiv.insertBefore(successDiv, contentDiv.firstChild);
                
                // Reload page after short delay
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error executing assignment:', error);
            alert('Error executing assignment. Please try again.');
        })
        .finally(() => {
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
        });
}

// Close modals on outside click
document.getElementById('classDetailsModal').addEventListener('click', function(e) {
    if (e.target === this) closeClassDetailsModal();
});

document.getElementById('assignContentModal').addEventListener('click', function(e) {
    if (e.target === this) closeAssignContentModal();
});

document.getElementById('bulkAssignModal').addEventListener('click', function(e) {
    if (e.target === this) closeBulkAssignModal();
});
</script>
@endsection