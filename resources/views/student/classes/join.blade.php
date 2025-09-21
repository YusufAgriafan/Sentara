@extends('layouts.main')

@section('title', 'Bergabung dengan Kelas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 pt-20">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Bergabung dengan Kelas 🎓
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Masukkan token kelas yang diberikan guru untuk mendapatkan akses ke konten pembelajaran eksklusif
            </p>
        </div>

        @if($currentClass)
            <!-- Already in a class -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-3xl p-8 border-2 border-green-200 mb-8">
                    <div class="text-center">
                        <div class="text-6xl mb-4">✅</div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Anda Sudah Bergabung!</h2>
                        <p class="text-xl text-gray-600 mb-8">
                            Sekarang Anda memiliki akses penuh ke semua konten dan diskusi kelas
                        </p>
                        
                        <div class="bg-white rounded-2xl p-6 border border-green-200 mb-8">
                            <h3 class="text-2xl font-bold text-primary mb-4">{{ $currentClass->class->name }}</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-left">
                                <div>
                                    <p class="text-gray-600 mb-2">
                                        <i class="fas fa-user-tie mr-2 text-primary"></i>
                                        <strong>Pengajar:</strong> {{ $currentClass->class->educator->name }}
                                    </p>
                                    <p class="text-gray-600 mb-2">
                                        <i class="fas fa-calendar mr-2 text-primary"></i>
                                        <strong>Bergabung:</strong> {{ $currentClass->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    @if($currentClass->class->grade)
                                        <p class="text-gray-600 mb-2">
                                            <i class="fas fa-graduation-cap mr-2 text-primary"></i>
                                            <strong>Tingkat:</strong> {{ $currentClass->class->grade }}
                                        </p>
                                    @endif
                                    @if($currentClass->class->subject)
                                        <p class="text-gray-600 mb-2">
                                            <i class="fas fa-book mr-2 text-primary"></i>
                                            <strong>Mata Pelajaran:</strong> {{ $currentClass->class->subject }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('student.dashboard') }}" 
                               class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-colors">
                                <i class="fas fa-home mr-2"></i>Dashboard Kelas
                            </a>
                            <a href="{{ route('student.classes.details') }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-colors">
                                <i class="fas fa-info-circle mr-2"></i>Detail Kelas
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
        @else
            <!-- Join class form -->
            <div class="max-w-2xl mx-auto">
                <!-- Alert Messages -->
                @if(session('error'))
                    <div class="bg-red-50 border-2 border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-8">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="bg-green-50 border-2 border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="bg-blue-50 border-2 border-blue-200 text-blue-700 px-6 py-4 rounded-2xl mb-8">
                        <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
                    </div>
                @endif

                <!-- Join Form -->
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-200">
                    <div class="text-center mb-8">
                        <div class="text-6xl mb-6">🔑</div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Masukkan Token Kelas</h2>
                        <p class="text-gray-600">
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
                                class="w-full px-6 py-4 text-center text-2xl font-mono tracking-wider border-2 border-gray-300 rounded-xl focus:border-primary focus:outline-none transition-colors @error('class_token') border-red-500 @enderror"
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
                                class="w-full bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl text-xl font-semibold transition-colors transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-3"></i>Bergabung dengan Kelas
                        </button>
                    </form>
                    
                    <div class="mt-8 p-6 bg-gray-50 rounded-2xl">
                        <h3 class="font-semibold text-gray-800 mb-3">💡 Tips:</h3>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li><i class="fas fa-check mr-2 text-green-500"></i>Token kelas biasanya terdiri dari 6-8 karakter huruf dan angka</li>
                            <li><i class="fas fa-check mr-2 text-green-500"></i>Pastikan tidak ada spasi di awal atau akhir token</li>
                            <li><i class="fas fa-check mr-2 text-green-500"></i>Jika token tidak valid, hubungi guru Anda</li>
                            <li><i class="fas fa-lock mr-2 text-blue-500"></i>Setiap siswa hanya bisa bergabung dengan satu kelas</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Available Classes Info -->
        @if($availableClasses->count() > 0)
            <div class="max-w-6xl mx-auto mt-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Kelas Yang Tersedia</h2>
                    <p class="text-lg text-gray-600">
                        Berikut adalah daftar kelas yang aktif. Hubungi guru untuk mendapatkan token bergabung.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableClasses as $class)
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-primary w-12 h-12 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-white text-xl"></i>
                                </div>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                    🟢 Aktif
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $class->name }}</h3>
                            <p class="text-gray-600 mb-4">
                                <i class="fas fa-user-tie mr-2"></i>{{ $class->educator->name }}
                            </p>
                            
                            @if($class->grade || $class->subject)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($class->grade)
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">{{ $class->grade }}</span>
                                    @endif
                                    @if($class->subject)
                                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">{{ $class->subject }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 text-sm">{{ $class->classLists->count() }} siswa</span>
                                <span class="text-gray-500 text-sm">{{ $class->created_at->diffForHumans() }}</span>
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
document.getElementById('class_token').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endsection