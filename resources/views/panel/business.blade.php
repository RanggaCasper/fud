@extends('layouts.panel')

@section('content')
    <x-card title="Claim your restaurant">
        <div class="mb-3">
            <form class="flex items-center mx-auto gap-2">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="ri ri-search-line"></i>
                    </div>
                    <input type="text" id="claim-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full ps-10 p-2.5"
                        placeholder="Search restaurant name..." required />
                </div>
                <x-button type="submit" class="text-nowrap">
                    Claim Now
                </x-button>
            </form>
            <p class="text-sm text-dark">Search your restaurant name and claim to manage details, update menus, and engage
                with customers. Our team will assist you through a quick verification process.</p>
        </div>
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
                    success: function(response) {
                        const updatedResponse = response.replace(/href="([^"]+)"/g, function(match, p1) {
                            if (p1.endsWith('/claim')) return match;
                            return `href="${p1.replace(/\/$/, '')}/claim"`;
                        });

                        $('#claim-results').html(updatedResponse);
                    },
                    error: function(xhr) {
                        console.error('Error sending location:', xhr.responseText);
                    }
                });
            }, 500);
        });
    </script>
@endpush
