@extends('layouts.app')

@php
    use Illuminate\Support\Str;

    $rawRegion = request()->route('region');
    $regionTitle = $rawRegion ? Str::of($rawRegion)->replace('-', ' ')->title() : null;

    $pageTitle = $regionTitle
        ? Str::limit("6 Best Restaurants in $regionTitle", 40, '')
        : '6 Best Restaurants Near You';

    $description = $regionTitle
        ? "Discover 6 must-try places to eat in $regionTitle. Curated by Fudz."
        : "Explore 6 nearby food spots you'll love. Powered by Fudz.";

    $keywords = $regionTitle
        ? [
            "$regionTitle food",
            "$regionTitle restaurants",
            "halal $regionTitle",
            "top eats in $regionTitle",
            "best $regionTitle places",
        ]
        : ['restaurants', 'halal food', 'top rated', 'near me', 'kuliner'];
@endphp

@section('title', $pageTitle)
@section('meta_title', $pageTitle)
@section('meta_description', $description)
@section('meta_keywords', implode(',', $keywords))

@section('meta_og_title', $pageTitle)
@section('meta_og_description', $description)
@section('meta_og_url', request()->url())

@section('content')
    <div class="mt-[72px]">
        <section class="p-4 md:px-2 bg-white bg-opacity-90" id="banner">
            <div class="max-w-screen-xl mx-auto">
                @php
                    $carouselItems = App\Models\RestaurantAd::whereNotNull('image')
                        ->whereNotNull('end_date')
                        ->where('end_date', '>=', now())
                        ->where('is_active', true)
                        ->where('approval_status', 'approved')
                        ->with('restaurant')
                        ->latest()
                        ->get()
                        ->shuffle()
                        ->map(function ($ad) {
                            return [
                                'src' => Storage::url($ad->image),
                                'href' => route('restaurant.index', $ad->restaurant->slug),
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
                                <a href="{{ $item['href'] }}">
                                    <img src="{{ $item['src'] }}" alt="Banner" class="w-full h-full object-cover" />
                                </a>
                            </div>
                        @endforeach

                        @for ($i = 1; $i <= $placeholdersNeeded; $i++)
                            <div class="swiper-slide aspect-[37/10] w-full overflow-hidden rounded-xl">
                                <img src="https://placehold.co/370x100?text=Space Available"
                                    alt="Placeholder {{ $i }}" class="w-full h-full object-cover" />
                            </div>
                        @endfor
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6" id="restaurant">
            <div id="restaurant-header" class="sticky top-[70px] z-10 bg-transparent">
                <div class="max-w-screen-xl mx-auto px-4 md:px-0 py-2">
                    <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap no-scrollbar">
                        <x-button class="btn-icon" :outline="true" data-modal-target="filterModal"
                            data-modal-toggle="filterModal">
                            <i class="ti ti-filter text-lg"></i>
                            <span>Filter</span>
                        </x-button>

                        <x-button class="btn-icon quick-sort-btn" data-sort="popularity">
                            <i class="ti ti-flame text-lg"></i> Popularity
                        </x-button>

                        <x-button class="btn-icon quick-sort-btn" :outline="true" data-sort="rating_desc">
                            <i class="ti ti-star text-lg"></i> Rating
                        </x-button>

                        <x-button id="distance-sort-btn" class="btn-icon quick-sort-btn btn-outline-primary"
                            :outline="true">
                            <i class="ti ti-arrows-sort text-lg"></i> Distance
                        </x-button>

                        <x-button class="btn-icon quick-status-btn btn-outline-primary" :outline="true"
                            data-status="open">
                            <i class="ti ti-campfire text-lg"></i> Open Now
                        </x-button>

                        <x-button class="btn-icon quick-offering-btn" :outline="true" data-offering="Alcohol">
                            <i class="ti ti-bottle text-lg"></i> Alcohol
                        </x-button>
                        <x-button class="btn-icon quick-offering-btn" :outline="true" data-offering="Halal food">
                            <i class="ti ti-leaf text-lg"></i> Halal
                        </x-button>
                    </div>
                </div>
            </div>

            <div class="px-4 md:px-2">
                <div class="max-w-screen-xl mx-auto">
                    <div class="flex my-3">
                        <lord-icon src="https://cdn.lordicon.com/tqvrfslk.json" trigger="loop" class="size-12">
                        </lord-icon>
                        <div class="flex flex-col">
                            @php
                                $region = $regionTitle;
                            @endphp

                            <h5 class="flex text-lg font-bold">
                                {{ $region ? 'Restaurants in ' . ucfirst($region) : 'Dine Around You' }}
                            </h5>
                            <span class="text-xs">
                                {{ $region ? 'Explore popular picks and tasty bites around ' . ucfirst($region) . '.' : 'Popular picks, tasty bites, near you. All ready to explore!' }}
                            </span>
                        </div>
                    </div>
                    <div id="restaurant-list" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        @include('partials.restaurant-items', ['restaurants' => $restaurants])
                    </div>
                </div>
                @if ($restaurants->hasMorePages())
                    <div class="text-center mt-4">
                        <x-button id="load-more-resto" data-page="2">Load More</x-button>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- Filter Modal -->
    <x-modal title="Filter" id="filterModal">
        <form id="filter-form" data-action="false">
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-styled-tab-content"
                    data-tabs-active-classes="font-semibold text-primary hover:text-primary border-primary"
                    data-tabs-inactive-classes="font-semibold text-dark hover:text-primary border-light/50 hover:border-primary"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                            data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Sorting</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                            id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                            aria-controls="dashboard" aria-selected="false">Offerings</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                            id="status-tab" data-tabs-target="#status" type="button" role="tab" aria-controls="status"
                            aria-selected="false">Status</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-4 rounded-lg bg-gray-50" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="flex items-center mb-4">
                        <input id="default-radio-1" type="radio" value="popularity" name="sort_by"
                            class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2"
                            checked>
                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900">Popularity</label>
                    </div>
                    <div class="flex items-center">
                        <input id="default-radio-2" type="radio" value="rating_desc" name="sort_by"
                            class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2">
                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900">Ratings: High to
                            Low</label>
                    </div>
                    <div class="flex items-center mt-2">
                        <input id="default-radio-3" type="radio" value="rating_asc" name="sort_by"
                            class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2">
                        <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900">Ratings: Low to
                            High</label>
                    </div>
                    <div class="flex items-center mt-2">
                        <input id="default-radio-4" type="radio" value="distance_asc" name="sort_by"
                            class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2">
                        <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900">Distance: Near to
                            Far</label>
                    </div>
                    <div class="flex items-center mt-2">
                        <input id="default-radio-5" type="radio" value="distance_desc" name="sort_by"
                            class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2">
                        <label for="default-radio-5" class="ms-2 text-sm font-medium text-gray-900">Distance: Far to
                            Near</label>
                    </div>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50" id="dashboard" role="tabpanel"
                    aria-labelledby="dashboard-tab">
                    @php
                        $offerings = \App\Models\Restaurant\Offering::select('name')
                            ->groupBy('name')
                            ->selectRaw('name, COUNT(*) as total')
                            ->orderBy('name')
                            ->get();
                    @endphp

                    <div class="grid grid-cols-2">
                        @foreach ($offerings as $index => $offering)
                            <div class="flex items-center mb-4">
                                <input id="offering-checkbox-{{ $index }}" type="checkbox" name="offerings[]"
                                    value="{{ $offering->name }}"
                                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded-sm focus:ring-primary focus:ring-2">
                                <label for="offering-checkbox-{{ $index }}"
                                    class="ms-2 text-sm font-medium text-gray-900">
                                    {{ $offering->name }}
                                    <span class="text-sm text-gray-500">({{ $offering->total }})</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50" id="status" role="tabpanel"
                    aria-labelledby="status-tab">
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center">
                            <input type="radio" id="status-all" name="status" value="all" checked
                                class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2">
                            <label for="status-all" class="ms-2 text-sm font-medium text-gray-900">All</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="status-open" name="status" value="open"
                                class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2">
                            <label for="status-open" class="ms-2 text-sm font-medium text-gray-900">Open</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="status-closed" name="status" value="closed"
                                class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2">
                            <label for="status-closed" class="ms-2 text-sm font-medium text-gray-900">Closed</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 bg-white p-4 border-t border-gray-200">
                <x-button type="submit" class="w-full">Apply Filters</x-button>
            </div>
        </form>
    </x-modal>

    @include('partials.faq')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                nav: false,
                dots: false,
            });
        });
    </script>
@endpush
