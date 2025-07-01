@php
    $recentIds = session('recently_viewed', []);
    $restaurants = collect();

    if (!empty($recentIds)) {
        $restaurants = \App\Models\Restaurant\Restaurant::with(['offerings'])
            ->whereIn('id', $recentIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $recentIds) . ')')
            ->take(5)
            ->get();
    }
@endphp

@if ($restaurants->count())
    <div class="mt-4">
        <h4 class="text-sm font-semibold text-gray-600 mb-2">Recently Viewed</h4>
        <div class="grid grid-cols-1 gap-4">
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
        </div>
    </div>
@endif
