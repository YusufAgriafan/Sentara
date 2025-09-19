@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-500 space-y-1 mt-2']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center space-x-2">
                <i class="fas fa-exclamation-circle text-xs"></i>
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
