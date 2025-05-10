@props(['color' => 'primary', 'size' => 'md', 'href' => '#'])

<a href="{{ $href }}" class="inline-block px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase rounded shadow-md transition duration-150 ease-in-out 
    {{ 
        $color === 'primary' ? 'bg-primary hover:bg-primary focus:ring-primary' : 
        ($color === 'secondary' ? 'bg-secondary hover:bg-secondary focus:ring-secondary' : 
        ($color === 'success' ? 'bg-success hover:bg-success focus:ring-success' :
        ($color === 'warning' ? 'bg-warning hover:bg-warning focus:ring-warning' :
        'bg-danger hover:bg-danger focus:ring-danger')))
    }}
    {{ 
        $size === 'sm' ? 'text-sm' : 
        ($size === 'lg' ? 'text-lg px-8 py-3' : 'text-base px-6 py-2.5')
    }} 
    focus:outline-none focus:ring-2 focus:ring-offset-2">
    {{ $slot }}
</a>
