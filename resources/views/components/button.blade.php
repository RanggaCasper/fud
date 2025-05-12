@props([
    'label' => null, 
    'color' => null, // Allow custom color
    'size' => 'md', 
    'isDisabled' => false, 
    'type' => 'button'  // Type can be "submit", "reset", etc.
])

@php
    // Determine color based on button type, with a fallback for custom color
    $colorClasses = match($color ?: $type) {
        'primary' => 'btn-primary',  // Default to primary for submit
        'danger' => 'btn-danger',    // Default to danger for reset
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'light' => 'btn-light',
        'dark' => 'btn-dark',
        'secondary' => 'btn-secondary',
        default => $type === 'reset' ? 'btn-danger' : 'btn-primary', // Default to primary for submit and danger for reset
    };

    // Size classes based on the selected size
    $sizeClasses = match($size) {
        'sm' => 'text-xs px-3 py-1.5',
        'md' => 'text-sm px-5 py-2.5',
        'lg' => 'text-lg px-6 py-3',
        default => 'text-sm px-5 py-2.5',
    };

    // Disabled classes if the button is disabled
    $disabledClasses = $isDisabled ? 'opacity-50 cursor-not-allowed' : '';
@endphp

<button type="{{ $type }}" 
        class="btn {{ $sizeClasses }} {{ $colorClasses }} {{ $disabledClasses }}" 
        {{ $isDisabled ? 'disabled' : '' }} 
        {{ $attributes }}>
    @if($label)
        {{ $label }}
    @else
        {{ $slot }}
    @endif
</button>
