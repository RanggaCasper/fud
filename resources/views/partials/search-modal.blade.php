<!-- Modal Search -->
<div id="searchModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Header: Search Bar -->
            <div class="sticky top-0 z-10 bg-white flex flex-col gap-4 p-4 md:p-5 border-b rounded-t border-gray-300">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="ti ti-search text-gray-500"></i>
                    </div>
                    <input type="text" id="simple-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-10 p-2.5"
                        placeholder="Search restaurant..." autofocus required />
                </div>
            </div>

            <!-- Result -->
            <div class="p-4 md:p-5 space-y-4" id="search-results">
                <div class="text-muted text-sm">
                    <p>Type to search for restaurants...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            let searchTimeout;
            $('#simple-search').on('input', function() {
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: '{{ route('search') }}',
                        method: 'GET',
                        data: {
                            search: $('#simple-search').val()
                        },
                        success: function(response) {
                            $('#search-results').html(response);
                        },
                        error: function(xhr) {
                            console.error('Error sending location:', xhr.responseText);
                        }
                    });
                }, 500);
            });

            function sendLocation() {
                if (!navigator.geolocation) {
                    alert("Geolocation tidak didukung browser Anda.");
                    return;
                }

                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || 'Asia/Makassar';

                    $('#preset-location').val('');
                    localStorage.setItem('selectedLocation', '');

                    $.ajax({
                        url: '{{ route('location.store') }}',
                        method: 'POST',
                        data: {
                            latitude: latitude,
                            longitude: longitude,
                            timezone: timezone,
                            value: '',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            const formData = $('#filter-form').serialize();
                            fetchRestaurants(formData || null);
                            console.log('Location sent:', response);
                        },
                        error: function(xhr) {
                            console.error('Error sending location:', xhr.responseText);
                        }
                    });
                }, function(error) {
                    alert("Gagal mengambil lokasi: " + error.message);
                });
            }

            $(document).ready(function() {
                const label = localStorage.getItem('selectedLocationLabel');
                if (label) {
                    $('#locationDropdown').prev('button').find('span').text(label);
                } else {
                    sendLocation();
                }

                $(document).on('click', '#locationDropdown a', function(e) {
                    e.preventDefault();

                    const lat = $(this).data('lat');
                    const lng = $(this).data('lng');
                    const name = $(this).text();

                    $('#locationDropdown').prev('button').find('span').text(name);
                    $('#locationDropdown').addClass('hidden');
                    localStorage.setItem('selectedLocationLabel', name);

                    if (!lat || !lng) {
                        sendLocation();
                        return;
                    }

                    $.post('{{ route('location.store') }}', {
                        latitude: lat,
                        longitude: lng,
                        timezone: 'Asia/Makassar',
                        value: name,
                        _token: '{{ csrf_token() }}'
                    }).done(function(res) {
                        const formData = $('#filter-form').serialize();
                        fetchRestaurants(formData || null);
                    }).fail(function(xhr) {
                        console.error('Error:', xhr.responseText);
                    });
                });
            });
        </script>
    @endpush
@endonce
