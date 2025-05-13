@props([
    'label' => null, 
    'color' => null, 
    'size' => 'md', 
    'class' => '', 
    'isDisabled' => false, 
    'type' => 'button', 
    'outline' => false
])

@php
    $colorClasses = match($color ?: $type) {
        'primary' => $outline ? 'btn-outline-primary' : 'btn-primary',
        'danger' => $outline ? 'btn-outline-danger' : 'btn-danger',
        'success' => $outline ? 'btn-outline-success' : 'btn-success',
        'warning' => $outline ? 'btn-outline-warning' : 'btn-warning',
        'info' => $outline ? 'btn-outline-info' : 'btn-info',
        'light' => $outline ? 'btn-outline-light' : 'btn-light',
        'dark' => $outline ? 'btn-outline-dark' : 'btn-dark',
        'secondary' => $outline ? 'btn-outline-secondary' : 'btn-secondary',
        default => $type === 'reset' ? ($outline ? 'btn-outline-danger' : 'btn-danger') : ($outline ? 'btn-outline-primary' : 'btn-primary'),
    };

    $sizeClasses = match($size) {
        'sm' => 'btn-sm',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
        default => 'btn-md',
    };

    $disabledClasses = $isDisabled ? 'opacity-50 cursor-not-allowed' : '';
@endphp

<button type="{{ $type }}" 
        class="btn {{ $sizeClasses }} {{ $colorClasses }} {{ $disabledClasses }} {{ $class }}"
        {{ $isDisabled ? 'disabled' : '' }} 
        {{ $attributes }}>
    @if($label)
        {{ $label }}
    @else
        {{ $slot }}
    @endif
</button>
