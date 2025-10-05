<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-10">
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
            Selamat Datang Kembali! 👋
        </h2>
        <p class="text-gray-600 text-lg">Masuk ke akun Anda dan mulai petualangan sejarah</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-8">
        @csrf

        <!-- Email Address -->
        <div class="space-y-3">
            <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-800 font-semibold text-lg" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400 text-lg"></i>
                </div>
                <x-text-input id="email" 
                    class="pl-14 pr-4 py-4 w-full border-2 border-quaternary rounded-2xl focus:border-primary focus:ring-0 transition-all duration-200 bg-white text-lg placeholder-gray-400" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="contoh@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-3">
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-gray-800 font-semibold text-lg" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400 text-lg"></i>
                </div>
                <x-text-input id="password" 
                    class="pl-14 pr-14 py-4 w-full border-2 border-quaternary rounded-2xl focus:border-primary focus:ring-0 transition-all duration-200 bg-white text-lg placeholder-gray-400" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    placeholder="Masukkan kata sandi Anda" />
                <button type="button" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors duration-200 p-2"
                    onclick="togglePassword()">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" 
                    class="rounded-lg border-2 border-quaternary text-primary focus:ring-primary/20 focus:ring-4 transition-all duration-200 w-5 h-5" 
                    name="remember">
                <span class="ml-3 text-gray-700 font-medium group-hover:text-primary transition-colors duration-200">
                    Ingat saya
                </span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-primary hover:text-primary/80 transition-colors duration-200 font-medium inline-flex items-center group" 
                   href="{{ route('password.request') }}">
                    <i class="fas fa-key text-sm mr-2 group-hover:rotate-12 transition-transform duration-200"></i>
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="btn-hover w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-200 flex items-center justify-center group shadow-lg hover:shadow-xl text-lg">
                <i class="fas fa-sign-in-alt mr-3 group-hover:translate-x-1 transition-transform duration-200"></i>
                Masuk
            </button>
        </div>

        <!-- Register Link -->
        <div class="pt-6">
            <div class="text-center p-6 bg-quaternary/50 rounded-2xl">
                <p class="text-gray-600 text-lg mb-4">Belum punya akun?</p>
                <a href="{{ route('register') }}" 
                   class="btn-hover inline-flex items-center px-6 py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-xl transition-all duration-200 group">
                    <i class="fas fa-user-plus mr-2 group-hover:rotate-12 transition-transform duration-200"></i>
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </form>

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
    </script>
</x-guest-layout>
