@props(['color' => 'primary'])

@php
    $classes = match ($color) {
        'warning' => 'bg-warning text-white',
        'success' => 'bg-success text-white',
        'danger'  => 'bg-danger text-white',
        default   => 'bg-gray-100 text-gray-800',
    };
@endphp

<span {{ $attributes->merge(['class' => "px-2 py-1 text-xs font-medium rounded-lg inline-block $classes"]) }}>
    {{ $slot }}
</span>
