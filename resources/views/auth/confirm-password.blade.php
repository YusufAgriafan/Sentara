<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-6">
        <div class="mx-auto w-16 h-16 bg-quaternary rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-quaternary/20">
            <i class="fas fa-shield-alt text-gray-700 text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Konfirmasi Password</h2>
        <p class="text-gray-600">Masukkan password untuk melanjutkan</p>
    </div>

    <!-- Security Notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6">
        <div class="flex items-start space-x-3">
            <i class="fas fa-exclamation-triangle text-amber-500 text-lg mt-0.5"></i>
            <div class="text-sm text-amber-700">
                <p class="font-semibold mb-1">Area Aman</p>
                <p>Ini adalah area aman aplikasi. Silakan konfirmasi password kamu untuk melanjutkan.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <x-text-input id="password" class="" type="password" name="password"
                    required autocomplete="current-password" placeholder="Masukkan password kamu" />
                <button type="button" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    onclick="togglePassword()">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <x-primary-button>
                <i class="fas fa-check mr-2"></i>
                {{ __('Konfirmasi') }}
            </x-primary-button>
        </div>

        <!-- Cancel Link -->
        <div class="text-center pt-6 border-t border-gray-100">
            <a href="{{ url()->previous() }}" 
               class="text-gray-600 hover:text-gray-800 transition-colors duration-200 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
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
