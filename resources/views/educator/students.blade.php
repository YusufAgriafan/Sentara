@extends('layouts.educator')

@section('page-title', 'My Students')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Siswa Saya</h1>
                <p class="text-gray-600 mt-1">Kelola dan pantau siswa di semua kelas Anda</p>
            </div>
            <div class="flex space-x-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors">
                    <i class="fas fa-download mr-2"></i>Export Data
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('educator.students') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Siswa</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama atau email siswa..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Class Filter -->
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select id="class_id" 
                            name="class_id" 
                            class="w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kelas</option>
                        @if(isset($classes) && (is_array($classes) || $classes instanceof \Illuminate\Support\Collection))
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}{{ isset($class->grade) ? ' (' . $class->grade . ')' : '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('educator.students') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-refresh mr-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $students->total() }}</p>
                    <p class="text-gray-600 text-sm">Total Siswa</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chalkboard text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ is_object($classes) && method_exists($classes, 'count') ? $classes->count() : (is_array($classes) ? count($classes) : 0) }}</p>
                    <p class="text-gray-600 text-sm">Kelas Aktif</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">85%</p>
                    <p class="text-gray-600 text-sm">Rata-rata Progres</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">24h</p>
                    <p class="text-gray-600 text-sm">Aktivitas Terakhir</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Siswa</h3>
        </div>
        
        <div class="overflow-x-auto">
            @if($students->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-blue-600 font-medium text-sm">
                                            {{ strtoupper(substr($student->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $student->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($student->classList->count() > 0)
                                    @foreach($student->classList as $classList)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                            {{ $classList->class->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400">Belum ada kelas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($student->classList->first())
                                    {{ $student->classList->first()->created_at->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat Profil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 hover:text-green-800 transition-colors" title="Kirim Pesan">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                    <button class="text-purple-600 hover:text-purple-800 transition-colors" title="Lihat Progress">
                                        <i class="fas fa-chart-bar"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $students->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-user-graduate text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">Belum Ada Siswa</h3>
                    <p class="text-gray-500 mb-4">Siswa akan muncul di sini setelah mereka bergabung ke kelas Anda</p>
                    <div class="bg-blue-50 rounded-lg p-4 max-w-md mx-auto">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-lightbulb mr-2"></i>
                            <strong>Tips:</strong> Bagikan kode kelas kepada siswa agar mereka dapat bergabung
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection