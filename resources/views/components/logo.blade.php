@props([
    'class' => '',
])

<img src="{{ asset('assets/image/logo.png') }}" class="h-8 {{ $class }}" {{ $attributes }} alt="Logo">
