@php
    $regionSuggestion = $regionSuggestion instanceof \Illuminate\Support\Collection ? $regionSuggestion : collect([$regionSuggestion]);

    if ($regionSuggestion->count() > 1) {
        $oneWord = $regionSuggestion->filter(fn($r) => str_word_count($r) === 1)->shuffle();
        $multiWord = $regionSuggestion->filter(fn($r) => str_word_count($r) > 1)->shuffle();
        $regionSuggestion = $oneWord->concat($multiWord)->take(4);
    }
@endphp

@if ($regionSuggestion->count())
    @foreach ($regionSuggestion as $region)
        <div class="col-span-1">
            <a href="{{ route('list', ['region' => Str::slug($region)]) }}"
                class="flex gap-3 items-center bg-white rounded-lg p-2 hover:bg-gray-100 transition-all">
                <div
                    class="relative shrink-0 flex items-center justify-center w-20 h-20 rounded-lg bg-gray-100 text-primary">
                    <i class="ti ti-location text-4xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="text-sm font-semibold text-gray-800 line-clamp-1">
                            Restaurants in <span class="text-primary font-semibold">{{ ucfirst($region) }}</span>
                        </h4>
                    </div>
                    <div class="text-xs text-gray-500 flex justify-between">
                        <div class="flex items-center gap-1">
                            <span class="line-clamp-1">Tap to explore restaurants in this area</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif

@forelse ($restaurants as $restaurant)
    <div class="col-span-1 mb-0.5">
        <x-card.mini-restaurant-card :image="$restaurant->thumbnail"
            :title="$restaurant->name"
            :slug="Str::slug($restaurant->name)"
            :rating="$restaurant->rating"
            :address="$restaurant->address"
            :isClosed="$restaurant->isClosed()"
            :isHalal="$restaurant->offerings->contains(fn($offering) => str_contains(strtolower($offering->name), 'halal'))"
        />
    </div>
@empty
    <div class="text-muted text-sm text-center">
        <img src="{{ asset('assets/svg/undraw_empty_4zx0.svg') }}" alt="Empty Search"
            class="w-32 h-32 mx-auto mb-4">
        <p class="font-semibold">No restaurants found.</p>
    </div>
@endforelse
