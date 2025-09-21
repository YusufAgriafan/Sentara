<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Bergabung dengan Sentara</h2>
        <p class="text-gray-600">Mulai petualangan sejarah Indonesia-mu!</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="mt-1" type="text" name="name" :value="old('name')" 
                required autofocus autocomplete="name" placeholder="Masukkan nama lengkap kamu" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" 
                required autocomplete="username" placeholder="Masukkan email kamu" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div>
            <x-input-label for="role" :value="__('Daftar Sebagai')" />
            <select id="role" name="role" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Pilih peran kamu</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Siswa - Belajar sejarah Indonesia</option>
                <option value="educator" {{ old('role') == 'educator' ? 'selected' : '' }}>Guru - Mengajar dan membimbing siswa</option>
            </select>
            <div class="mt-2 text-xs text-gray-500">
                <p>Pilih sesuai dengan peran kamu di platform pembelajaran ini</p>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <x-text-input id="password" class="" type="password" name="password" 
                    required autocomplete="new-password" placeholder="Buat password yang kuat" />
                <button type="button" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    onclick="togglePassword('password', 'password-icon')">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            <div class="mt-2 text-xs text-gray-500">
                <p>Password harus minimal 8 karakter dengan kombinasi huruf dan angka</p>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <div class="relative mt-1">
                <x-text-input id="password_confirmation" class="" type="password" 
                    name="password_confirmation" required autocomplete="new-password" 
                    placeholder="Ulangi password kamu" />
                <button type="button" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    onclick="togglePassword('password_confirmation', 'password-confirm-icon')">
                    <i class="fas fa-eye" id="password-confirm-icon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms Agreement -->
        <div class="bg-quaternary/10 rounded-2xl p-4">
            <label for="terms" class="inline-flex items-start cursor-pointer">
                <input id="terms" type="checkbox" required
                    class="mt-1 rounded border-gray-300 text-primary shadow-sm focus:ring-primary/20 focus:ring-4 transition-all duration-200">
                <span class="ml-3 text-sm text-gray-700 leading-relaxed">
                    Saya menyetujui 
                    <a href="#" class="text-primary hover:text-secondary transition-colors duration-200 font-semibold">
                        Syarat & Ketentuan
                    </a> 
                    dan 
                    <a href="#" class="text-primary hover:text-secondary transition-colors duration-200 font-semibold">
                        Kebijakan Privasi
                    </a> 
                    dari Sentara
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <x-primary-button>
                <i class="fas fa-user-plus mr-2"></i>
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-6 border-t border-gray-100">
            <p class="text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" 
                   class="text-primary hover:text-secondary transition-colors duration-200 font-semibold">
                    Masuk di sini
                </a>
            </p>
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
            } else {
                this.classList.remove('border-green-300');
                this.classList.add('border-red-300');
            }
            
            // Check password confirmation match
            if (confirmPassword && password !== confirmPassword) {
                document.getElementById('password_confirmation').classList.add('border-red-300');
            } else if (confirmPassword) {
                document.getElementById('password_confirmation').classList.remove('border-red-300');
                document.getElementById('password_confirmation').classList.add('border-green-300');
            }
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.classList.add('border-red-300');
                this.classList.remove('border-green-300');
            } else {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
            }
        });
    </script>
</x-guest-layout>
