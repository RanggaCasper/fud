@forelse ($restaurants as $restaurant)
    <div class="col-span-1">
        <x-card.restaurant-card :title="$restaurant->name" :slug="$restaurant->slug" :rating="$restaurant->rating" :reviews="$restaurant->reviews"
            :location="$restaurant->address" :distance="$restaurant->distance . 'km'" :image="$restaurant->thumbnail" :isPromotion="(bool) ($restaurant->ad && $restaurant->ad->is_active && is_null($restaurant->ad->image))" :isClosed="$restaurant->getIsClosedCached()"
            :isHalal="$restaurant->offerings->contains(function ($offering) {
                return str_contains(strtolower($offering->name), 'halal');
            })" />
    </div>
@empty
    <div class="col-span-full text-center py-8 empty-restaurant">
        <div class="flex justify-center items-center flex-col">
            <img src="{{ asset('assets/svg/undraw_empty_4zx0.svg') }}" class="size-64" alt="Empty">
            <p class="font-semibold">No restaurants found.</p>
        </div>
    </div>
@endforelse

@once
    @push('scripts')
        <script>
            const $restaurantList = $('#restaurant-list');
            const $loadMoreBtn = $('#load-more-resto');
            const rawRegion = '{{ request()->route('region') }}';
            const formattedRegion = encodeURIComponent(rawRegion.replace(/-/g, ' '));
            const listRoute = `/restaurants/${formattedRegion}`;

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
                                $loadMoreBtn.text('Load More');
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
        </script>
    @endpush
@endonce
