@extends('layouts.main')

@section('title', 'Bergabung dengan Kelas')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-12">
            <div class="bg-primary w-20 h-20 sm:w-24 sm:h-24 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <span class="text-3xl sm:text-4xl">🎓</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Bergabung dengan Kelas
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Masukkan token kelas yang diberikan guru untuk mendapatkan akses ke konten pembelajaran eksklusif
            </p>
        </div>

        @if($currentClass)
            <!-- Already in a class -->
            <div class="max-w-3xl mx-auto">
                <div class="bg-secondary rounded-3xl p-6 sm:p-8 border-2 border-tertiary mb-8">
                    <div class="text-center">
                        <div class="bg-green-500 w-16 h-16 sm:w-20 sm:h-20 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl sm:text-3xl">✅</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Anda Sudah Bergabung!</h2>
                        <p class="text-lg sm:text-xl text-gray-600 mb-8 leading-relaxed">
                            Sekarang Anda memiliki akses penuh ke semua konten dan diskusi kelas
                        </p>
                        
                        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-tertiary mb-8">
                            <h3 class="text-xl sm:text-2xl font-bold text-primary mb-6">{{ $currentClass->class->name }}</h3>
                            <div class="grid sm:grid-cols-2 gap-6 text-left">
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-primary w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user-tie text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500 block">Pengajar</span>
                                            <span class="font-semibold text-gray-900">{{ $currentClass->class->educator->name }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-green-500 w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-calendar text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500 block">Bergabung</span>
                                            <span class="font-semibold text-gray-900">{{ $currentClass->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    @if($currentClass->class->grade)
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-purple-500 w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-graduation-cap text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500 block">Tingkat</span>
                                                <span class="font-semibold text-gray-900">{{ $currentClass->class->grade }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if($currentClass->class->subject)
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-orange-500 w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-book text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500 block">Mata Pelajaran</span>
                                                <span class="font-semibold text-gray-900">{{ $currentClass->class->subject }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('student.dashboard') }}" 
                               class="bg-primary hover:bg-blue-600 text-white px-6 py-3 rounded-2xl text-lg font-semibold transition-all duration-200 hover:scale-105">
                                <i class="fas fa-home mr-2"></i>Dashboard Kelas
                            </a>
                            <a href="{{ route('student.classes.details') }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-2xl text-lg font-semibold transition-all duration-200 hover:scale-105">
                                <i class="fas fa-info-circle mr-2"></i>Detail Kelas
                            </a>
                            <form action="{{ route('student.classes.leave') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-2xl text-lg font-semibold transition-all duration-200 hover:scale-105"
                                        onclick="return confirm('Yakin ingin keluar dari kelas ini? Anda akan kehilangan akses ke semua konten kelas.')">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar Kelas
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Join class form -->
            <div class="max-w-2xl mx-auto">
                <!-- Alert Messages -->
                @if(session('error'))
                    <div class="bg-red-50 border-2 border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6">
                        <div class="flex items-center">
                            <div class="bg-red-500 w-8 h-8 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-circle text-white text-sm"></i>
                            </div>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="bg-green-50 border-2 border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6">
                        <div class="flex items-center">
                            <div class="bg-green-500 w-8 h-8 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                            </div>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="bg-blue-50 border-2 border-blue-200 text-blue-700 px-6 py-4 rounded-2xl mb-6">
                        <div class="flex items-center">
                            <div class="bg-blue-500 w-8 h-8 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-info-circle text-white text-sm"></i>
                            </div>
                            <span>{{ session('info') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Join Form -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border-2 border-quaternary">
                    <div class="text-center mb-8">
                        <div class="bg-tertiary w-20 h-20 sm:w-24 sm:h-24 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <span class="text-3xl sm:text-4xl">🔑</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Masukkan Token Kelas</h2>
                        <p class="text-gray-600 leading-relaxed">
                            Token kelas adalah kode unik yang diberikan oleh guru Anda untuk bergabung dengan kelas
                        </p>
                    </div>
                    
                    <form action="{{ route('student.classes.join.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="class_token" class="block text-lg font-semibold text-gray-700 mb-3">
                                Token Kelas
                            </label>
                            <input 
                                type="text" 
                                id="class_token"
                                name="class_token" 
                                placeholder="Contoh: ABC12345" 
                                class="w-full px-6 py-4 text-center text-xl sm:text-2xl font-mono tracking-wider border-2 rounded-2xl focus:border-primary focus:outline-none transition-all duration-200 {{ $errors->has('class_token') ? '!border-red-500' : 'border-gray-300' }}"
                                style="text-transform: uppercase;"
                                maxlength="10"
                                required
                                autocomplete="off"
                            >
                            @error('class_token')
                                <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-primary hover:bg-blue-600 text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-200 hover:scale-105 transform">
                            <i class="fas fa-sign-in-alt mr-3"></i>Bergabung dengan Kelas
                        </button>
                    </form>
                    
                    <div class="mt-8 p-6 bg-quaternary rounded-2xl">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-500 w-10 h-10 rounded-xl flex items-center justify-center mr-3">
                                <span class="text-white text-lg">💡</span>
                            </div>
                            <h3 class="font-semibold text-gray-800">Tips Bergabung:</h3>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-3">
                            <li class="flex items-start">
                                <div class="bg-green-500 w-5 h-5 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span>Token kelas biasanya terdiri dari 6-8 karakter huruf dan angka</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-green-500 w-5 h-5 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span>Pastikan tidak ada spasi di awal atau akhir token</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-green-500 w-5 h-5 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <span>Jika token tidak valid, hubungi guru Anda</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-blue-500 w-5 h-5 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-lock text-white text-xs"></i>
                                </div>
                                <span>Setiap siswa hanya bisa bergabung dengan satu kelas</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Available Classes Info -->
        @if($availableClasses->count() > 0)
            <div class="max-w-4xl mx-auto mt-12 sm:mt-16">
                <div class="text-center mb-8 sm:mb-12">
                    <div class="bg-primary w-16 h-16 sm:w-20 sm:h-20 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-white text-xl sm:text-2xl"></i>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Kelas Yang Tersedia</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Berikut adalah daftar kelas yang aktif. Hubungi guru untuk mendapatkan token bergabung.
                    </p>
                </div>
                
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableClasses as $class)
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-quaternary hover:border-primary transition-all duration-200 hover:scale-105 transform">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-primary w-12 h-12 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-users text-white text-lg"></i>
                                </div>
                                <div class="bg-green-100 text-green-700 px-3 py-1 rounded-2xl text-sm font-semibold flex items-center">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                    Aktif
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $class->name }}</h3>
                            
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-500 w-8 h-8 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-user-tie text-white text-sm"></i>
                                </div>
                                <span class="text-gray-700 font-medium">{{ $class->educator->name }}</span>
                            </div>
                            
                            @if($class->grade || $class->subject)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($class->grade)
                                        <span class="bg-secondary text-gray-700 px-3 py-1 rounded-2xl text-sm font-medium">{{ $class->grade }}</span>
                                    @endif
                                    @if($class->subject)
                                        <span class="bg-tertiary text-gray-700 px-3 py-1 rounded-2xl text-sm font-medium">{{ $class->subject }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-users mr-2"></i>
                                    <span>{{ $class->classLists->count() }} siswa</span>
                                </div>
                                <div class="text-gray-500 text-sm">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $class->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Auto-uppercase token input
document.addEventListener('DOMContentLoaded', function() {
    const tokenInput = document.getElementById('class_token');
    if (tokenInput) {
        tokenInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }
});
</script>
@endsection