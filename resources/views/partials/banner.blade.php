@php
    $carouselItems = App\Models\RestaurantAd::whereNotNull('image')
        ->whereNotNull('end_date')
        ->where('end_date', '>=', now())
        ->with('restaurant')
        ->latest()
        ->get()
        ->shuffle()
        ->map(function ($ad) {
            return [
                'src' => Storage::url($ad->image),
                'link' => route('restaurant.index', $ad->restaurant->slug) . '?source=ads-carousel',
            ];
        });
@endphp

<div class="swiper bannerSwiper">
    <div class="swiper-wrapper">
        @php
            $totalItems = $carouselItems->count();
            $placeholdersNeeded = max(0, 3 - $totalItems);
        @endphp

        @foreach ($carouselItems as $item)
            <div class="swiper-slide aspect-[37/10] w-full overflow-hidden rounded-xl">
                <a href="{{ $item['link'] ?? '#' }}">
                    <img src="{{ $item['src'] }}" alt="Banner" class="w-full h-full object-cover" />
                </a>
            </div>
        @endforeach

        @for ($i = 1; $i <= $placeholdersNeeded; $i++)
            <div class="swiper-slide aspect-[37/10] w-full overflow-hidden rounded-xl">
                <img src="{{ asset('assets/image/placeholder-banner.png') }}" alt="Placeholder {{ $i }}"
                    class="w-full h-full object-cover" />
            </div>
        @endfor
    </div>
    <div class="swiper-pagination"></div>
</div>
