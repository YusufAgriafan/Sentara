@extends('layouts.main')

@section('title', 'Detail Kelas')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-12">
            <div class="bg-primary w-20 h-20 sm:w-24 sm:h-24 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <span class="text-3xl sm:text-4xl">📚</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Detail Kelas
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 leading-relaxed">
                Informasi lengkap tentang kelas {{ $class->name }}
            </p>
        </div>

        <!-- Class Details -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xl border-2 border-quaternary mb-8">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Class Info -->
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-primary mb-6 sm:mb-8">{{ $class->name }}</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div class="bg-blue-500 w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                                <i class="fas fa-user-tie text-white"></i>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Pengajar</span>
                                <span class="font-semibold text-gray-900 text-lg">{{ $class->educator->name }}</span>
                            </div>
                        </div>
                        
                        @if($class->grade)
                            <div class="flex items-center">
                                <div class="bg-purple-500 w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                                    <i class="fas fa-graduation-cap text-white"></i>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 block">Tingkat</span>
                                    <span class="font-semibold text-gray-900 text-lg">{{ $class->grade }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($class->subject)
                            <div class="flex items-center">
                                <div class="bg-green-500 w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                                    <i class="fas fa-book text-white"></i>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 block">Mata Pelajaran</span>
                                    <span class="font-semibold text-gray-900 text-lg">{{ $class->subject }}</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex items-center">
                            <div class="bg-orange-500 w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Dibuat</span>
                                <span class="font-semibold text-gray-900 text-lg">{{ $class->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="bg-red-500 w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 block">Total Siswa</span>
                                <span class="font-semibold text-gray-900 text-lg">{{ $classmates->count() }} orang</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="bg-quaternary rounded-3xl p-6 sm:p-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Statistik Kelas</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-2xl p-4 sm:p-6 text-center border-2 border-green-200 hover:border-green-400 transition-colors">
                            <div class="bg-green-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-map-marker-alt text-white text-lg sm:text-xl"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $class->places->count() }}</div>
                            <div class="text-sm text-gray-600 font-medium">Tempat Wisata</div>
                        </div>
                        
                        <div class="bg-white rounded-2xl p-4 sm:p-6 text-center border-2 border-blue-200 hover:border-blue-400 transition-colors">
                            <div class="bg-blue-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-book-open text-white text-lg sm:text-xl"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $class->stories->count() }}</div>
                            <div class="text-sm text-gray-600 font-medium">Cerita Sejarah</div>
                        </div>
                        
                        <div class="bg-white rounded-2xl p-4 sm:p-6 text-center border-2 border-purple-200 hover:border-purple-400 transition-colors">
                            <div class="bg-purple-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-comments text-white text-lg sm:text-xl"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $class->discussions->count() }}</div>
                            <div class="text-sm text-gray-600 font-medium">Diskusi</div>
                        </div>
                        
                        <div class="bg-white rounded-2xl p-4 sm:p-6 text-center border-2 border-red-200 hover:border-red-400 transition-colors">
                            <div class="bg-red-500 w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-users text-white text-lg sm:text-xl"></i>
                            </div>
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $classmates->count() }}</div>
                            <div class="text-sm text-gray-600 font-medium">Anggota</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classmates -->
        @if($classmates->count() > 0)
            <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xl border-2 border-quaternary mb-8">
                <div class="flex items-center mb-6 sm:mb-8">
                    <div class="bg-primary w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Teman Sekelas ({{ $classmates->count() }})</h3>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                    @foreach($classmates as $classmate)
                        <div class="bg-quaternary rounded-2xl p-4 sm:p-6 text-center hover:bg-secondary transition-colors">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                <span class="text-white font-bold text-lg sm:text-xl">
                                    {{ substr($classmate->name, 0, 1) }}
                                </span>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base mb-1">{{ $classmate->name }}</h4>
                            <p class="text-xs sm:text-sm text-gray-600 break-all">{{ $classmate->email }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="text-center">
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-4xl mx-auto">
                <a href="{{ route('student.dashboard') }}" 
                   class="bg-primary hover:bg-blue-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl text-lg font-semibold transition-all duration-200 hover:scale-105 transform flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i>Dashboard Kelas
                </a>
                
                <a href="{{ route('student.places') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl text-lg font-semibold transition-all duration-200 hover:scale-105 transform flex items-center justify-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>Tempat Wisata
                </a>
                
                <a href="{{ route('student.stories') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl text-lg font-semibold transition-all duration-200 hover:scale-105 transform flex items-center justify-center">
                    <i class="fas fa-book-open mr-2"></i>Cerita Sejarah
                </a>
                
                <form action="{{ route('student.classes.leave') }}" method="POST" class="inline w-full sm:w-auto">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl text-lg font-semibold transition-all duration-200 hover:scale-105 transform flex items-center justify-center"
                            onclick="return confirm('Yakin ingin keluar dari kelas ini? Anda akan kehilangan akses ke semua konten kelas.')">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar Kelas
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection