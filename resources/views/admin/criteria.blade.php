@extends('layouts.panel')

@section('content')
    <x-card title="Manage Criteria">
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Title</th>
                    <th>Weight</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

    <x-card title="Simulate Criteria">
        <div id="map" class="h-64 mb-3" style="z-index: 1;"></div>
        <div class="mb-3">
            <x-input label="Latitude" id="lat" name="lat" placeholder="Latitude" type="text" readonly />
        </div>
        <div class="mb-3">
            <x-input label="Longitude" id="lon" name="lon" placeholder="Longitude" type="text" readonly />
        </div>
        <x-button id="btnSimulate" type="submit">
            Simulate
        </x-button>
    </x-card>

    <x-card title="Simulate Results">
        <table id="simulateDatatables" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Reviews</th>
                    <th>Distance (km)</th>
                    <th>Promotion</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

    <x-modal id="updateModal" title="Update Criteria">
        <form method="POST" id="form_update" data-reset="false">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <x-input label="Name" id="name_update" name="name" placeholder="Name" type="text" />
            </div>
            <div class="mb-3">
                <x-input label="Weight" id="weight_update" name="weight" placeholder="Weight" type="number"
                    step="0.01" />
            </div>
            <div class="mb-3">
                <x-select label="Type" id="type_update" name="type" :options="[['value' => 'benefit', 'label' => 'Benefit'], ['value' => 'cost', 'label' => 'Cost']]" />
            </div>
            <x-button label="Submit" type="submit" />
            <x-button label="Reset" type="reset" />
        </form>
    </x-modal>
@endsection

@push('scripts')
    <script>
        $('#datatables').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            ajax: "{{ route('admin.criteria.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'weight',
                    name: 'weight',
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        datatableSimulate = $('#simulateDatatables').DataTable({
            scrollX: true,
        });

        $('#btnSimulate').on('click', function() {
            const lat = $('#lat').val();
            const lon = $('#lon').val();
            console.log(lat, lon);

            if (!lat || !lon) {
                alert('Please select a location first.');
                return;
            }
            
            if (datatableSimulate) {
                datatableSimulate.destroy();
            }

            datatableSimulate = $('#simulateDatatables').DataTable({
                processing: true,
                serverSide: false,
                scrollX: true,
                ajax: {
                    url: '{{ route('admin.criteria.simulate.get') }}',
                    type: 'GET',
                    data: {
                        lat: lat,
                        long: lon,
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'rating'
                    },
                    {
                        data: 'reviews'
                    },
                    {
                        data: 'distance'
                    },
                    {
                        data: 'promotion'
                    },
                    {
                        data: 'score'
                    },
                ]
            });
        });

        $('#datatables').on('click', '[data-update-id]', function() {
            var id = $(this).data('update-id');
            $.ajax({
                url: '{{ route('admin.criteria.getById', ['id' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#form_update').attr('action',
                        '{{ route('admin.criteria.update', ['id' => ':id']) }}'
                        .replace(':id', id));
                    $('#name_update').val(response.data.name);
                    $('#weight_update').val(response.data.weight);
                    console.log(response.data.type);
                    $('#type_update').val(response.data.type).trigger('change');
                },
                error: function(error) {
                    console.error(error);
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat mengambil data kategori.',
                        'error'
                    );
                }
            });
        });

        // Leaflet
        var map = L.map('map').setView([-8.409518, 115.188919], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([-8.409518, 115.188919], {
            draggable: true
        }).addTo(map);
        marker.bindPopup("<b>Click on the map to move me!</b>").openPopup();

        map.on('click', function(e) {
            var latlng = e.latlng; // Mendapatkan koordinat tempat diklik
            marker.setLatLng(latlng); // Memindahkan marker ke posisi yang diklik

            document.getElementById("lat").value = latlng.lat.toFixed(5);
            document.getElementById("lon").value = latlng.lng.toFixed(5);

            // Update popup posisi marker
            marker.setPopupContent("<b>Moved to this location!</b><br>Lat: " + latlng.lat.toFixed(5) + "<br>Lon: " +
                latlng.lng.toFixed(5));
        });

        // Menampilkan koordinat awal marker
        var initialLatLng = marker.getLatLng();
        document.getElementById("lat").value = initialLatLng.lat.toFixed(5);
        document.getElementById("lon").value = initialLatLng.lng.toFixed(5);
    </script>
@endpush
