@foreach ($restaurants as $restaurant)
    <div class="col-span-1">
        <x-card.mini-restaurant-card
            :image="$restaurant->thumbnail"
            :title="$restaurant->name"
            :slug="$restaurant->slug"
            :rating="$restaurant->rating"
            :address="$restaurant->address"
            :isClosed="$restaurant->isClosed()"
            :isHalal="$restaurant->offerings->contains(fn($o) => str_contains(strtolower($o->name), 'halal'))"
        />
    </div>
@endforeach