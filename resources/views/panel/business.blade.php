@extends('layouts.panel')

@section('content')
    <x-card title="Claim your restaurant">
        <div class="mb-3">
            <form class="flex items-center mx-auto gap-2 mb-2">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="ri ri-search-line"></i>
                    </div>
                    <input type="text" id="claim-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-10 p-2.5"
                        placeholder="Search restaurant name..." required />
                </div>
            </form>
            <p class="text-sm text-dark">Search your restaurant name and claim to manage details, update menus, and engage
                with customers. Our team will assist you through a quick verification process.</p>
        </div>
        <h5 class="text-sm font-semibold">Result</h5>
        <div class="mb-3" id="claim-results">
            <div class="text-muted text-sm">
                <p>Type to search for restaurants...</p>
            </div>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        $('#claim-search').on('input', function() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: '{{ route('search') }}',
                    method: 'GET',
                    data: {
                        search: $('#claim-search').val()
                    },
                    beforeSend: function() {
                        $('#claim-results').html('<div class="text-muted text-sm">Searching...</div>');
                    },
                    success: function(response) {
                        const $html = $('<div>').html(response);

                        $html.find('a[href]').each(function() {
                            const href = $(this).attr('href');
                            if (!href.endsWith('/claim')) {
                                $(this).attr('href', href.replace(/\/$/, '') +
                                '/claim');
                            }
                        });

                        $html.find('.col-span-1').filter(function() {
                            return $(this).text().includes(
                                'Tap to explore restaurants in this area');
                        }).remove();


                        $('#claim-results').html($html);
                    },
                    error: function(xhr) {
                        console.error('Error sending location:', xhr.responseText);
                    }
                });
            }, 500);
        });
    </script>
@endpush
