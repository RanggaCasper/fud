@forelse ($restaurants as $restaurant)
    <div class="col-span-1">
        <x-card.mini-restaurant-card 
            :image="$restaurant->thumbnail"
            :title="$restaurant->name"
            :slug="Str::slug($restaurant->name)"
            :rating="$restaurant->rating"
            :distance="$restaurant->distance . 'km'"
            :isClosed="$restaurant->isClosed()"
            :isHalal="$restaurant->offerings->contains(function ($offering) {
                return str_contains(strtolower($offering->name), 'halal');
            })" />
    </div>
@empty
    <div class="text-muted text-sm">
        <p>No restaurants found.</p>
    </div>
@endforelse
