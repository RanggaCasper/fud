@extends('layouts.panel')

@section('content')
    <x-card title="Manage Ads">
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Trx ID</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

    <x-modal id="updateModal" title="Update Ads">
        <form method="POST" id="form_update" data-reset="false">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-3 mb-3">
                <div class="flex flex-col items-start">
                    <span class="text-muted font-semibold">Restaurant</span>
                    <span id="ad-restaurant" class="text-secondary text-sm"></span>
                </div>
                <div class="flex flex-col items-start">
                    <span class="text-muted font-semibold">Image</span>
                    <div id="ad-image" class="flex flex-wrap gap-2"></div>
                </div>
            </div>
            <div class="mb-3">
                <x-select label="Approval Status" id="status_update" name="status" :options="[
                    ['value' => 'pending', 'label' => 'Pending'],
                    ['value' => 'approved', 'label' => 'Approved'],
                    ['value' => 'rejected', 'label' => 'Rejected'],
                ]"
                    placeholder="Select Status" />
            </div>
            <div class="mb-3 hidden" id="note_container">
                <x-input label="Note" id="note_update" name="note" type="text"
                    placeholder="Enter Note" />
            </div>
            <x-button label="Submit" type="submit" />
            <x-button label="Reset" type="reset" />
        </form>
    </x-modal>
@endsection

@push('scripts')
    <script>
        $('#status_update').on('change', function () {
            if ($(this).val() === 'rejected') {
                $('#note_container').removeClass('hidden');
            } else {
                $('#note_container').addClass('hidden');
            }
        });

        $('#datatables').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            ajax: "{{ route('admin.ad.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'transaction.transaction_id',
                    name: 'transaction.transaction_id',
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
                    data: 'action',
                    name: 'action',
                },
            ]
        });

        $('#datatables').on('click', '[data-update-id]', function() {
            var id = $(this).data('update-id');
            $.ajax({
                url: '{{ route('admin.ad.getById', ['id' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#form_update').attr('action',
                        '{{ route('admin.ad.update', ['id' => ':id']) }}'
                        .replace(':id', id));
                    $('#note_update').val(response.data.note);
                    $('#status_update').val(response.data.approval_status).trigger('change');
                    
                    $('#ad-restaurant').text(response.data.restaurant.name || '-');
                    
                    let imageUrl = response.data.image ?
                        `{{ Storage::url('') }}` + response.data.image :
                        null;

                    if (imageUrl) {
                        $('#ad-image').html(`
                            <a href="${imageUrl}" target="_blank">
                                <img src="${imageUrl}" class="h-24 rounded border object-cover" />
                            </a>
                        `);
                    } else {
                        $('#ad-image').html(`
                            <div class="text-sm text-gray-500 italic">No image available</div>
                        `);
                    }
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
    </script>
@endpush
