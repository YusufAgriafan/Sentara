<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex items-center justify-center px-6 py-3 bg-primary border border-transparent rounded-2xl font-semibold text-sm text-white tracking-wide hover:bg-secondary focus:bg-secondary active:bg-primary focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-primary/25']) }}>
    {{ $slot }}
</button>
