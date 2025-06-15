@props([
    'href',
    'icon' => 'ri-dashboard-line',
    'active' => false,
    'lordIcon' => '',
    'class' => '',
])

<li>
    <a href="{{ $href }}"
        class="flex items-center font-semibold text-sm px-4 py-2.5 rounded-lg border-s-4 border-transparent hover:border-primary hover:bg-dark/10 focus:!text-primary focus:border-primary focus:bg-dark/10 hover:!text-primary gap-2 {{ $class }} {{ $active ? 'border-s-4 !border-primary bg-primary/10 !text-primary' : '' }}">
            <i class="{{ $icon }} text-xl"></i>
            {{ $slot }}
    </a>
</li>