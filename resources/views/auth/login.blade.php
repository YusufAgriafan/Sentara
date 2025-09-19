<x-guest-layout>
    <!-- Page Title - Simplified for Split Layout -->
    <div class="text-center mb-8">
        <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">
            Selamat Datang Kembali
        </h2>
        <p class="text-gray-600">Masuk ke akun Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address with Enhanced Styling -->
        <div class="input-group group">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold mb-2 block" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-envelope input-icon text-gray-400 transition-all duration-300"></i>
                </div>
                <x-text-input id="email" 
                    class="pl-12 pr-4 py-3 w-full border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm hover:shadow-md" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="Masukkan email Anda" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password with Enhanced Styling -->
        <div class="input-group group">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold mb-2 block" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-lock input-icon text-gray-400 transition-all duration-300"></i>
                </div>
                <x-text-input id="password" 
                    class="pl-12 pr-14 py-3 w-full border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm hover:shadow-md" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    placeholder="Masukkan password Anda" />
                <button type="button" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-all duration-300 p-1 hover:scale-110"
                    onclick="togglePassword()">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password in Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" 
                    class="rounded border-2 border-gray-300 text-primary shadow-sm focus:ring-primary/30 focus:ring-4 transition-all duration-300 w-4 h-4" 
                    name="remember">
                <span class="ml-2 text-sm text-gray-700 font-medium group-hover:text-primary transition-colors duration-300">
                    Ingat saya
                </span>
            </label>

            @if (Route::has('password.request'))
                <div class="text-right sm:text-left">
                    <a class="text-sm text-primary hover:text-secondary transition-all duration-300 font-medium inline-flex items-center group" 
                       href="{{ route('password.request') }}">
                        <i class="fas fa-key text-xs mr-1 group-hover:rotate-12 transition-transform duration-300"></i>
                        Lupa password?
                    </a>
                </div>
            @endif
        </div>

        <!-- Enhanced Submit Button -->
        <div class="pt-2">
            <button type="submit" class="btn-primary w-full bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl shadow-lg flex items-center justify-center group relative overflow-hidden">
                <i class="fas fa-sign-in-alt mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                <span class="relative z-10">Masuk</span>
            </button>
        </div>

        <!-- Register Link with Card Style -->
        <div class="pt-6">
            <div class="text-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                <p class="text-gray-600 text-sm mb-3">Belum punya akun?</p>
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-4 py-2 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 text-sm group">
                    <i class="fas fa-user-plus mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </form>

    <!-- Compact Social Login -->
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">atau</span>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3">
            <button type="button" 
                class="group relative overflow-hidden inline-flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-700 hover:border-red-300 hover:bg-red-50 transition-all duration-300 transform hover:scale-105">
                <i class="fab fa-google text-red-500 mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="group-hover:text-red-600 transition-colors duration-300">Google</span>
            </button>
            <button type="button" 
                class="group relative overflow-hidden inline-flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-700 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 transform hover:scale-105">
                <i class="fab fa-facebook text-blue-600 mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="group-hover:text-blue-600 transition-colors duration-300">Facebook</span>
            </button>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Enhanced input interactions
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.parentElement.classList.remove('focused');
                    }
                });
                
                if (input.value) {
                    input.parentElement.parentElement.classList.add('focused');
                }
            });
        });
    </script>
</x-guest-layout>
