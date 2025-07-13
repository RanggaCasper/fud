@extends('layouts.panel')

@section('content')
    @php
        $userClaim = \App\Models\Restaurant\Claim::with('restaurant')
            ->where('user_id', auth()->id())
            ->first();
    @endphp

    @if ($userClaim)
        <x-card title="Your Claim Status">
            <img src="{{ $userClaim->restaurant->thumbnail ?? '/images/default-restaurant.jpg' }}" alt="Thumbnail"
                class="w-24 h-24 object-cover rounded-md">


            <div class="flex-1">
                <a href="{{ route('restaurant.index', ['slug' => $userClaim->restaurant->slug]) }}"
                    class="text-lg font-semibold text-primary hover:underline">
                    {{ $userClaim->restaurant->name }}
                </a>
                <div class="text-sm text-gray-600">
                    Status: <span
                        class="font-medium {{ $userClaim->status === 'approved'
                            ? 'text-success'
                            : ($userClaim->status === 'pending'
                                ? 'text-warning'
                                : 'text-danger') }}">
                        {{ ucfirst($userClaim->status) }}
                    </span>
                </div>

                <div class="text-sm text-gray-600">
                    Document: <a href="{{ Storage::url($userClaim->ownership_proof) }}"
                        class="text-primary hover:underline" target="_blank">View Proof</a> 
                </div>

                <div class="text-xs text-gray-500">
                    Updated on {{ $userClaim->updated_at->format('d M Y') }}
                </div>

                @if ($userClaim->status === 'rejected' && $userClaim->note)
                    <div class="mt-3">
                        <x-alert type="danger">
                            <strong>Note : </strong> {{ $userClaim->note }}
                        </x-alert>
                    </div>

                    <form method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="relative">
                                <x-filepond class="filepond-document" label="Update Proof of Ownership"
                                    name="ownership_proof" id="image" />
                            </div>
                        </div>

                        <x-button type="submit">Submit</x-button>
                    </form>
                @endif
            </div>
            <span class="text-xs text-gray-500">* If you want to claim another restaurant, please contact <a href="mailto:support@fudz.my.id">support@fudz.my.id</a>.</span>
        </x-card>
    @endif


    <x-card title="Find and Claim Your Restaurant">
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
                        $('#claim-results').html(
                            '<div class="text-muted text-sm">Searching...</div>');
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
