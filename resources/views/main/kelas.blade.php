@extends('layouts.main')

@section('title', 'Kelas & Diskusi')

@section('content')
    <!-- Hero Section for Kelas -->
    <section class="pt-32 pb-24 px-6 lg:px-8 bg-primary text-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center fade-in-up">
                <div class="text-8xl mb-8">👥</div>
                <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight">
                    Kelas <span class="text-secondary">Diskusi</span> Seru!
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Gabung dengan ribuan anak muda lainnya untuk diskusi sejarah yang asik dan dapat teman baru!
                </p>
            </div>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <button onclick="scrollToSection('classes')" class="bg-white hover:bg-secondary text-primary px-10 py-5 rounded-3xl text-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                        <i class="fas fa-users mr-3"></i>
                        Join Kelas
                    </button>
                    <button onclick="scrollToSection('discussions')" class="bg-tertiary hover:bg-tertiary/90 text-gray-900 px-10 py-5 rounded-3xl text-xl font-bold transition-all duration-300 hover:scale-105">
                        <i class="fas fa-comments mr-3"></i>
                        Lihat Diskusi
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Active Classes Section -->
    <section id="classes" class="py-24 px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            @auth
                @if(auth()->user()->role === 'student')
                    @if($currentClass)
                        <!-- Current Class Info -->
                        <div class="text-center mb-16 fade-in-up">
                            <div class="bg-secondary rounded-3xl p-12 border-2 border-tertiary">
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
                        <div class="text-center mb-16 fade-in-up">
                            <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Bergabung dengan Kelas! 🎓</h2>
                            <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-16">Masukkan token kelas yang diberikan guru untuk bergabung dengan kelas</p>
                            
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
                            <div class="bg-quaternary rounded-3xl p-12 shadow-xl border-2 border-gray-200 max-w-2xl mx-auto">
                                <div class="text-6xl mb-6">🔑</div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Masukkan Token Kelas</h3>
                                <form action="{{ route('student.classes.join') }}" method="POST">
                                    @csrf
                                    <div class="mb-8">
                                        <input 
                                            type="text" 
                                            name="class_token" 
                                            placeholder="Contoh: ABC12345" 
                                            class="w-full px-8 py-5 text-center text-xl font-mono tracking-wider border-2 rounded-2xl focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20 {{ $errors->has('class_token') ? 'border-red-500' : 'border-gray-300' }} bg-white"
                                            style="text-transform: uppercase;"
                                            maxlength="10"
                                            required
                                        >
                                        @error('class_token')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105">
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
                <div class="text-center mb-16 fade-in-up">
                    <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Bergabung dengan Kelas! 🎓</h2>
                    <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-16">Masuk terlebih dahulu untuk bergabung dengan kelas</p>
                    
                    <div class="bg-blue-50 border-2 border-blue-200 text-blue-700 px-6 py-4 rounded-2xl max-w-2xl mx-auto mb-8">
                        <i class="fas fa-user-lock mr-2"></i>Anda harus masuk sebagai siswa untuk bergabung dengan kelas
                    </div>
                    
                    <div class="flex gap-6 justify-center">
                        <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-3"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-tertiary hover:bg-tertiary/90 text-gray-900 px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 hover:scale-105">
                            <i class="fas fa-user-plus mr-3"></i>Daftar
                        </a>
                    </div>
                </div>
            @endauth

            <!-- Available Classes Display (for reference) -->
            @if($availableClasses->count() > 0)
                <div class="text-center mb-16 fade-in-up">
                    <h3 class="text-4xl font-bold text-gray-900 mb-10">Kelas yang Tersedia</h3>
                    <p class="text-xl text-gray-600 mb-12">Berikut adalah kelas-kelas yang sedang aktif (hubungi guru untuk mendapatkan token)</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($availableClasses as $class)
                        <div class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 fade-in-up border border-gray-200">
                            <div class="flex items-center justify-between mb-8">
                                <div class="bg-primary w-16 h-16 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-users text-white text-2xl"></i>
                                </div>
                                <span class="bg-secondary text-gray-900 px-4 py-2 rounded-full text-sm font-bold">
                                    🟢 Aktif
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $class->name }}</h3>
                            <p class="text-gray-600 leading-relaxed mb-8 flex items-center">
                                <i class="fas fa-user-tie mr-3 text-primary"></i>Pengajar: {{ $class->educator->name }}
                            </p>
                            
                            @if($class->grade || $class->subject)
                                <div class="flex flex-wrap gap-3 mb-8">
                                    @if($class->grade)
                                        <span class="bg-tertiary text-gray-900 px-4 py-2 rounded-full text-sm font-bold">{{ $class->grade }}</span>
                                    @endif
                                    @if($class->subject)
                                        <span class="bg-quaternary text-gray-700 px-4 py-2 rounded-full text-sm font-bold">{{ $class->subject }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center space-x-3">
                                    <div class="flex -space-x-2">
                                        @for($i = 0; $i < min(3, $class->classLists->count()); $i++)
                                            <div class="w-10 h-10 bg-primary rounded-full border-2 border-white flex items-center justify-center text-white text-sm font-bold">
                                                {{ substr($class->classLists[$i]->student->name, 0, 1) }}
                                            </div>
                                        @endfor
                                    </div>
                                    <span class="text-gray-600 font-medium">{{ $class->classLists->count() }} siswa</span>
                                </div>
                                <span class="text-primary font-bold text-sm">{{ $class->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div class="bg-quaternary text-gray-700 px-8 py-4 rounded-2xl font-bold text-center">
                                <i class="fas fa-lock mr-2"></i>Perlu Token Kelas
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- AI Chatbot Panel (always visible) -->
            <div id="ai-widget" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
                <!-- Panel (always visible) -->
                <div id="ai-panel" class="w-80 md:w-96 bg-white rounded-3xl shadow-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white">🤖</div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">AI Tutor — Bantuan Belajar</h3>
                                <span class="text-xs text-gray-400">Powered by Gemini</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button id="ai-minimize" class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1" aria-label="Minimize" title="Kecilkan">−</button>
                            <button id="ai-close" class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1" aria-label="Tutup" title="Tutup">✕</button>
                        </div>
                    </div>

                    <div id="chat-container" class="mb-3 max-h-72 overflow-y-auto space-y-3 px-1">
                        <!-- messages will be appended here -->
                        <div id="chat-loading" class="text-center text-gray-500">Memuat riwayat...</div>
                    </div>

                    <form id="chat-form" class="flex gap-2">
                        <input type="text" id="chat-input" name="message" placeholder="Tanyakan sesuatu..." class="flex-1 px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary" autocomplete="off">
                        <button id="chat-send" type="submit" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-2xl font-bold">Kirim</button>
                    </form>

                    <p class="text-xs text-gray-500 mt-2">Riwayat tersimpan untuk keperluan pembelajaran. Hindari data sensitif.</p>
                </div>

                <!-- Minimized state (hidden by default) -->
                <div id="ai-minimized" class="hidden w-80 md:w-96 bg-white rounded-3xl shadow-xl border border-gray-200 p-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-white text-sm">🤖</div>
                            <span class="text-sm font-bold text-gray-900">AI Tutor</span>
                        </div>
                        <button id="ai-restore" class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1" aria-label="Restore" title="Buka kembali">⬆</button>
                    </div>
                </div>
            </div>

    <!-- Hot Discussions Section -->
    <section id="discussions" class="py-24 px-6 lg:px-8 bg-quaternary">
        <div class="max-w-7xl mx-auto">
            @auth
                @if(auth()->user()->role === 'student' && $currentClass)
                    <!-- Student in Class - Show Discussions -->
                    <div class="text-center mb-16 fade-in-up">
                        <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Diskusi Kelas 💬</h2>
                        <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-10">
                            Diskusi dengan teman sekelas dan guru tentang materi pelajaran
                        </p>
                    </div>

                    <!-- Info for Students: Only Educators Can Create Discussions -->
                    <div class="bg-blue-50 rounded-3xl p-10 shadow-xl border-2 border-blue-200 mb-16 fade-in-up">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-500 w-12 h-12 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-info-circle text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-blue-800">Informasi Diskusi</h3>
                        </div>
                        
                        <div class="bg-white rounded-2xl p-8 border border-blue-200">
                            <div class="text-center">
                                <div class="text-6xl mb-4">👨‍🏫</div>
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Hanya Guru Yang Dapat Membuat Diskusi</h4>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    Diskusi baru hanya dapat dibuat oleh guru/edukator. Sebagai siswa, Anda dapat berpartisipasi 
                                    dalam diskusi yang sudah ada dengan memberikan komentar dan jawaban.
                                </p>
                                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span>Baca diskusi</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span>Balas diskusi</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        <span>Buat diskusi baru</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Discussion Threads -->
                    @if(isset($discussions) && $discussions->count() > 0)
                        <div class="space-y-10">
                            @foreach($discussions as $discussion)
                                <div class="bg-white rounded-3xl p-10 shadow-xl border border-gray-200 hover:border-primary/50 transition-all duration-300 hover:scale-[1.02] fade-in-up">
                                    <div class="flex items-start justify-between mb-8">
                                        <div class="flex items-start space-x-6">
                                            <div class="w-14 h-14 bg-primary rounded-full flex items-center justify-center text-white font-bold text-xl">
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
                                        <a href="{{ route('student.discussions.show', $discussion->id) }}" class="bg-secondary hover:bg-tertiary text-gray-900 px-8 py-3 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
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
                        <div class="text-center py-16">
                            <div class="bg-white rounded-3xl p-16 shadow-xl max-w-2xl mx-auto border border-gray-200">
                                <div class="text-8xl mb-8">💭</div>
                                <h3 class="text-3xl font-bold text-gray-900 mb-6">Belum Ada Diskusi</h3>
                                <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                                    Jadilah yang pertama memulai diskusi di kelas ini! 
                                    Ajukan pertanyaan atau topik menarik untuk dibahas bersama.
                                </p>
                                <button onclick="scrollToSection('discussions')" class="bg-primary hover:bg-primary/90 text-white px-10 py-4 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
                                    <i class="fas fa-plus mr-2"></i>Mulai Diskusi Pertama
                                </button>
                            </div>
                        </div>
                    @endif

                @elseif(auth()->user()->role === 'student' && !$currentClass)
                    <!-- Student Not in Class -->
                    <div class="text-center mb-16 fade-in-up">
                        <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Diskusi Kelas 💬</h2>
                        <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-10">
                            Bergabung dengan kelas untuk mengakses forum diskusi
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-white rounded-3xl p-16 shadow-xl max-w-2xl mx-auto border border-gray-200">
                            <div class="text-8xl mb-8">🔒</div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-6">Akses Terbatas</h3>
                            <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                                Fitur diskusi hanya tersedia untuk siswa yang sudah bergabung dengan kelas. 
                                Masukkan token kelas dari guru Anda untuk bergabung.
                            </p>
                            <button onclick="scrollToSection('classes')" class="bg-primary hover:bg-primary/90 text-white px-10 py-4 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-arrow-up mr-2"></i>Bergabung dengan Kelas
                            </button>
                        </div>
                    </div>

                @elseif(auth()->user()->role === 'educator')
                    <!-- Educator View -->
                    <div class="text-center mb-16 fade-in-up">
                        <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Diskusi Kelas 💬</h2>
                        <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-10">
                            Pantau dan kelola diskusi siswa di kelas Anda
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-white rounded-3xl p-16 shadow-xl max-w-2xl mx-auto border border-gray-200">
                            <div class="text-8xl mb-8">👨‍🏫</div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-6">Dashboard Guru</h3>
                            <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                                Akses dashboard guru untuk melihat dan mengelola diskusi di semua kelas Anda.
                            </p>
                            <a href="{{ route('educator.dashboard') }}" class="bg-primary hover:bg-primary/90 text-white px-10 py-4 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Guru
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <!-- Guest View -->
                <div class="text-center mb-16 fade-in-up">
                    <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-8">Diskusi Kelas 💬</h2>
                    <p class="text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto mb-10">
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
                        <div class="flex gap-6 justify-center">
                            <a href="{{ route('login') }}" class="bg-primary hover:bg-primary/90 text-white px-10 py-4 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                            </a>
                            <a href="{{ route('register') }}" class="bg-tertiary hover:bg-tertiary/90 text-gray-900 px-10 py-4 rounded-2xl font-bold transition-all duration-300 hover:scale-105">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // AI widget controls - panel always visible with minimize/restore functionality
    let aiPanel = document.getElementById('ai-panel');
    let aiMinimized = document.getElementById('ai-minimized');
    let aiClose = document.getElementById('ai-close');
    let aiMinimize = document.getElementById('ai-minimize');
    let aiRestore = document.getElementById('ai-restore');
    let aiOpen = true; // Always start as open

    // If elements are missing (render issue), create a minimal fallback widget
    if (!aiPanel || !aiMinimized) {
        console.warn('AI widget elements not found. Creating fallback widget.');
        const fallback = document.createElement('div');
        fallback.id = 'ai-widget-fallback';
        fallback.className = 'fixed bottom-6 right-6 z-50 flex flex-col items-end';
        fallback.innerHTML = `
            <div id="ai-panel" class="w-80 md:w-96 bg-white rounded-3xl shadow-xl border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white">🤖</div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">AI Tutor — Bantuan Belajar</h3>
                            <span class="text-xs text-gray-400">Powered by Gemini</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button id="ai-minimize" class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1">−</button>
                        <button id="ai-close" class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1">✕</button>
                    </div>
                </div>
                <div id="chat-container" class="mb-3 max-h-72 overflow-y-auto space-y-3 px-1">
                    <div id="chat-loading" class="text-center text-gray-500">Memuat riwayat...</div>
                </div>
                <form id="chat-form" class="flex gap-2">
                    <input type="text" id="chat-input" name="message" placeholder="Tanyakan sesuatu..." class="flex-1 px-3 py-2 border rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary" autocomplete="off">
                    <button id="chat-send" type="submit" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-2xl font-bold">Kirim</button>
                </form>
                <p class="text-xs text-gray-500 mt-2">Riwayat tersimpan untuk keperluan pembelajaran. Hindari data sensitif.</p>
            </div>
            <div id="ai-minimized" class="hidden w-80 md:w-96 bg-white rounded-3xl shadow-xl border border-gray-200 p-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-white text-sm">🤖</div>
                        <span class="text-sm font-bold text-gray-900">AI Tutor</span>
                    </div>
                    <button id="ai-restore" class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1">⬆</button>
                </div>
            </div>
        `;
        document.body.appendChild(fallback);

        // Re-query the elements after creating fallback
        aiPanel = document.getElementById('ai-panel');
        aiMinimized = document.getElementById('ai-minimized');
        aiClose = document.getElementById('ai-close');
        aiMinimize = document.getElementById('ai-minimize');
        aiRestore = document.getElementById('ai-restore');
    }

    function closeAiPanel() {
        if (aiPanel) aiPanel.classList.add('hidden');
        if (aiMinimized) aiMinimized.classList.add('hidden');
        aiOpen = false;
        console.log('AI panel closed');
    }

    function minimizeAiPanel() {
        if (aiPanel) aiPanel.classList.add('hidden');
        if (aiMinimized) aiMinimized.classList.remove('hidden');
        aiOpen = false;
        console.log('AI panel minimized');
    }

    function restoreAiPanel() {
        if (aiPanel) aiPanel.classList.remove('hidden');
        if (aiMinimized) aiMinimized.classList.add('hidden');
        aiOpen = true;
        console.log('AI panel restored');
        setTimeout(() => {
            const chatContainerScroll = document.getElementById('chat-container');
            if (chatContainerScroll) chatContainerScroll.scrollTop = chatContainerScroll.scrollHeight;
        }, 100);
    }

    // Event listeners
    if (aiClose) {
        aiClose.addEventListener('click', closeAiPanel);
        console.log('aiClose listener attached');
    }

    if (aiMinimize) {
        aiMinimize.addEventListener('click', minimizeAiPanel);
        console.log('aiMinimize listener attached');
    }

    if (aiRestore) {
        aiRestore.addEventListener('click', restoreAiPanel);
        console.log('aiRestore listener attached');
    }
    function openAiPanel() {
        if (aiPanel) aiPanel.classList.remove('hidden');
        if (aiMinimized) aiMinimized.classList.add('hidden');
        aiOpen = true;
        console.log('AI panel opened');
        // ensure chat loads and scrolls when opened
        loadHistory();
        setTimeout(() => {
            const chatContainerScroll = document.getElementById('chat-container');
            if (chatContainerScroll) chatContainerScroll.scrollTop = chatContainerScroll.scrollHeight;
        }, 100);
    }

    console.log('AI elements present?', { aiPanel: !!aiPanel, aiMinimized: !!aiMinimized, aiClose: !!aiClose });

    const chatContainer = document.getElementById('chat-container');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');

    const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

    async function loadHistory() {
        try {
            const res = await fetch("{{ route('api.chat.history') }}", { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Gagal memuat riwayat');
            const data = await res.json();
            chatContainer.innerHTML = '';
            if (data.messages && data.messages.length) {
                data.messages.forEach(m => appendMessage(m));
            } else {
                chatContainer.innerHTML = '<div class="text-center text-gray-500">Belum ada riwayat. Mulai percakapan dengan menanyakan sesuatu.</div>';
            }
            chatContainer.scrollTop = chatContainer.scrollHeight;
        } catch (err) {
            chatContainer.innerHTML = '<div class="text-center text-red-500">' + (err.message || 'Error') + '</div>';
        }
    }

    function appendMessage(m) {
        const wrapper = document.createElement('div');
        wrapper.className = m.role === 'bot' ? 'bg-quaternary text-gray-800 p-4 rounded-2xl' : 'bg-primary text-white p-4 rounded-2xl self-end';
        wrapper.innerHTML = '<div class="text-sm">' + escapeHtml(m.message) + '</div>' + '<div class="text-xs text-gray-400 mt-2">' + (new Date(m.created_at).toLocaleString()) + '</div>';
        chatContainer.appendChild(wrapper);
    }

    function escapeHtml(unsafe) {
        return unsafe
             .replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/\"/g, "&quot;")
             .replace(/'/g, "&#039;");
    }

    chatForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        // Optimistic UI: append user message
        const userMsg = { role: 'user', message: message, created_at: new Date().toISOString() };
        appendMessage(userMsg);
        chatInput.value = '';
        chatContainer.scrollTop = chatContainer.scrollHeight;

        try {
            const res = await fetch("{{ route('api.chat.send') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ message })
            });

            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                throw new Error(err.error || 'Gagal menghubungi AI');
            }

            const data = await res.json();
            if (data.bot) {
                appendMessage({ role: 'bot', message: data.bot.message, created_at: data.bot.created_at });
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        } catch (err) {
            appendMessage({ role: 'bot', message: 'Terjadi kesalahan: ' + (err.message || 'Error'), created_at: new Date().toISOString() });
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });

    // Auto-load chat history when page loads (since panel is always visible)
    if (document.getElementById('chat-container')) {
        console.log('Chat container found - loading history automatically');
        loadHistory();
    } else {
        console.log('Chat container not found');
    }
});
</script>
@endpush