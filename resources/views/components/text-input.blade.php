@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-4 focus:ring-primary/20 focus:outline-none transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white disabled:opacity-50 disabled:cursor-not-allowed']) }}>
