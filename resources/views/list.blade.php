@extends('layouts.app')
@section('showNavbot', true)

@section('content')
    <div class="mt-[72px]">
        @php
            $carouselItems = [
                ['src' => 'https://b.zmtcdn.com/data/o2_assets/85e14f93411a6b584888b6f3de3daf081716296829.png'],
            ];
        @endphp

        <x-section.carousel-section sectionId="home" :items="$carouselItems" />

        <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6" id="restaurant">
            <div id="restaurant-header" class="sticky top-[72px] z-10 bg-transparent">
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
                    <div class="flex mb-3">
                        <lord-icon src="https://cdn.lordicon.com/tqvrfslk.json" trigger="loop" class="size-12">
                        </lord-icon>
                        <div class="flex flex-col">
                            <h5 class="flex text-lg font-bold">
                                Dine Around You
                            </h5>
                            <span class="text-xs">Popular picks, tasty bites, near you. All ready to explore!</span>
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
            const $restaurantList = $('#restaurant-list');
            const $loadMoreBtn = $('#load-more-resto');
            const listRoute = '{{ route('list') }}';

            function updateImageLazyLoad() {
                $restaurantList.find('img[data-src]').each(function() {
                    $(this).attr('src', $(this).data('src')).removeAttr('data-src');
                });
            }

            function fetchRestaurants(params = {}, append = false) {
                $.ajax({
                    url: listRoute,
                    type: 'GET',
                    data: params,
                    beforeSend: function() {
                        if (!append) $restaurantList.html('<p>Loading...</p>');
                        else $loadMoreBtn.text('Loading...');
                    },
                    success: function(data) {
                        const hasEmptyState = data.includes('empty-restaurant');

                        if (append) {
                            if (hasEmptyState || $.trim(data) === '') {
                                $loadMoreBtn.hide();
                            } else {
                                $restaurantList.append(data);
                                $loadMoreBtn.data('page', $loadMoreBtn.data('page') + 1);
                                $loadMoreBtn.text('Load More');
                            }
                        } else {
                            $restaurantList.html(data);

                            if (hasEmptyState) {
                                $loadMoreBtn.hide();
                            } else {
                                $loadMoreBtn.data('page', 2).show();
                            }
                        }
                        updateImageLazyLoad();
                    },
                    error: function() {
                        const errorMsg = '<p>Error loading data</p>';
                        if (append) $loadMoreBtn.text('Try again');
                        else $restaurantList.html(errorMsg);
                    }
                });
            }

            $('.quick-sort-btn').not('#distance-sort-btn').on('click', function() {
                const $this = $(this);
                const sortBy = $this.data('sort');
                const $radioInput = $(`#filter-form input[name="sort_by"][value="${sortBy}"]`);
                const isActive = $this.hasClass('btn-primary');

                $('.quick-sort-btn').removeClass('btn-primary').addClass('btn-outline-primary');
                $('#filter-form input[name="sort_by"]').prop('checked', false);

                if (!isActive) {
                    $this.removeClass('btn-outline-primary').addClass('btn-primary');
                    $radioInput.prop('checked', true);
                }

                const formData = $('#filter-form').serialize();
                fetchRestaurants(formData);
            });

            $('.quick-status-btn').on('click', function() {
                const $this = $(this);
                const isActive = $this.hasClass('btn-primary');

                $('.quick-status-btn').removeClass('btn-primary').addClass('btn-outline-primary');

                if (!isActive) {
                    $this.removeClass('btn-outline-primary').addClass('btn-primary');
                }

                if (isActive) {
                    $('#filter-form input[name="status"]').prop('checked', false);
                    $('#filter-form input#status-all').prop('checked', true);
                } else {
                    $('#filter-form input[name="status"]').prop('checked', false);
                    $('#filter-form input#status-open').prop('checked', true);
                }

                const formData = $('#filter-form').serialize();
                fetchRestaurants(formData);
            });


            $('#distance-sort-btn').on('click', function() {
                const $this = $(this);
                const $icon = $this.find('i');
                const currentValue = $('#filter-form input[name="sort_by"]:checked').val();
                let nextValue, nextIcon;

                const isActive = $this.hasClass('btn-primary');

                if (!isActive) {
                    nextValue = 'distance_asc';
                    nextIcon = 'ti-arrow-down';
                } else {
                    if (currentValue === 'distance_asc') {
                        nextValue = 'distance_desc';
                        nextIcon = 'ti-arrow-up';
                    } else {
                        nextValue = 'distance_asc';
                        nextIcon = 'ti-arrow-down';
                    }
                }

                $('#filter-form input[name="sort_by"]').prop('checked', false);
                $(`#filter-form input[name="sort_by"][value="${nextValue}"]`).prop('checked', true);

                $('.quick-sort-btn').removeClass('btn-primary').addClass('btn-outline-primary');
                $this.removeClass('btn-outline-primary').addClass('btn-primary');

                $icon.attr('class', `ti ${nextIcon} text-lg`);

                const formData = $('#filter-form').serialize();
                fetchRestaurants(formData);
            });

            $('.quick-sort-btn').not('#distance-sort-btn').on('click', function() {
                $('#distance-sort-btn i').attr('class', 'ti ti-arrows-sort text-lg');
            });

            $('.quick-offering-btn').on('click', function() {
                const $this = $(this);
                const offering = $this.data('offering');
                const $checkbox = $(`#filter-form input[name="offerings[]"][value="${offering}"]`);
                const isActive = $this.hasClass('btn-primary');

                if (isActive) {
                    $this.removeClass('btn-primary').addClass('btn-outline-primary');
                    $checkbox.prop('checked', false);
                } else {
                    $this.removeClass('btn-outline-primary').addClass('btn-primary');
                    $checkbox.prop('checked', true);
                }

                const formData = $('#filter-form').serialize();
                fetchRestaurants(formData);
            });

            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                // Sinkronisasi tombol shortcut sort
                const sortBy = $('#filter-form input[name="sort_by"]:checked').val();
                $('.quick-sort-btn').each(function() {
                    const $btn = $(this);
                    if ($btn.data('sort') === sortBy) {
                        $btn.removeClass('btn-outline-primary').addClass('btn-primary');
                    } else {
                        $btn.removeClass('btn-primary').addClass('btn-outline-primary');
                    }
                });

                // Sinkronisasi tombol distance sort icon
                const $distanceBtn = $('#distance-sort-btn');
                const $icon = $distanceBtn.find('i');
                if (sortBy === 'distance_asc') {
                    $distanceBtn.removeClass('btn-outline-primary').addClass('btn-primary');
                    $icon.attr('class', 'ti ti-arrow-down text-lg');
                } else if (sortBy === 'distance_desc') {
                    $distanceBtn.removeClass('btn-outline-primary').addClass('btn-primary');
                    $icon.attr('class', 'ti ti-arrow-up text-lg');
                } else {
                    $distanceBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                    $icon.attr('class', 'ti ti-arrows-sort text-lg');
                }

                // Sinkronisasi tombol shortcut offering
                $('.quick-offering-btn').each(function() {
                    const $btn = $(this);
                    const offering = $btn.data('offering');
                    const $checkbox = $(
                        `#filter-form input[name="offerings[]"][value="${offering}"]`);
                    if ($checkbox.prop('checked')) {
                        $btn.removeClass('btn-outline-primary').addClass('btn-primary');
                    } else {
                        $btn.removeClass('btn-primary').addClass('btn-outline-primary');
                    }
                });

                const status = $('#filter-form input[name="status"]:checked').val();
                $('.quick-status-btn').each(function() {
                    const $btn = $(this);
                    if ($btn.data('status') === status) {
                        $btn.removeClass('btn-outline-primary').addClass('btn-primary');
                    } else {
                        $btn.removeClass('btn-primary').addClass('btn-outline-primary');
                    }
                });


                fetchRestaurants(formData);
            });


            $loadMoreBtn.on('click', function() {
                const page = $(this).data('page');
                const formData = $('#filter-form').serialize();
                fetchRestaurants(formData + '&page=' + page, true);
            });
        });
    </script>

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

@push('scripts')
    <script>
        let sendLocation = () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                        $.ajax({
                            url: '{{ route('location.store') }}',
                            method: 'POST',
                            data: {
                                latitude: lat,
                                longitude: lng,
                                timezone: timezone,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                console.log('Location sent successfully:', response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error sending location:', error);
                            }
                        });
                    },
                    function(error) {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                console.error('User denied the request for Geolocation.');
                                break;
                            case error.POSITION_UNAVAILABLE:
                                console.error('Location information is unavailable.');
                                break;
                            case error.TIMEOUT:
                                console.error('The request to get user location timed out.');
                                break;
                            case error.UNKNOWN_ERROR:
                                console.error('An unknown error occurred.');
                                break;
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                console.error('Your browser does not support geolocation.');
            }
        }

        sendLocation();

        setInterval(sendLocation, 60000);
    </script>
@endpush
