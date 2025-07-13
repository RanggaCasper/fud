@extends('layouts.panel')

@section('content')
    <x-card title="Create Ads" class="max-w-2xl mx-auto">
        <form action="{{ route('owner.ads.store') }}" method="POST" data-fetch="fetchData" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                @php
                    $ads = \App\Models\AdsType::all()
                        ->map(function ($ad) {
                            return [
                                'value' => $ad->id,
                                'label' =>
                                    ucfirst($ad->name) .
                                    ' - Rp. ' .
                                    number_format($ad->base_price, 0, ',', '.') .
                                    '/days',
                            ];
                        })
                        ->toArray();
                @endphp
                <x-select label="Ad Type" id="ad_type" name="ad_type" :options="$ads" placeholder="Select Ad Type" />
            </div>

            <div class="hidden mb-3">
                <x-filepond class="filepond-image" :maxFiles="1" label="Carousel Image" name="image" id="image" />
                <span class="text-xs text-gray-500 italic">* Recommended image ratio: 37:10 for optimal display</span>
            </div>

            <div class="mb-3">
                <x-input label="Run Length (in days)" id="run_length" name="run_length" type="number" min="1"
                    placeholder="Enter Run Length (in days)" />
            </div>

            <div class="mb-3">
                <x-input label="Price" id="price" name="price" type="text" disabled />
            </div>

            <x-button type="submit">Create Ad</x-button>
        </form>
    </x-card>

    <x-card title="Ads List">
        <div id="ads-list">

        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        function fetchData() {
            $.ajax({
                url: "{{ route('owner.ads.get') }}",
                method: "GET",
                success: function(response) {
                    $('#ads-list').html(response.data.html);
                },
                error: function(xhr) {
                    console.error('Error fetching ads:', xhr);
                }
            });
        }

        $(document).ready(function() {
            fetchData();

            const $adTypeSelect = $('#ad_type');
            const $runLengthInput = $('#run_length');
            const $priceInput = $('#price');
            const $carouselImageDiv = $('#image').closest('.mb-3');

            function extractBasePrice(labelText) {
                const regex = /Rp\.\s?([\d.]+)/i;
                const match = labelText.match(regex);
                if (match && match[1]) {
                    const raw = match[1].replace(/\./g, '');
                    return parseFloat(raw);
                }
                return 0;
            }

            function formatRupiah(value) {
                return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function updateForm() {
                const labelText = $adTypeSelect.find('option:selected').text().toLowerCase();
                const basePrice = extractBasePrice(labelText);
                const runLength = parseInt($runLengthInput.val() || 0);

                if (!basePrice || !runLength || runLength <= 0) {
                    $priceInput.val('');
                } else {
                    const total = basePrice * runLength;
                    $priceInput.val(formatRupiah(total));
                }

                if (labelText.includes('carousel')) {
                    $carouselImageDiv.removeClass('hidden');
                } else {
                    $carouselImageDiv.addClass('hidden');
                }
            }

            $adTypeSelect.on('change', updateForm);
            $runLengthInput.on('input', updateForm);

            updateForm();
        });
    </script>
@endpush
