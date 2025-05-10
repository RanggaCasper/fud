<div class="max-w-lg mx-auto px-4 py-3 rounded-lg 
    {{ $type === 'success' ? 'bg-success text-white' : 
        ($type === 'error' ? 'bg-danger text-white' : 
        ($type === 'info' ? 'bg-info text-white' : 
        'bg-warning text-white')) }}
    border border-dark">
    <strong class="font-semibold">{{ ucfirst($type) }}!</strong> 
    {{ $message }}
</div>
<!