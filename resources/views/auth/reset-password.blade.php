<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-6">
        <div class="mx-auto w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-secondary/20">
            <i class="fas fa-lock-open text-white text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Reset Password</h2>
        <p class="text-gray-600">Buat password baru untuk akun kamu</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1" type="email" name="email" 
                :value="old('email', $request->email)" required autofocus autocomplete="username" 
                placeholder="Email kamu" readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password Baru')" />
            <div class="relative mt-1">
                <x-text-input id="password" class="" type="password" name="password" 
                    required autocomplete="new-password" placeholder="Buat password baru yang kuat" />
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
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
            <div class="relative mt-1">
                <x-text-input id="password_confirmation" class="" type="password" 
                    name="password_confirmation" required autocomplete="new-password" 
                    placeholder="Ulangi password baru kamu" />
                <button type="button" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    onclick="togglePassword('password_confirmation', 'password-confirm-icon')">
                    <i class="fas fa-eye" id="password-confirm-icon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <x-primary-button>
                <i class="fas fa-check-circle mr-2"></i>
                {{ __('Reset Password') }}
            </x-primary-button>
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
