@extends('layouts.app')

@section('title', optional($restaurant->metaTag)->meta_title ?? ($restaurant->name . ' - ' . config('app.name')))

@section('meta_title', optional($restaurant->metaTag)->meta_title ?? ($restaurant->name . ' - ' . config('app.name')))
@section('meta_description', optional($restaurant->metaTag)->meta_description ?? 'Discover delicious food near you.')
@section('meta_keywords', implode(',', optional($restaurant->metaTag)->meta_keywords ?? [$restaurant->name]))

@section('meta_og_title', optional($restaurant->metaTag)->meta_title ?? ($restaurant->name . ' - ' . config('app.name')))
@section('meta_og_description', optional($restaurant->metaTag)->meta_description ?? 'Discover delicious food near you.')
@section('meta_og_image', $restaurant->thumbnail)
@section('meta_og_url', route('restaurant.index', ['slug' => $restaurant->slug]))
@section('meta_og_type', 'restaurant')

@push('styles')
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "{{ $restaurant->name }}",
  "image": "{{ $restaurant->thumbnail }}",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "{{ $restaurant->address }}",
    "addressCountry": "ID"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": {{ $restaurant->latitude }},
    "longitude": {{ $restaurant->longitude }}
  },
  "telephone": "{{ $restaurant->phone }}",
  "url": "{{ route('restaurant.index', ['slug' => $restaurant->slug]) }}",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": {{ $restaurant->rating }},
    "reviewCount": {{ $restaurant->reviews }}
  },
  "priceRange": "{{ $restaurant->price_range }}"
}
</script>
@endpush

@section('header')
    <div class="mt-[72px]">
        <div class="py-6 px-4 md:px-2 relative">
            <img src="{{ $restaurant->thumbnail }}" alt="{{ $restaurant->name }}"
                class="w-full h-full object-cover absolute inset-0 z-0" />
            <div class="absolute inset-0 bg-black opacity-25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-75"></div>

            <div class="max-w-screen-xl mx-auto pt-[100px] relative z-10">
                <div class="flex flex-col space-y-2">
                    <h5 class="font-bold text-3xl text-white">{{ $restaurant->name }} </h5>
                    <div class="flex items-center gap-2">
                        <div
                            class="bg-primary flex items-center text-white text-sm font-bold gap-0.5 px-2 py-0.5 rounded-lg shadow-md">
                            <i class="ti ti-star-filled text-warning"></i>
                            @php
                                $googleRating = $restaurant->rating ?? 0;
                                $fudRating = $restaurant->reviews()->avg('rating') ?? 0;
                                $combinedRating =
                                    $googleRating && $fudRating
                                        ? number_format(($googleRating + $fudRating) / 2, 1)
                                        : number_format($googleRating ?: $fudRating, 1);
                            @endphp
                            <span>{{ $combinedRating }}</span>
                        </div>
                        <div class="flex flex-col">
                            <h5 class="text-sm text-white">
                                {{ number_format($restaurant->reviews, 0, ',', '.') }}+ <strong>Google</strong> |
                                {{ number_format($restaurant->reviews()->count(), 0, ',', '.') }}+
                                <strong>{{ config('app.name') }}</strong> Reviews
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mt-4">
                    <div class="mb-3">
                        <h5 class="text-white font-semibold line-clamp-1">
                            {{ implode(', ', $restaurant->offerings->take(8)->pluck('name')->toArray()) }}
                        </h5>
                        <p class="text-xs md:text-sm text-white/90">{{ $restaurant->address }}</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-1 mb-3">
                        <div class="text-white">
                            @if ($restaurant->isClosed())
                                <span class="bg-danger text-xs font-medium px-2.5 py-0.5 rounded-lg">Closed</span>
                            @else
                                <span class="bg-success text-xs font-medium px-2.5 py-0.5 rounded-lg">Open</span>
                            @endif

                            <span
                                class="font-semibold text-xs md:text-sm">{{ $restaurant->getTodayOperatingHours() }}</span>
                        </div>
                        <span class="border-s mx-2 border-white/50"></span>
                        <span class="text-xs md:text-sm font-semibold text-white flex items-center">
                            <a href="tel:6283189944777"
                                class="hover:underline flex items-center gap-1 hover:text-primary text-white">
                                <i class="ti ti-phone text-primary"></i>
                                {{ $restaurant->phone }}
                            </a>
                        </span>
                        <span class="border-s mx-2 border-white/50"></span>
                        @php
                            $claimed = $restaurant->claim !== null;
                        @endphp
                        <div class="flex items-center gap-1">
                            @if ($claimed)
                                <i class="ti ti-circle-dashed-check text-success"></i>
                            @else
                                <i class="ti ti-focus-2 text-white"></i>
                            @endif
                            <span data-tooltip-target="{{ $claimed ? 'tooltip-claimed' : 'tooltip-claim' }}"
                                data-tooltip-placement="bottom" data-tooltip-trigger="click"
                                class="flex cursor-pointer text-xs md:text-sm gap-1 font-semibold items-center space-x-2 underline text-white">
                                {{ $claimed ? ' Claimed' : 'Unclaimed' }}
                            </span>
                        </div>


                        @if ($claimed)
                            <div id="tooltip-claimed" role="tooltip"
                                class="absolute z-10 max-w-xs invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 tooltip">
                                This restaurant has been claimed by its owner. They can now update information, respond to
                                reviews, and manage their presence.
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @else
                            <div id="tooltip-claim" role="tooltip"
                                class="absolute z-10 max-w-xs invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 tooltip">
                                Business owners can claim it to manage details, upload photos, respond to reviews, and more.
                                <div class="tooltip-arrow" data-popper-arrow></div>
                                <p>
                                    <a class="font-semibold"
                                        href="{{ route('restaurant.claim', ['slug' => $restaurant->slug]) }}">Claim this
                                        restaurant</a>
                                </p>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Share, View Photo, and Favorite Buttons (Responsive layout) -->
                <div class="md:absolute md:bottom-4 md:right-0 flex md:gap-3 gap-1 z-20 text-white">
                    <x-button class="btn-icon" data-modal-target="shareModal" data-modal-toggle="shareModal">
                        <i class="ti ti-share text-sm"></i>
                        Share
                    </x-button>
                    @php
                        $favorited = auth()->user()?->favorites()->where('restaurant_id', $restaurant->id)->exists();
                    @endphp

                    <x-button class="btn-icon favorite-btn" data-id="{{ $restaurant->id }}"
                        data-favorited="{{ $favorited ? '1' : '0' }}">
                        <i class="ti {{ $favorited ? 'ti-star-filled' : 'ti-star' }} text-sm mr-1"></i>
                        {{ $favorited ? 'Favorited' : 'Favorite' }}
                    </x-button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('content')
    <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-3"
        id="restaurant-detail">
        <div class="max-w-screen-xl mx-auto px-4 md:px-0 py-6">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap no-scrollbar">
                <a href="#write-a-review" class="btn btn-md btn-outline-primary btn-icon">
                    <i class="ti ti-writing text-lg"></i>
                    <span>Write a Review</span>
                </a>
                @if ($restaurant->website)
                    <a href="{{ $restaurant->website }}" target="_blank" class="btn btn-md btn-outline-primary btn-icon">
                        <i class="ti ti-link text-lg"></i>
                        <span>
                            Resto Website
                        </span>
                    </a>
                @endif
            </div>
        </div>
        <div class="px-4 md:px-2 ">
            <div class="max-w-screen-xl mx-auto space-y-6">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-8">
                        <div class="space-y-3">
                            <div>
                                <h5 class="text-2xl font-semibold mb-6">Gallery</h5>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="gallery">
                                    <!-- Skeleton placeholder (4 x 3 = 12) -->
                                    @for ($i = 0; $i < 8; $i++)
                                        <div class="aspect-square rounded-lg bg-gray-200 animate-pulse"></div>
                                    @endfor
                                </div>
                                <div class="mt-4 text-center">
                                    <x-button id="load-more">Load More</x-button>
                                </div>
                            </div>
                            <hr class="my-6 border-muted/10 sm:mx-auto">
                            <div>
                                <div class="mb-6">
                                    <h5 class="text-2xl font-semibold">About</h5>
                                    <p class="text-sm text-secondary">{{ $restaurant->description }}</p>
                                </div>
                                <div>
                                    <h5 class="text-lg font-semibold mb-4">Features</h5>
                                    <div class="flex flex-col space-y-3">
                                        @if ($restaurant->payments->isNotEmpty())
                                            <div class="flex text-secondary text-sm items-start gap-2">
                                                <i class="ti !text-muted text-xl ti-credit-card"></i>
                                                <span>{{ implode(', ', $restaurant->payments->pluck('name')->toArray()) }}</span>
                                            </div>
                                        @endif

                                        @if ($restaurant->accessibilities->isNotEmpty())
                                            <div class="flex text-secondary text-sm items-start gap-2">
                                                <i class="ti !text-muted text-xl ti-disabled-2"></i>
                                                <span>{{ implode(', ', $restaurant->accessibilities->pluck('name')->toArray()) }}</span>
                                            </div>
                                        @endif

                                        @if ($restaurant->diningOptions->isNotEmpty())
                                            <div class="flex text-secondary text-sm items-start gap-2">
                                                <i class="ti !text-muted text-xl ti-tools-kitchen-2"></i>
                                                <span>{{ implode(', ', $restaurant->diningOptions->pluck('name')->toArray()) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <div class="sticky top-[78px] has-[#reservationWrapper>*]:space-y-3">
                            <div id="reservationWrapper">
                                <div class="animate-pulse space-y-4">
                                    <div class="h-24 bg-gray-300 rounded w-full"></div>
                                </div>
                            </div>
                            <x-card title="Location & Hours">
                                <div id="map" class="h-44 mb-3"></div>
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="text-sm line-clamp-2">{{ $restaurant->address }}</span>
                                    </div>
                                    <div class="flex">
                                        <a href="{{ 'https://www.google.com/maps?cid=' . $restaurant->data_cid }}"
                                            target="_blank" class="btn btn-primary btn-md">
                                            Directions
                                        </a>
                                    </div>
                                </div>
                                <table class="min-w-full table-auto">
                                    <tbody>
                                        @php
                                            $today = strtolower(now()->format('l'));
                                            $dayOrder = [
                                                'monday',
                                                'tuesday',
                                                'wednesday',
                                                'thursday',
                                                'friday',
                                                'saturday',
                                                'sunday',
                                            ];
                                            $sortedHours = ($restaurant->operatingHours ?? collect())->sortBy(function (
                                                $hour,
                                            ) use ($dayOrder) {
                                                return array_search(strtolower($hour->day), $dayOrder);
                                            });
                                        @endphp

                                        @forelse ($sortedHours as $hours)
                                            @if ($hours)
                                                <tr>
                                                    <td class="text-dark font-semibold py-1">{{ ucfirst($hours->day) }}
                                                    </td>
                                                    <td
                                                        class="text-dark py-1 {{ strtolower($hours->day) === $today ? 'font-semibold' : '' }}">
                                                        {{ $hours->operating_hours }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-secondary py-2">
                                                    No operating hours available.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </x-card>
                        </div>
                    </div>
                </div>
                <div id="write-a-review" class="w-full lg:w-8/12">
                    <x-card title="Write a Review">
                        @if (Auth::check())
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                                <div class="flex items-center gap-3">
                                    @if (Auth::user()->avatar)
                                        <img class="w-14 h-14 rounded-full object-cover" src="{{ Auth::user()->avatar }}"
                                            alt="user photo">
                                    @else
                                        <span
                                            class="w-14 h-14 flex items-center justify-center bg-primary text-white text-xl font-medium rounded-full">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    @endif
                                    <div class="flex flex-col">
                                        <h5 class="font-semibold text-base">{{ Auth::user()->name }}</h5>
                                        <p class="text-sm text-secondary">Local Explorer Level 6</p>
                                    </div>
                                </div>
                                <div class="sm:self-start">
                                    <x-button class="w-full lg:w-auto" data-modal-target="reviewModal"
                                        data-modal-toggle="reviewModal">Write a
                                        Review</x-button>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center">
                                <dotlottie-player
                                    src="https://lottie.host/ef88c8f6-7f1b-4f14-b6ba-d28b0ea036d9/LFfy4WSd69.lottie"
                                    background="transparent" speed="1" class="h-64" loop
                                    autoplay></dotlottie-player>
                                <p class="text-sm text-secondary mb-2">You need to be logged in to write a review.
                                </p>
                                <a href="{{ route('auth.login.index') }}" class="btn btn-md btn-primary">Login</a>
                            </div>
                        @endif
                    </x-card>
                </div>
                <div>
                    <div class="flex my-3">
                        <lord-icon src="https://cdn.lordicon.com/abhwievu.json" trigger="loop" class="size-12">
                        </lord-icon>
                        <div class="flex flex-col">
                            <h5 class="flex text-lg font-bold">
                                Reviews
                            </h5>
                            <span class="text-xs text-muted">
                                Based on user reviews on {{ config('app.name') }}
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-2">
                        @php
                            $comments = $restaurant
                                ->reviews()
                                ->with(['user', 'attachments'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(6);
                        @endphp

                        @forelse($comments as $comment)
                            <div class="col-span-12 md:col-span-6">
                                <div class="mb-3">
                                    <x-card.review-card :comment="$comment" />
                                </div>
                            </div>
                        @empty
                            <div class="col-span-12">
                                <div class="mt-6">
                                    <img src="{{ asset('assets/svg/undraw_empty_4zx0.svg') }}" class="h-64 mx-auto"
                                        alt="No reviews">
                                    <div class="text-center text-muted font-semibold mt-3">
                                        This restaurant has no reviews yet.
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                    <div class="mt-4">
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-modal title="{{ $restaurant->name }}" id="reviewModal">
        <form method="POST" action="{{ route('user.review.store', ['slug' => $restaurant->slug]) }}">
            @csrf

            <!-- Rating section -->
            <div class="mb-3">
                <div class="relative">
                    <label class="block w-full mb-2 text-sm font-semibold tracking-wide" for="star-rating">
                        How would you rate this place?
                    </label>
                    <input type="hidden" name="rating" id="rating-input">
                    <div id="star-rating" class="flex space-x-1 cursor-pointer">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="ti ti-star-filled text-2xl text-gray-300 hover:scale-110 transition-transform"
                                data-index="{{ $i }}"></i>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="relative">
                    <label class="block w-full mb-2 text-sm font-semibold tracking-wide" for="comment">
                        Share your experience with others <span class="text-red-500">*</span>
                    </label>
                    <textarea name="comment"
                        class="w-full h-32 border-2 border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary px-3 py-2"
                        placeholder="Was it amazing? Any tips for other visitors?"></textarea>
                </div>
            </div>

            <div class="mb-3">
                <x-filepond class="filepond-image" label="Add some photos" name="attachments[]" id="image" multiple
                    :required="false" />
            </div>

            <!-- Post review button -->
            <x-button type="submit" class="w-full">
                Post Review
            </x-button>
        </form>
    </x-modal>

    <x-modal title="Share" id="shareModal">
        <h5 class="font-semibold text-lg">Share this restaurant</h5>
        <div class="mb-3">
            <div class="flex flex-wrap items-center">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                    target="_blank"
                    class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 8 19">
                        <path fill-rule="evenodd"
                            d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                            clip-rule="evenodd" />
                    </svg>
                    Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}" target="_blank"
                    class="text-white bg-[#1da1f2] hover:bg-[#1da1f2]/90 focus:ring-4 focus:outline-none focus:ring-[#1da1f2]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1da1f2]/55 me-2 mb-2">
                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 17">
                        <path fill-rule="evenodd"
                            d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                            clip-rule="evenodd" />
                    </svg>
                    Twitter
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode(request()->fullUrl()) }}" target="_blank"
                    class="text-white bg-[#25D366] hover:bg-[#25D366]/90 focus:ring-4 focus:outline-none focus:ring-[#25D366]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#25D366]/55 me-2 mb-2">
                    <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-brand-whatsapp">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M18.497 4.409a10 10 0 0 1 -10.36 16.828l-.223 -.098l-4.759 .849l-.11 .011a1 1 0 0 1 -.11 0l-.102 -.013l-.108 -.024l-.105 -.037l-.099 -.047l-.093 -.058l-.014 -.011l-.012 -.007l-.086 -.073l-.077 -.08l-.067 -.088l-.056 -.094l-.034 -.07l-.04 -.108l-.028 -.128l-.012 -.102a1 1 0 0 1 0 -.125l.012 -.1l.024 -.11l.045 -.122l1.433 -3.304l-.009 -.014a10 10 0 0 1 1.549 -12.454l.215 -.203a10 10 0 0 1 13.226 -.217m-8.997 3.09a1.5 1.5 0 0 0 -1.5 1.5v1a6 6 0 0 0 6 6h1a1.5 1.5 0 0 0 0 -3h-1l-.144 .007a1.5 1.5 0 0 0 -1.128 .697l-.042 .074l-.022 -.007a4.01 4.01 0 0 1 -2.435 -2.435l-.008 -.023l.075 -.041a1.5 1.5 0 0 0 .704 -1.272v-1a1.5 1.5 0 0 0 -1.5 -1.5" />
                    </svg>
                    WhatsApp
                </a>
                <a href="https://www.instagram.com/share?url={{ urlencode(request()->fullUrl()) }}" target="_blank"
                    class="text-white bg-[#d62976] hover:bg-[#d62976]/90 focus:ring-4 focus:outline-none focus:ring-[#d62976]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#d62976]/55 me-2 mb-2">
                    <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-brand-instagram">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M16 3a5 5 0 0 1 5 5v8a5 5 0 0 1 -5 5h-8a5 5 0 0 1 -5 -5v-8a5 5 0 0 1 5 -5zm-4 5a4 4 0 0 0 -3.995 3.8l-.005 .2a4 4 0 1 0 4 -4m4.5 -1.5a1 1 0 0 0 -.993 .883l-.007 .127a1 1 0 0 0 1.993 .117l.007 -.127a1 1 0 0 0 -1 -1" />
                    </svg>
                    Instagram
                </a>
            </div>
        </div>
        <div class="mb-3">
            <h5 class="font-semibold text-lg">Share this restaurant link</h5>
            <div class="grid grid-cols-8 gap-2 w-full">
                <label for="restaurantLink" class="sr-only">Label</label>
                <input id="restaurantLink" type="text"
                    class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"
                    value="{{ request()->fullUrl() }}" disabled readonly>
                <button data-copy-to-clipboard-target="restaurantLink"
                    class="col-span-2 text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm w-full sm:w-auto py-2.5 text-center items-center inline-flex justify-center">
                    <span id="default-message">Copy</span>
                    <span id="success-message" class="hidden">
                        <div class="inline-flex items-center">
                            <svg class="w-3 h-3 text-white me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                            Copied!
                        </div>
                    </span>
                </button>
            </div>
        </div>
    </x-modal>
@endsection

@push('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>

    <script>
        const stars = document.querySelectorAll('#star-rating i');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const rating = index + 1;
                ratingInput.value = rating;

                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-warning');
                    } else {
                        s.classList.remove('text-warning');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });
    </script>
    <script>
        let allImages = [];
        let currentIndex = 0;
        const batchSize = 8;
        let viewer;

        function renderNextBatch() {
            const nextImages = allImages.slice(currentIndex, currentIndex + batchSize);
            nextImages.forEach(url => {
                $('#gallery').append(`
            <div class="aspect-square overflow-hidden rounded-lg bg-gray-200 cursor-zoom-in">
                <img class="w-full h-full object-cover" src="${url}" alt="Gallery Image">
            </div>
        `);
            });

            currentIndex += batchSize;
            if (currentIndex >= allImages.length) {
                $('#load-more').hide();
            }

            if (viewer) viewer.destroy();
            viewer = new Viewer(document.getElementById('gallery'), {
                toolbar: true,
                navbar: true,
                title: false,
                fullscreen: true,
                tooltip: false,
                movable: true,
                rotatable: true,
                scalable: true,
                transition: true,
            });
        }

        function fetchImages() {
            $.ajax({
                url: '{{ route('fetch.image', ['place_id' => $restaurant->place_id]) }}',
                method: 'GET',
                success: function(res) {
                    $('#gallery').empty();
                    if (res.success && res.images.length > 0) {
                        $('#status').text(`Loaded ${res.count} images in ${res.duration} seconds.`);
                        allImages = res.images;
                        renderNextBatch();

                        if (allImages.length > batchSize) {
                            $('#load-more').show();
                        }
                    } else {
                        $('#status').text('No images found.');
                    }
                },
                error: function() {
                    $('#status').text('Failed to fetch images.');
                }
            });
        }

        function fetchReservation() {
            $.ajax({
                url: '{{ route('fetch.reservation', ['place_id' => $restaurant->place_id]) }}',
                method: 'GET',
                success: function(res) {
                    const data = res.data;

                    const createSelect = (label, name, options, placeholder) => {
                        const opts = [`<option value="">${placeholder}</option>`];
                        options.forEach(val => {
                            opts.push(`<option value="${val}">${val}</option>`);
                        });

                        return `
                            <div class="mb-3">
                                <label for="${name}" class="block mb-2 text-sm font-semibold">
                                    ${label} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="${name}" id="${name}" class="w-full bg-transparent border border-light/50 focus:border-primary focus:border-2 text-sm text-muted focus:outline-none rounded-lg p-2.5">
                                        ${opts.join('')}
                                    </select>
                                </div>
                            </div>
                        `;
                    };

                    const createInput = (label, name, type, placeholder) => {
                        let extraAttrs = '';
                        if (type === 'date') {
                            const tomorrow = new Date();
                            tomorrow.setDate(tomorrow.getDate() + 1);
                            const minDate = tomorrow.toISOString().split('T')[0];
                            extraAttrs = `min="${minDate}"`;
                        }

                        return `
                            <div class="mb-3">
                                <label for="${name}" class="block mb-2 text-sm font-semibold">
                                    ${label} <span class="text-red-500">*</span>
                                </label>
                                <input type="${type}" name="${name}" id="${name}" placeholder="${placeholder}"
                                    ${extraAttrs}
                                    class="w-full bg-transparent border border-light/50 focus:border-primary focus:border-2 text-sm text-muted focus:outline-none rounded-lg p-2.5" />
                            </div>
                        `;
                    };

                    if (res.success) {
                        $('#reservationWrapper').html(`
                            <x-card.card title="Reserve a table" class="mb-3">
                                 <div class="flex items-center gap-2 mb-3 text-sm text-muted">
                                    <span>This reservation is powered by</span>
                                    <img src="https://static.chope.co/static/mainwebsite5.0/img/Chope-with-Grab_Logo-Horizontal.png?date=20250617" alt="Chope Logo" class="h-6">
                                </div>
                                <form action="{{ route('reservation.store') }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="rid" value="${data.rid}">
                                    ${createSelect('Adults', 'adults', data.party_sizes, 'Select adults')}
                                    ${createSelect('Children', 'children', data.child_sizes, 'Select children')}
                                    ${createSelect('Time', 'time', data.time_slots, 'Select time')}
                                    ${createInput('Reservation Date', 'date', 'date', 'Select date')}
                                    <x-button type="submit">Submit</x-button>
                                    <x-button type="reset">Reset</x-button>
                                </form>
                            </x-card.card>
                        `);
                    } else {
                        $('#reservationWrapper').empty();
                    }
                },
                error: function() {
                    $('#reservationWrapper').empty();
                }
            });
        }

        $(document).ready(function() {
            fetchImages();
            fetchReservation();
        });

        $('#load-more').click(function() {
            renderNextBatch();
        });
    </script>

    <script>
        var latitude = {{ $restaurant->latitude }};
        var longitude = {{ $restaurant->longitude }};

        var map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map);
        marker.bindPopup('<b>{{ $restaurant->name }}</b><br>{{ $restaurant->address }}').openPopup();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButton = document.querySelector('[data-copy-to-clipboard-target="restaurantLink"]');
            const inputField = document.getElementById('restaurantLink');
            const defaultMessage = document.getElementById('default-message');
            const successMessage = document.getElementById('success-message');

            copyButton.addEventListener('click', function() {
                inputField.select();
                inputField.setSelectionRange(0, 99999);

                navigator.clipboard.writeText(inputField.value).then(function() {
                    defaultMessage.classList.add('hidden');
                    successMessage.classList.remove('hidden');

                    setTimeout(function() {
                        defaultMessage.classList.remove('hidden');
                        successMessage.classList.add('hidden');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Error copying text: ', err);
                });
            });
        });
    </script>
    <script>
        $(document).on('click', '.favorite-btn', function(e) {
            e.preventDefault();

            let button = $(this);
            let restaurantId = button.data('id');
            let isFavorited = button.data('favorited') == 1;

            $.ajax({
                url: isFavorited ? '{{ route('user.favorite.destroy') }}' :
                    '{{ route('user.favorite.store') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    restaurant_id: restaurantId,
                    @if (Route::has('user.favorite.destroy'))
                        ...(isFavorited ? {
                            _method: 'DELETE'
                        } : {}),
                    @endif
                },
                success: function(response) {
                    button.data('favorited', isFavorited ? 0 : 1);

                    let iconClass = isFavorited ? 'ti-star' : 'ti-star-filled';
                    let label = isFavorited ? 'Favorite' : 'Favorited';

                    button.empty().append(`<i class="ti ${iconClass} text-sm mr-1"></i> ${label}`);
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Something went wrong.';
                    console.log(xhr.responseJSON);
                    // window.location.href = xhr.responseJSON.redirect_url;
                }
            });
        });
    </script>
@endpush
