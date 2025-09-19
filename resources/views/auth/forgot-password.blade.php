<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-6">
        <div class="mx-auto w-16 h-16 bg-tertiary rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-tertiary/20">
            <i class="fas fa-key text-white text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Lupa Password?</h2>
        <p class="text-gray-600">Jangan khawatir! Kami akan kirimkan link reset ke email kamu</p>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-6">
        <div class="flex items-start space-x-3">
            <i class="fas fa-info-circle text-blue-500 text-lg mt-0.5"></i>
            <div class="text-sm text-blue-700">
                <p class="font-semibold mb-1">Cara reset password:</p>
                <ol class="list-decimal list-inside space-y-1 text-blue-600">
                    <li>Masukkan email yang terdaftar</li>
                    <li>Cek email untuk link reset password</li>
                    <li>Klik link dan buat password baru</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" 
                required autofocus placeholder="Masukkan email yang terdaftar" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <x-primary-button>
                <i class="fas fa-paper-plane mr-2"></i>
                {{ __('Kirim Link Reset Password') }}
            </x-primary-button>
        </div>

        <!-- Back to Login -->
        <div class="text-center pt-6 border-t border-gray-100">
            <p class="text-gray-600">
                Ingat password kamu? 
                <a href="{{ route('login') }}" 
                   class="text-primary hover:text-secondary transition-colors duration-200 font-semibold">
                    Kembali ke login
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
