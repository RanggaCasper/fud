@extends('layouts.panel')

@section('content')
    <x-card title="Create Ads" class="max-w-2xl mx-auto">
        <form action="{{ route('owner.ads.store') }}" method="POST" enctype="multipart/form-data">
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
                <x-filepond class="filepond-image" label="Carousel Image" name="image" id="image"
                    :required="false" />
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
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Trx ID</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>End Date</th>
                    <th>Approval</th>
                    <th>Paid At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>
@endsection

@push('scripts')
    <script>
        $('#datatables').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            ajax: "{{ route('owner.ads.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'transaction_id',
                    name: 'transaction_id',
                },
                {
                    data: 'total_cost',
                    name: 'total_cost',
                    render: function(data, type, row) {
                        return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    }
                },
                {
                    data: 'ads_type.name',
                    name: 'ads_type.name',
                },
                {
                    data: 'end_date',
                    name: 'end_date',
                },
                {
                    data: 'approval_status',
                    name: 'approval_status',
                },
                {
                    data: 'paid_at',
                    name: 'paid_at',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
            ]
        });

        $(document).ready(function() {
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
