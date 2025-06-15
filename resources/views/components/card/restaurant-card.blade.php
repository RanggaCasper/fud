@props([
    'image' => 'https://placehold.co/600x400',
    'title' => null,
    'slug' => null,
    'rating' => null,
    'reviews' => null,
    'location' => null,
    'distance' => null,
    'isPromotion' => true,
    'isClosed' => true,
    'isHalal' => true,
    'score' => null,
])

@php
    $cardClasses = $isClosed ? 'bg-gray-100' : 'bg-white';
    $imageClasses = $isClosed ? 'filter' : '';
    $textColor = $isClosed ? 'text-gray-500' : 'text-dark';
@endphp

<div data-aos="zoom-in-up" class="rounded-lg shadow-md transition-all {{ $cardClasses }}">
    <div class="p-3 relative rounded-lg">
        <div class="mb-2 relative">
            <a href="{{ route('restaurant.index', ['slug' => $slug]) }}" class="relative block">
                <img data-src="{{ $image }}" loading="lazy"
                     class="lazyload h-56 w-full object-cover rounded-lg transition-all {{ $imageClasses }}"
                     alt="{{ $title }}">

                <!-- Overlay gradient -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-16 rounded-b-lg"></div>

                <!-- Closed Full Overlay -->
                @if ($isClosed)
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-lg">
                    </div>
                    <div class="absolute top-0 left-0 bg-danger px-3 pt-0.5 pb-1 text-xs rounded-tl-lg rounded-br-lg text-white font-semibold">
                        Closed
                    </div>
                @endif

                @if($isPromotion)
                    <div class="absolute bottom-2 left-2">
                        <h5 class="font-semibold text-white shadow-sm text-sm">Ad</h5>
                    </div>
                @endif

                @if($isHalal)
                    <div class="absolute bottom-2 right-0">
                        <img src="https://taucocapmeong.com/assets/img/logo_halal.png"
                             class="w-12 h-12 object-contain" alt="Logo Halal">
                    </div>
                @endif
            </a>
        </div>

        <div class="flex items-start justify-between">
            <div>
                <a href="{{ route('restaurant.index', ['slug' => $slug]) }}"
                   class="text-lg font-bold mb-2 line-clamp-1 cursor-pointer hover:text-primary {{ $textColor }}">
                    {{ $title }}
                </a>
            </div>
            <div>
                <span class="inline-block px-3 py-1 text-xs rounded-lg bg-primary text-white font-semibold">
                    <div class="flex items-center justify-center gap-0.5">
                        <i class="ti ti-star-filled text-warning"></i>
                        <span class="text-xs">{{ $rating }}</span>
                    </div>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm {{ $textColor }}">
            <div class="flex items-center text-secondary">
                <span class="h-3 mx-0.5 border-r-2 border-secondary"></span><span>{{ $distance }}</span>
            </div>
            
            <div class="flex items-center text-secondary justify-end gap-1">
                <span>{{ $reviews }}</span>
                Reviews
            </div>
        </div>
    </div>
</div>
