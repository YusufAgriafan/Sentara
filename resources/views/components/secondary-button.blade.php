<button {{ $attributes->merge(['type' => 'button', 'class' => 'w-full inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-200 rounded-2xl font-semibold text-sm text-gray-700 tracking-wide shadow-sm hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200/50 disabled:opacity-50 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]']) }}>
    {{ $slot }}
</button>
