@extends('layouts.panel')

@section('content')
    <x-card title="Manage Ads Type">
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

    <x-modal id="updateModal" title="Update Ads Type">
        <form method="POST" id="form_update" data-reset="false">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <x-input label="Price" id="price" name="base_price" placeholder="Price" type="number" />
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
            ajax: "{{ route('admin.ad.type.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'base_price',
                    name: 'base_price',
                    render: function(data, type, row) {
                        return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    }
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
                url: '{{ route('admin.ad.type.getById', ['id' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#form_update').attr('action',
                        '{{ route('admin.ad.type.update', ['id' => ':id']) }}'
                        .replace(':id', id));
                    $('#price').val(response.data.base_price);
                },
                error: function(error) {
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat mengambil data kategori.',
                        'error'
                    );
                }
            });
        });
    </script>
@endpush
