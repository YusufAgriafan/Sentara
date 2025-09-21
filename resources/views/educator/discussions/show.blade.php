@extends('layouts.educator')

@section('page-title', 'Detail Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $discussion->name }}</h1>
                <p class="text-gray-600 mt-1">Kelas: {{ $discussion->class->name ?? 'N/A' }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('educator.discussions.edit', $discussion) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('educator.discussions.index') }}" 
                   class="text-gray-600 hover:text-gray-800 font-medium py-2 px-4 border border-gray-300 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Discussion Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Diskusi</h3>
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed">{{ $discussion->class_discussion_message }}</p>
            </div>
            <div class="flex items-center text-sm text-gray-500 mt-4">
                <i class="fas fa-clock mr-2"></i>
                Dibuat: {{ $discussion->created_at->format('d M Y, H:i') }}
                <span class="mx-3">•</span>
                <i class="fas fa-user mr-2"></i>
                Oleh: {{ $discussion->educator->name }}
            </div>
        </div>

        <!-- Messages Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-comments mr-2"></i>Pesan & Balasan
            </h3>

            @if($messages->where('student_id', '!=', null)->count() > 0)
                <div class="space-y-4">
                    @foreach($messages->where('student_id', '!=', null) as $message)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <!-- Student Message -->
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $message->student->name ?? 'Siswa' }}</p>
                                        <p class="text-sm text-gray-500">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="ml-11">
                                    <p class="text-gray-700 leading-relaxed">{{ $message->message }}</p>
                                </div>
                            </div>

                            <!-- Educator Reply -->
                            @if($message->reply)
                                <div class="ml-8 border-l-4 border-green-200 pl-4">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-chalkboard-teacher text-green-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $discussion->educator->name }}</p>
                                            <p class="text-sm text-gray-500">Balasan</p>
                                        </div>
                                    </div>
                                    <div class="ml-11">
                                        <p class="text-gray-700 leading-relaxed">{{ $message->reply }}</p>
                                    </div>
                                </div>
                            @else
                                <!-- Reply Form -->
                                <div class="ml-8 border-l-4 border-blue-200 pl-4">
                                    <form action="{{ route('educator.discussions.reply', $message) }}" method="POST">
                                        @csrf
                                        <div class="space-y-3">
                                            <label class="block text-sm font-medium text-gray-700">
                                                Balas pesan siswa:
                                            </label>
                                            <textarea name="reply" 
                                                      rows="3"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                      placeholder="Tulis balasan Anda..."></textarea>
                                            <button type="submit" 
                                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                                <i class="fas fa-reply mr-2"></i>Kirim Balasan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-comment-slash text-4xl"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-600 mb-2">Belum Ada Pesan</h4>
                    <p class="text-gray-500">Menunggu siswa untuk memulai diskusi.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Discussion Stats -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-chart-bar mr-2"></i>Statistik Diskusi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-comments text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-blue-900">{{ $messages->where('student_id', '!=', null)->count() }}</p>
                        <p class="text-blue-700 text-sm">Total Pesan</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-reply text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-900">{{ $messages->where('reply', '!=', null)->count() }}</p>
                        <p class="text-green-700 text-sm">Balasan Diberikan</p>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-yellow-900">{{ $messages->where('student_id', '!=', null)->unique('student_id')->count() }}</p>
                        <p class="text-yellow-700 text-sm">Siswa Berpartisipasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif
@endsection