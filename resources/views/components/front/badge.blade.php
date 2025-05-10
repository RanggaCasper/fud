<span class="inline-block px-3 py-1 text-xs font-semibold rounded-full 
    {{ $color === 'green' ? 'bg-success text-white' : 
        ($color === 'red' ? 'bg-danger text-white' : 
        ($color === 'blue' ? 'bg-info text-white' : 'bg-warning text-white')) }}">
    {{ $slot }}
</span>