@extends('layouts.main')

@section('title', 'Detail Kelas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 pt-20">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Detail Kelas 📚
            </h1>
            <p class="text-xl text-gray-600">
                Informasi lengkap tentang kelas {{ $class->name }}
            </p>
        </div>

        <!-- Class Details -->
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-200 mb-8">
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Class Info -->
                <div>
                    <h2 class="text-3xl font-bold text-primary mb-6">{{ $class->name }}</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-user-tie mr-3 text-primary w-6"></i>
                            <div>
                                <span class="text-gray-600">Pengajar:</span>
                                <span class="font-semibold ml-2">{{ $class->educator->name }}</span>
                            </div>
                        </div>
                        
                        @if($class->grade)
                            <div class="flex items-center">
                                <i class="fas fa-graduation-cap mr-3 text-primary w-6"></i>
                                <div>
                                    <span class="text-gray-600">Tingkat:</span>
                                    <span class="font-semibold ml-2">{{ $class->grade }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($class->subject)
                            <div class="flex items-center">
                                <i class="fas fa-book mr-3 text-primary w-6"></i>
                                <div>
                                    <span class="text-gray-600">Mata Pelajaran:</span>
                                    <span class="font-semibold ml-2">{{ $class->subject }}</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-3 text-primary w-6"></i>
                            <div>
                                <span class="text-gray-600">Dibuat:</span>
                                <span class="font-semibold ml-2">{{ $class->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-users mr-3 text-primary w-6"></i>
                            <div>
                                <span class="text-gray-600">Total Siswa:</span>
                                <span class="font-semibold ml-2">{{ $classmates->count() }} orang</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Statistik Kelas</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-4 text-center">
                            <i class="fas fa-map-marker-alt text-2xl text-primary mb-2"></i>
                            <div class="text-2xl font-bold text-gray-900">{{ $class->places->count() }}</div>
                            <div class="text-sm text-gray-600">Tempat Wisata</div>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 text-center">
                            <i class="fas fa-book-open text-2xl text-secondary mb-2"></i>
                            <div class="text-2xl font-bold text-gray-900">{{ $class->stories->count() }}</div>
                            <div class="text-sm text-gray-600">Cerita Sejarah</div>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 text-center">
                            <i class="fas fa-comments text-2xl text-tertiary mb-2"></i>
                            <div class="text-2xl font-bold text-gray-900">{{ $class->discussions->count() }}</div>
                            <div class="text-sm text-gray-600">Diskusi</div>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 text-center">
                            <i class="fas fa-users text-2xl text-quaternary mb-2"></i>
                            <div class="text-2xl font-bold text-gray-900">{{ $classmates->count() }}</div>
                            <div class="text-sm text-gray-600">Anggota</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classmates -->
        @if($classmates->count() > 0)
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-200 mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Teman Sekelas ({{ $classmates->count() }})</h3>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($classmates as $classmate)
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-white font-bold text-lg">
                                    {{ substr($classmate->name, 0, 1) }}
                                </span>
                            </div>
                            <h4 class="font-semibold text-gray-900">{{ $classmate->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $classmate->email }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="text-center">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('student.dashboard') }}" 
                   class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-colors">
                    <i class="fas fa-home mr-2"></i>Dashboard Kelas
                </a>
                
                <a href="{{ route('student.places') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-colors">
                    <i class="fas fa-map-marker-alt mr-2"></i>Tempat Wisata
                </a>
                
                <a href="{{ route('student.stories') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-colors">
                    <i class="fas fa-book-open mr-2"></i>Cerita Sejarah
                </a>
                
                <form action="{{ route('student.classes.leave') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-colors"
                            onclick="return confirm('Yakin ingin keluar dari kelas ini? Anda akan kehilangan akses ke semua konten kelas.')">
                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar Kelas
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection