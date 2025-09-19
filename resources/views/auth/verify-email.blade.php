<x-guest-layout>
    <!-- Page Title -->
    <div class="text-center mb-6">
        <div class="mx-auto w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/20">
            <i class="fas fa-envelope-circle-check text-white text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Email</h2>
        <p class="text-gray-600">Cek email kamu untuk melanjutkan</p>
    </div>

    <!-- Verification Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-6">
        <div class="flex items-start space-x-3">
            <i class="fas fa-info-circle text-blue-500 text-lg mt-0.5"></i>
            <div class="text-sm text-blue-700">
                <p class="font-semibold mb-2">Terima kasih sudah mendaftar!</p>
                <p class="mb-3">Sebelum memulai, silakan verifikasi alamat email kamu dengan mengklik link yang sudah kami kirimkan.</p>
                <div class="bg-blue-100 rounded-xl p-3">
                    <p class="font-medium text-blue-800">💡 Tips:</p>
                    <ul class="mt-1 text-blue-700 text-xs space-y-1">
                        <li>• Cek folder spam/junk jika tidak ada di inbox</li>
                        <li>• Link berlaku selama 24 jam</li>
                        <li>• Pastikan email yang dimasukkan benar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-6">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                <div class="text-sm text-green-700">
                    <p class="font-semibold">Email verifikasi terkirim!</p>
                    <p>Link verifikasi baru sudah dikirim ke alamat email yang kamu daftarkan.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-4">
        <!-- Resend Email Button -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                <i class="fas fa-paper-plane mr-2"></i>
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-secondary-button type="submit">
                <i class="fas fa-sign-out-alt mr-2"></i>
                {{ __('Keluar') }}
            </x-secondary-button>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500 mb-3">Butuh bantuan?</p>
        <div class="flex justify-center space-x-4 text-sm">
            <a href="#" class="text-primary hover:text-secondary transition-colors duration-200 font-medium">
                <i class="fas fa-question-circle mr-1"></i>
                FAQ
            </a>
            <a href="#" class="text-primary hover:text-secondary transition-colors duration-200 font-medium">
                <i class="fas fa-envelope mr-1"></i>
                Kontak Support
            </a>
        </div>
    </div>

    <!-- Progress Animation -->
    <div class="mt-8">
        <div class="text-center text-xs text-gray-400 mb-2">Menunggu verifikasi email...</div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-gradient-to-r from-primary to-secondary h-2 rounded-full animate-pulse" style="width: 60%"></div>
        </div>
    </div>
</x-guest-layout>
