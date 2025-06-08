<section class="bg-[url('{{ $backgroundImage }}')] py-6" id="restaurant">
    <div id="restaurant-header" class="sticky top-[72px] z-10 bg-transparent">
        <div class="max-w-screen-xl mx-auto px-4 md:px-0 py-2">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap no-scrollbar">
                <x-button class="btn-icon" :outline="true" data-modal-target="filterModal" data-modal-toggle="filterModal">
                    <svg
                    class="size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    >
                    <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                    </svg>
                    <span>Filter</span>
                </x-button>
                <x-button class="btn-icon" :outline="true">
                    <svg
                    class="size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    >
                    <path d="M17 3l0 18" />
                    <path d="M10 18l-3 3l-3 -3" />
                    <path d="M7 21l0 -18" />
                    <path d="M20 6l-3 -3l-3 3" />
                    </svg>
                    <span>
                        Rating
                    </span>
                </x-button>
                <x-button :outline="true">Halal</x-button>
                <x-button :outline="true">Popular</x-button>
                <x-button :outline="true">Newest</x-button>
                <x-button :outline="true">Nearby</x-button>
                <x-button :outline="true">Recommended</x-button>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-2">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex mb-3">
                <lord-icon
                    src="{{ $icon }}"
                    trigger="loop"
                    class="size-12"
                >
                </lord-icon>
                <div class="flex flex-col">
                    <h5 class="flex text-xl font-bold">
                        {{ $title }}
                    </h5>
                    <span class="text-xs">{{ $description }}</span>
                </div>
            </div>
            <div class="mb-3" id="restaurant-list">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    {{ $slot }}
                </div>
            </div>    
        </div>
    </div>
    <div class="flex justify-center mt-4">
        <a href="/list" class="px-4 py-2 text-sm font-semibold text-white bg-primary hover:bg-primary/90 rounded-md transition-all">
            See More
            <i class="ri ri-arrow-right-line"></i>
        </a>
    </div>
</section>

<x-modal title="Filter" id="filterModal">

</x-modal>

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
                        url: '{{ route("location.store") }}',
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
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            Swal.fire({
                                icon: 'error',
                                title: 'Permission Denied',
                                text: 'User denied the request for Geolocation.',
                            });
                            break;
                        case error.POSITION_UNAVAILABLE:
                            Swal.fire({
                                icon: 'error',
                                title: 'Position Unavailable',
                                text: 'Location information is unavailable.',
                            });
                            break;
                        case error.TIMEOUT:
                            Swal.fire({
                                icon: 'error',
                                title: 'Timeout',
                                text: 'The request to get user location timed out.',
                            });
                            break;
                        case error.UNKNOWN_ERROR:
                            Swal.fire({
                                icon: 'error',
                                title: 'Unknown Error',
                                text: 'An unknown error occurred.',
                            });
                            break;
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Geolocation not supported',
                text: 'Your browser does not support geolocation.',
            });
        }
    }

    sendLocation();

    setInterval(sendLocation, 60000);
</script>
@endpush
