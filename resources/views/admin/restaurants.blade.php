@extends('layouts.panel')

@section('content')
<div class="flex flex-col space-y-6">
    <x-card title="Get Restaurant">
        <div id="map" class="h-64 mb-3" style="z-index: 1;"></div>
        <form action="{{ route('admin.restaurant.fetch') }}" method="POST">
            @csrf
            <div class="mb-3">
                <x-input label="Latitude" id="lat" name="lat" placeholder="Latitude" type="text" readonly />
            </div>
            <div class="mb-3">
                <x-input label="Longitude" id="lon" name="lon" placeholder="Longitude" type="text" readonly />
            </div>
            <x-button type="submit">
                Fetch
            </x-button>
        </form>
    </x-card>
    <x-card title="Restaurants Data">
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>
</div>
@endsection

@push('scripts')
    <script>
        $('#datatables').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            ajax: "{{ route('admin.restaurant.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        $('#datatables').on('click', '[data-update-id]', function() {
            var id = $(this).data('update-id');
            $.ajax({
                url: '{{ route('admin.restaurant.getById', ['id' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#form_update').attr('action',
                        '{{ route('admin.restaurant.update', ['id' => ':id']) }}'.replace(':id', id)
                        );
                    $('#name_update').val(response.data.name);
                    $('#restaurantname_update').val(response.data.restaurantname);
                    $('#email_update').val(response.data.email);
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

        $("#datatables").on("click", "[data-delete-id]", function() {
            var id = $(this).data("delete-id");

            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" delay="2000" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="pt-2 mx-5 mt-4 fs-15">
                            <h5 class="font-semibold text-xl">Are you sure?</h5>
                            <p class="mx-4 mb-0">You won't be able to revert this!</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary btn-md mx-1",
                    cancelButton: "btn btn-danger btn-md mx-1",
                },
                confirmButtonText: "Yes, Delete!",
                buttonsStyling: false,
                showCloseButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.restaurant.destroy', ['id' => ':id']) }}'.replace(
                            ":id", id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE",
                        },
                        success: function(data) {
                            Swal.fire({
                                html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                        <div class="pt-2 mt-4 fs-15">
                                            <h4>Success!</h4>
                                            <p class="mx-4 mb-0 text-muted">${data.message}</p>
                                        </div>
                                    </div>
                                `,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary btn-md mx-1",
                                },
                                cancelButtonText: "Back",
                                buttonsStyling: false,
                                showCloseButton: true,
                            });
                            $("#datatables").DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            let response = xhr.responseJSON;
                            let message;

                            if (response.errors) {
                                message = response.errors;
                            } else {
                                message = response.message;
                            }

                            Swal.fire({
                                html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                                        <div class="pt-2 mt-4 fs-15">
                                            <h4>Oops!</h4>
                                            <p class="mx-4 mb-0 text-muted">${message}</p>
                                        </div>
                                    </div>
                                `,
                                showCancelButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    cancelButton: "btn btn-primary btn-md mx-1",
                                },
                                cancelButtonText: "Back",
                                buttonsStyling: false,
                                showCloseButton: true,
                            });
                        },
                    });
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
