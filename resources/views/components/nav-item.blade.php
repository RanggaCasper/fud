@props([
    'href',
    'icon' => 'ri-dashboard-line',
    'active' => false,
])

<li>
    <a href="{{ $href }}"
       class="flex items-center p-2 rounded-lg text-muted hover:bg-primary hover:text-white gap-2 group {{ $active ? 'bg-primary text-white' : '' }}">
        <i class="ri {{ $icon }} text-xl"></i>
        <span>{{ $slot }}</span>
    </a>
</li>