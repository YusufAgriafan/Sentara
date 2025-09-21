@extends('layouts.main')

@section('title', 'Kelas & Diskusi')

@section('content')
    <!-- Hero Section for Kelas -->
    <section class="pt-32 pb-20 px-6 lg:px-8 bg-gradient-to-br from-tertiary to-primary text-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">👥</div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight">
                    Kelas <span class="text-quaternary">Diskusi</span> Seru!
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Gabung dengan ribuan anak muda lainnya untuk diskusi sejarah yang asik dan dapat teman baru!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button onclick="scrollToSection('classes')" class="bg-white hover:bg-gray-100 text-tertiary px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-users mr-3"></i>
                        Join Kelas
                    </button>
                    <button onclick="scrollToSection('discussions')" class="bg-white/20 hover:bg-white/30 text-white px-8 py-4 rounded-2xl text-xl font-semibold transition-all duration-300 backdrop-blur-sm border border-white/30">
                        <i class="fas fa-comments mr-3"></i>
                        Lihat Diskusi
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Active Classes Section -->
    <section id="classes" class="py-20 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            @auth
                @if(auth()->user()->role === 'student')
                    @if($currentClass)
                        <!-- Current Class Info -->
                        <div class="text-center mb-12 fade-in-up">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-3xl p-8 border-2 border-green-200">
                                <div class="text-6xl mb-4">✅</div>
                                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kamu Sudah Bergabung!</h2>
                                <p class="text-xl text-gray-600 mb-6">Sekarang kamu bisa mengakses semua konten dan diskusi di kelas</p>
                                
                                <div class="bg-white rounded-2xl p-6 border border-green-200 max-w-2xl mx-auto">
                                    <h3 class="text-2xl font-bold text-primary mb-2">{{ $currentClass->name }}</h3>
                                    <p class="text-gray-600 mb-4">
                                        <i class="fas fa-user-tie mr-2"></i>Pengajar: {{ $currentClass->educator->name }}
                                    </p>
                                    @if($currentClass->grade || $currentClass->subject)
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @if($currentClass->grade)
                                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">{{ $currentClass->grade }}</span>
                                            @endif
                                            @if($currentClass->subject)
                                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">{{ $currentClass->subject }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="flex gap-4 justify-center">
                                        <a href="{{ route('student.dashboard') }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                                            <i class="fas fa-home mr-2"></i>Dashboard Kelas
                                        </a>
                                        <form action="{{ route('student.classes.leave') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors" onclick="return confirm('Yakin ingin keluar dari kelas ini?')">
                                                <i class="fas fa-sign-out-alt mr-2"></i>Keluar Kelas
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Join Class Form -->
                        <div class="text-center mb-12 fade-in-up">
                            <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Bergabung dengan Kelas! 🎓</h2>
                            <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-12">Masukkan token kelas yang diberikan guru untuk bergabung dengan kelas</p>
                            
                            <!-- Error/Success Messages -->
                            @if(session('error'))
                                <div class="bg-red-50 border-2 border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-8 max-w-2xl mx-auto">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                                </div>
                            @endif
                            
                            @if(session('success'))
                                <div class="bg-green-50 border-2 border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 max-w-2xl mx-auto">
                                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                                </div>
                            @endif
                            
                            @if(session('info'))
                                <div class="bg-blue-50 border-2 border-blue-200 text-blue-700 px-6 py-4 rounded-2xl mb-8 max-w-2xl mx-auto">
                                    <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
                                </div>
                            @endif

                            <!-- Join Class Form -->
                            <div class="bg-white rounded-3xl p-8 shadow-lg border-2 border-primary/20 max-w-2xl mx-auto">
                                <div class="text-6xl mb-6">🔑</div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Masukkan Token Kelas</h3>
                                <form action="{{ route('student.classes.join') }}" method="POST">
                                    @csrf
                                    <div class="mb-6">
                                        <input 
                                            type="text" 
                                            name="class_token" 
                                            placeholder="Contoh: ABC12345" 
                                            class="w-full px-6 py-4 text-center text-xl font-mono tracking-wider border-2 rounded-xl focus:border-primary focus:outline-none @error('class_token') border-red-500 @else border-gray-300 @enderror"
                                            style="text-transform: uppercase;"
                                            maxlength="10"
                                            required
                                        >
                                        @error('class_token')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl text-xl font-semibold transition-colors">
                                        <i class="fas fa-sign-in-alt mr-3"></i>Bergabung dengan Kelas
                                    </button>
                                </form>
                                
                                <div class="mt-6 text-gray-600 text-sm">
                                    <p><i class="fas fa-info-circle mr-2"></i>Token kelas didapatkan dari guru Anda</p>
                                    <p><i class="fas fa-lock mr-2"></i>Setiap siswa hanya bisa bergabung dengan satu kelas</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @else
                <!-- Guest View -->
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Bergabung dengan Kelas! 🎓</h2>
                    <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-12">Masuk terlebih dahulu untuk bergabung dengan kelas</p>
                    
                    <div class="bg-blue-50 border-2 border-blue-200 text-blue-700 px-6 py-4 rounded-2xl max-w-2xl mx-auto mb-8">
                        <i class="fas fa-user-lock mr-2"></i>Anda harus masuk sebagai siswa untuk bergabung dengan kelas
                    </div>
                    
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl text-xl font-semibold transition-colors">
                            <i class="fas fa-sign-in-alt mr-3"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-secondary hover:bg-secondary/90 text-white px-8 py-4 rounded-xl text-xl font-semibold transition-colors">
                            <i class="fas fa-user-plus mr-3"></i>Daftar
                        </a>
                    </div>
                </div>
            @endauth

            <!-- Available Classes Display (for reference) -->
            @if($availableClasses->count() > 0)
                <div class="text-center mb-12 fade-in-up">
                    <h3 class="text-3xl font-bold text-gray-900 mb-8">Kelas yang Tersedia</h3>
                    <p class="text-lg text-gray-600 mb-8">Berikut adalah kelas-kelas yang sedang aktif (hubungi guru untuk mendapatkan token)</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($availableClasses as $class)
                        <div class="bg-white rounded-3xl p-8 shadow-lg hover-lift fade-in-up border-2 border-primary/20">
                            <div class="flex items-center justify-between mb-6">
                                <div class="bg-primary w-12 h-12 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-white text-xl"></i>
                                </div>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                    🟢 Aktif
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $class->name }}</h3>
                            <p class="text-gray-600 leading-relaxed mb-6">
                                <i class="fas fa-user-tie mr-2"></i>Pengajar: {{ $class->educator->name }}
                            </p>
                            
                            @if($class->grade || $class->subject)
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @if($class->grade)
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">{{ $class->grade }}</span>
                                    @endif
                                    @if($class->subject)
                                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">{{ $class->subject }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-2">
                                    <div class="flex -space-x-2">
                                        @for($i = 0; $i < min(3, $class->classLists->count()); $i++)
                                            <div class="w-8 h-8 bg-primary rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($class->classLists[$i]->student->name, 0, 1) }}
                                            </div>
                                        @endfor
                                    </div>
                                    <span class="text-gray-600 text-sm">{{ $class->classLists->count() }} siswa</span>
                                </div>
                                <span class="text-primary font-semibold text-sm">{{ $class->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div class="bg-gray-100 text-gray-600 px-6 py-3 rounded-xl font-semibold text-center">
                                <i class="fas fa-lock mr-2"></i>Perlu Token Kelas
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

    <!-- Hot Discussions Section -->
    <section id="discussions" class="py-20 px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            @auth
                @if(auth()->user()->role === 'student' && $currentClass)
                    <!-- Student in Class - Show Discussions -->
                    <div class="text-center mb-12 fade-in-up">
                        <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Diskusi Kelas 💬</h2>
                        <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-8">
                            Diskusi dengan teman sekelas dan guru tentang materi pelajaran
                        </p>
                    </div>

                    <!-- Create New Discussion -->
                    <div class="bg-white rounded-3xl p-8 shadow-lg border-2 border-primary/20 mb-12 fade-in-up">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary w-12 h-12 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-plus text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Buat Diskusi Baru</h3>
                        </div>
                        
                        <form action="{{ route('student.discussions.create') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <input 
                                    type="text" 
                                    name="title" 
                                    placeholder="Judul diskusi..." 
                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:border-primary focus:outline-none text-lg"
                                    required
                                >
                                @error('title')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <textarea 
                                    name="content" 
                                    placeholder="Tulis pertanyaan atau topik diskusi Anda..." 
                                    rows="4"
                                    class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:border-primary focus:outline-none text-lg resize-none"
                                    required
                                ></textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i>Posting Diskusi
                            </button>
                        </form>
                    </div>

                    <!-- Discussion Threads -->
                    @if(isset($discussions) && $discussions->count() > 0)
                        <div class="space-y-8">
                            @foreach($discussions as $discussion)
                                <div class="bg-white rounded-3xl p-8 shadow-lg border-2 border-gray-100 hover:border-primary/30 transition-colors fade-in-up">
                                    <div class="flex items-start justify-between mb-6">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr($discussion->student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $discussion->title }}</h3>
                                                <p class="text-gray-600 text-sm">
                                                    <span class="font-medium">{{ $discussion->student->name }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 text-gray-500">
                                            <div class="flex items-center">
                                                <i class="fas fa-comments mr-1"></i>
                                                <span class="text-sm">{{ $discussion->replies_count ?? 0 }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-eye mr-1"></i>
                                                <span class="text-sm">{{ $discussion->views ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <p class="text-gray-700 leading-relaxed">{{ $discussion->content }}</p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            @if($discussion->subject)
                                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">{{ $discussion->subject }}</span>
                                            @endif
                                            @if($discussion->urgent)
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">🔥 Urgent</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('student.discussions.show', $discussion->id) }}" class="bg-primary/10 hover:bg-primary/20 text-primary px-6 py-2 rounded-xl font-semibold transition-colors">
                                            <i class="fas fa-arrow-right mr-2"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($discussions->hasPages())
                            <div class="mt-12 flex justify-center">
                                {{ $discussions->links() }}
                            </div>
                        @endif
                    @else
                        <!-- No Discussions Yet -->
                        <div class="text-center py-12">
                            <div class="bg-white rounded-3xl p-12 shadow-lg max-w-2xl mx-auto">
                                <div class="text-6xl mb-6">💭</div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Diskusi</h3>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    Jadilah yang pertama memulai diskusi di kelas ini! 
                                    Ajukan pertanyaan atau topik menarik untuk dibahas bersama.
                                </p>
                                <button onclick="scrollToSection('discussions')" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                                    <i class="fas fa-plus mr-2"></i>Mulai Diskusi Pertama
                                </button>
                            </div>
                        </div>
                    @endif

                @elseif(auth()->user()->role === 'student' && !$currentClass)
                    <!-- Student Not in Class -->
                    <div class="text-center mb-12 fade-in-up">
                        <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Diskusi Kelas 💬</h2>
                        <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-8">
                            Bergabung dengan kelas untuk mengakses forum diskusi
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-white rounded-3xl p-12 shadow-lg max-w-2xl mx-auto">
                            <div class="text-6xl mb-6">🔒</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Akses Terbatas</h3>
                            <p class="text-gray-600 leading-relaxed mb-6">
                                Fitur diskusi hanya tersedia untuk siswa yang sudah bergabung dengan kelas. 
                                Masukkan token kelas dari guru Anda untuk bergabung.
                            </p>
                            <button onclick="scrollToSection('classes')" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                                <i class="fas fa-arrow-up mr-2"></i>Bergabung dengan Kelas
                            </button>
                        </div>
                    </div>

                @elseif(auth()->user()->role === 'educator')
                    <!-- Educator View -->
                    <div class="text-center mb-12 fade-in-up">
                        <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Diskusi Kelas 💬</h2>
                        <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-8">
                            Pantau dan kelola diskusi siswa di kelas Anda
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-white rounded-3xl p-12 shadow-lg max-w-2xl mx-auto">
                            <div class="text-6xl mb-6">👨‍🏫</div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Dashboard Guru</h3>
                            <p class="text-gray-600 leading-relaxed mb-6">
                                Akses dashboard guru untuk melihat dan mengelola diskusi di semua kelas Anda.
                            </p>
                            <a href="{{ route('educator.dashboard') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Guru
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <!-- Guest View -->
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">Diskusi Kelas 💬</h2>
                    <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-8">
                        Masuk untuk bergabung dalam diskusi kelas yang interaktif
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-white rounded-3xl p-12 shadow-lg max-w-2xl mx-auto">
                        <div class="text-6xl mb-6">🚪</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Masuk Diperlukan</h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Daftar atau masuk terlebih dahulu untuk mengakses fitur diskusi kelas dan berinteraksi dengan siswa lain.
                        </p>
                        <div class="flex gap-4 justify-center">
                            <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                            </a>
                            <a href="{{ route('register') }}" class="bg-secondary hover:bg-secondary/90 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </section>
@endsection