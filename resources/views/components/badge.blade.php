<span class="inline-block px-2 py-1 text-xxs font-semibold rounded-lg 
    {{ $color === 'success' ? 'bg-success text-white' : 
        ($color === 'danger' ? 'bg-danger text-white' : 
        ($color === 'ingfo' ? 'bg-info text-white' : 'bg-warning text-white')) }}">
    {{ $slot }}
</span>