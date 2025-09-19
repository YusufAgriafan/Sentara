<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex items-center justify-center px-6 py-3 bg-red-500 border border-transparent rounded-2xl font-semibold text-sm text-white tracking-wide hover:bg-red-600 focus:bg-red-600 active:bg-red-500 focus:outline-none focus:ring-4 focus:ring-red-500/20 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-red-500/25']) }}>
    {{ $slot }}
</button>
