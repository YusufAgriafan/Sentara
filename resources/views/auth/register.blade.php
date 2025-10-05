<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-10">
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
            Bergabung dengan Sentara! 🎉
        </h2>
        <p class="text-gray-600 text-lg">Mulai petualangan sejarah Indonesia-mu sekarang</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-8">
        @csrf

        <!-- Name -->
        <div class="space-y-3">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-800 font-semibold text-lg" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400 text-lg"></i>
                </div>
                <x-text-input id="name" 
                    class="pl-14 pr-4 py-4 w-full border-2 border-quaternary rounded-2xl focus:border-primary focus:ring-0 transition-all duration-200 bg-white text-lg placeholder-gray-400" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    autocomplete="name" 
                    placeholder="Masukkan nama lengkap Anda" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                    autocomplete="username" 
                    placeholder="contoh@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="space-y-3">
            <x-input-label for="role" :value="__('Daftar Sebagai')" class="text-gray-800 font-semibold text-lg" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-graduation-cap text-gray-400 text-lg"></i>
                </div>
                <select id="role" name="role" required 
                    class="pl-14 pr-4 py-4 w-full border-2 border-quaternary rounded-2xl focus:border-primary focus:ring-0 transition-all duration-200 bg-white text-lg">
                    <option value="">Pilih peran Anda</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>
                        👨‍🎓 Siswa - Belajar sejarah Indonesia
                    </option>
                    <option value="educator" {{ old('role') == 'educator' ? 'selected' : '' }}>
                        👩‍🏫 Guru - Mengajar dan membimbing siswa
                    </option>
                </select>
            </div>
            <div class="bg-tertiary/30 rounded-xl p-3">
                <p class="text-sm text-gray-600">💡 Pilih sesuai dengan peran Anda di platform pembelajaran ini</p>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
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
                    autocomplete="new-password" 
                    placeholder="Buat kata sandi yang kuat" />
                <button type="button" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors duration-200 p-2"
                    onclick="togglePassword('password', 'password-icon')">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            <div class="bg-secondary/50 rounded-xl p-3">
                <p class="text-sm text-gray-600">🔒 Kata sandi harus minimal 8 karakter dengan kombinasi huruf dan angka</p>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-3">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-gray-800 font-semibold text-lg" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-lock-open text-gray-400 text-lg"></i>
                </div>
                <x-text-input id="password_confirmation" 
                    class="pl-14 pr-14 py-4 w-full border-2 border-quaternary rounded-2xl focus:border-primary focus:ring-0 transition-all duration-200 bg-white text-lg placeholder-gray-400" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password" 
                    placeholder="Ulangi kata sandi Anda" />
                <button type="button" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors duration-200 p-2"
                    onclick="togglePassword('password_confirmation', 'password-confirm-icon')">
                    <i class="fas fa-eye" id="password-confirm-icon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms Agreement -->
        <div class="bg-quaternary/50 rounded-2xl p-6">
            <label for="terms" class="inline-flex items-start cursor-pointer">
                <input id="terms" type="checkbox" required
                    class="mt-1 rounded-lg border-2 border-quaternary text-primary focus:ring-primary/20 focus:ring-4 transition-all duration-200 w-5 h-5">
                <span class="ml-3 text-gray-700 leading-relaxed">
                    Saya menyetujui 
                    <a href="#" class="text-primary hover:text-primary/80 transition-colors duration-200 font-semibold underline decoration-dotted">
                        Syarat & Ketentuan
                    </a> 
                    dan 
                    <a href="#" class="text-primary hover:text-primary/80 transition-colors duration-200 font-semibold underline decoration-dotted">
                        Kebijakan Privasi
                    </a> 
                    dari Sentara
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="btn-hover w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-200 flex items-center justify-center group shadow-lg hover:shadow-xl text-lg">
                <i class="fas fa-user-plus mr-3 group-hover:rotate-12 transition-transform duration-200"></i>
                Daftar Sekarang
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-6">
            <div class="bg-quaternary/50 rounded-2xl p-6">
                <p class="text-gray-600 text-lg mb-4">
                    Sudah punya akun? 
                </p>
                <a href="{{ route('login') }}" 
                   class="btn-hover inline-flex items-center px-6 py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-xl transition-all duration-200 group">
                    <i class="fas fa-sign-in-alt mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    Masuk di sini
                </a>
            </div>
        </div>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
            
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

        // Real-time password validation
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            // Add visual feedback for password strength
            if (password.length >= 8 && /(?=.*[a-zA-Z])(?=.*\d)/.test(password)) {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
            } else if (password.length > 0) {
                this.classList.remove('border-green-300');
                this.classList.add('border-red-300');
            } else {
                this.classList.remove('border-red-300', 'border-green-300');
            }
            
            // Check password confirmation match
            if (confirmPassword && password !== confirmPassword) {
                document.getElementById('password_confirmation').classList.add('border-red-300');
                document.getElementById('password_confirmation').classList.remove('border-green-300');
            } else if (confirmPassword && password === confirmPassword) {
                document.getElementById('password_confirmation').classList.remove('border-red-300');
                document.getElementById('password_confirmation').classList.add('border-green-300');
            }
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword && confirmPassword.length > 0) {
                this.classList.add('border-red-300');
                this.classList.remove('border-green-300');
            } else if (password === confirmPassword && confirmPassword.length > 0) {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
            } else {
                this.classList.remove('border-red-300', 'border-green-300');
            }
        });
    </script>
</x-guest-layout>
