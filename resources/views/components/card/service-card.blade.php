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
    $cardClasses = $isClosed ? 'bg-gray-100 pointer-events-none' : 'bg-white';
    $imageClasses = $isClosed ? 'filter' : '';
    $textColor = $isClosed ? 'text-gray-500' : 'text-dark';
@endphp

<div data-aos="zoom-in-up" class="rounded-lg shadow-md transition-all {{ $cardClasses }}">
    <div class="p-3 relative rounded-lg">
        <div class="mb-2 relative">
            <a href="{{ $isClosed ? '#' : '/detail' }}" class="relative block">
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
                <a href="{{ $isClosed ? '#' : '/detail' }}"
                   class="text-lg font-bold mb-2 line-clamp-1 cursor-pointer hover:text-primary {{ $textColor }}">
                    {{ $title }}
                </a>
            </div>
            <div>
                <span class="inline-block px-3 py-1 text-xs rounded-lg bg-gray-200/50">
                    <div class="flex items-center justify-center gap-0.5">
                        <svg class="size-3 text-warning" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                        </svg>
                        <span class="text-sm">{{ $rating }}</span>
                        <span class="flex-grow h-3 mx-0.5 border-r-[1px] border-dark/25"></span>
                        <span class="text-sm">{{ $reviews }}</span>
                    </div>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm {{ $textColor }}">
            <div class="flex items-center">
                <span class="line-clamp-1">{{ $location }}</span>
            </div>
            
            <div class="flex items-center justify-end gap-1">
                <span>{{ $distance }}</span>
                <span>{{ $score }}</span>
            </div>
        </div>
    </div>
</div>
