<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-10">
        <div class="mx-auto w-20 h-20 bg-tertiary rounded-3xl flex items-center justify-center mb-6 shadow-lg">
            <i class="fas fa-key text-white text-3xl"></i>
        </div>
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
            Lupa Kata Sandi? 🔑
        </h2>
        <p class="text-gray-600 text-lg">Jangan khawatir! Kami akan kirimkan link reset ke email Anda</p>
    </div>

    <!-- Info Box -->
    <div class="bg-secondary/50 border border-secondary rounded-2xl p-6 mb-8">
        <div class="flex items-start space-x-4">
            <i class="fas fa-lightbulb text-primary text-2xl mt-1"></i>
            <div>
                <p class="font-semibold mb-3 text-gray-800">💡 Cara reset kata sandi:</p>
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li>Masukkan email yang terdaftar</li>
                    <li>Cek email untuk link reset kata sandi</li>
                    <li>Klik link dan buat kata sandi baru</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
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
                    placeholder="Masukkan email yang terdaftar" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="btn-hover w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-200 flex items-center justify-center group shadow-lg hover:shadow-xl text-lg">
                <i class="fas fa-paper-plane mr-3 group-hover:translate-x-1 transition-transform duration-200"></i>
                Kirim Link Reset Kata Sandi
            </button>
        </div>

        <!-- Back to Login -->
        <div class="text-center pt-6">
            <div class="bg-quaternary/50 rounded-2xl p-6">
                <p class="text-gray-600 text-lg mb-4">
                    Ingat kata sandi Anda? 
                </p>
                <a href="{{ route('login') }}" 
                   class="btn-hover inline-flex items-center px-6 py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-xl transition-all duration-200 group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
