@props([
    'image' => 'https://placehold.co/100x100',
    'title' => null,
    'slug' => null,
    'rating' => null,
    'address' => null,
    'isClosed' => false,
    'isHalal' => true,
])

@php
    $textColor = $isClosed ? 'text-gray-400' : 'text-gray-800';
@endphp

<a href="{{ route('restaurant.index', ['slug' => $slug]) }}"
    class="flex bg-white gap-3 items-center hover:bg-gray-100 py-3 ps-3 shadow-md rounded-lg transition-all group">
    <div class="relative shrink-0">
        <img src="{{ $image }}" class="w-20 h-20 object-cover rounded-lg" alt="{{ $title }}">
        @if ($isClosed)
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-lg"></div>
            <div class="absolute top-0 left-0 bg-danger text-white text-xxs px-1 py-0.5 rounded-tl-lg rounded-br-lg">
                Closed</div>
        @endif
        @if ($isHalal)
            <div class="absolute bottom-2 right-0">
                <img src="https://taucocapmeong.com/assets/img/logo_halal.png" class="w-6 h-6 object-contain"
                    alt="Logo Halal">
            </div>
        @endif
    </div>
    <div class="flex-1 min-w-0">
        <div class="flex justify-between items-center mb-1">
            <h4 class="text-sm font-semibold group-hover:text-primary line-clamp-1 {{ $textColor }}">{{ $title }}</h4>
            @if ($rating)
                <div>
                    <span class="inline-block px-3 py-1 text-xs rounded-s-lg bg-primary text-white font-semibold">
                        <div class="flex items-center justify-center gap-0.5">
                            <i class="ti ti-star-filled text-warning"></i>
                            <span class="text-xs">{{ $rating }}</span>
                        </div>
                    </span>
                </div>
            @endif
        </div>
        <div class="text-xs text-gray-500 flex justify-between">
            @if ($address)
                <div class="flex items-center gap-1">
                    <i class="ti ti-location"></i>
                    <span class="line-clamp-1">{{ $address }}</span>
                </div>
            @endif
        </div>
    </div>
</a>
