@extends('layouts.educator')

@section('page-title', 'Pengaturan Profil')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8">
            <div class="flex items-center space-x-4">
                <div class="h-20 w-20 rounded-full bg-white flex items-center justify-center shadow-lg">
                    <span class="text-2xl font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-blue-100">Pengajar</p>
                    <p class="text-blue-100 text-sm">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-user-edit mr-2 text-blue-600"></i>
                Informasi Profil
            </h3>
            <p class="text-sm text-gray-600 mt-1">Perbarui informasi profil dan alamat email akun Anda.</p>
        </div>

        <form method="POST" action="{{ route('educator.profile.update') }}" class="p-6 space-y-6">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $user->name) }}" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('name') border-red-500 @enderror"
                    placeholder="Masukkan nama lengkap Anda"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $user->email) }}" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('email') border-red-500 @enderror"
                    placeholder="Masukkan alamat email Anda"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            Alamat email Anda belum diverifikasi.
                            <button form="send-verification" class="underline text-yellow-600 hover:text-yellow-800 transition-colors duration-200">
                                Klik di sini untuk mengirim ulang email verifikasi.
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm text-green-600">
                                Link verifikasi baru telah dikirim ke alamat email Anda.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
                >
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-lock mr-2 text-blue-600"></i>
                Perbarui Kata Sandi
            </h3>
            <p class="text-sm text-gray-600 mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>
        </div>

        <form method="POST" action="{{ route('educator.profile.update') }}" class="p-6 space-y-6">
            @csrf
            @method('PATCH')

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('current_password') border-red-500 @enderror"
                    placeholder="Masukkan kata sandi saat ini"
                >
                @error('current_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Baru</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200 @error('password') border-red-500 @enderror"
                    placeholder="Masukkan kata sandi baru"
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200"
                    placeholder="Konfirmasi kata sandi baru"
                >
            </div>

            <div class="flex items-center justify-end">
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg font-medium hover:from-green-700 hover:to-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
                >
                    <i class="fas fa-key mr-2"></i>
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>

    <!-- Account Statistics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                Informasi Akun
            </h3>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Anggota Sejak</h4>
                    <p class="text-sm text-gray-600">{{ $user->created_at->locale('id')->translatedFormat('j F Y') }}</p>
                </div>

                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="h-12 w-12 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-shield-check text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Status Akun</h4>
                    <p class="text-sm text-gray-600">
                        @if($user->email_verified_at)
                            <span class="text-green-600 font-medium">Terverifikasi</span>
                        @else
                            <span class="text-yellow-600 font-medium">Menunggu Verifikasi</span>
                        @endif
                    </p>
                </div>

                <div class="text-center p-4 bg-indigo-50 rounded-lg">
                    <div class="h-12 w-12 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user-tag text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Peran</h4>
                    <p class="text-sm text-gray-600 capitalize">{{ $user->role }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
@endif
@endsection
