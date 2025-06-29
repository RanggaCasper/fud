<div class="p-4 bg-white rounded-lg" {{ $attributes }}>
    @isset($title)
    <div class="mb-3 border-b border-gray-200">
        <div class="flex items-center gap-2">
            <div class="h-4 w-[0.2rem] rounded-full bg-gradient-to-b from-primary to-secosndary">
            </div>
            <h5 class="text-lg font-semibold text-black">{{ $title }}</h5>
        </div>
    </div>
    @endisset
    {{ $slot }}
</div>
