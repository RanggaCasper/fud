@forelse ($restaurants as $restaurant)
    <div class="col-span-1">
        <x-card.restaurant-card
            :title="$restaurant->name"
            :slug="Str::slug($restaurant->name)"
            :rating="$restaurant->rating"
            :reviews="$restaurant->reviews"
            :location="$restaurant->address"
            :distance="$restaurant->distance . 'km'"
            :image="$restaurant->thumbnail"
            :isPromotion="false"
            :isClosed="$restaurant->isClosed()"
            :isHalal="($restaurant->offerings->contains(function ($offering) {
                return str_contains(strtolower($offering->name), 'halal');
            }))"
        />
    </div>
@empty
    <div class="col-span-full text-center py-8 empty-restaurant">
        <div class="flex justify-center items-center flex-col">
            <img src="{{ asset('assets/svg/undraw_empty_4zx0.svg') }}" class="size-64" alt="Empty">
            <p class="font-semibold">No restaurants found.</p>
        </div>
    </div>
@endforelse
