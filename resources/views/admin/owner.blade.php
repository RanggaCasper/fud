@extends('layouts.panel')

@section('content')
    <x-card title="Manage Ownership">
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Applicant</th>
                    <th>Restaurant</th>
                    <th>Ownership Proof</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

    <x-modal id="updateModal" title="Update Status">
        <form method="POST" id="form_update" data-reset="false">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <x-select label="Status" id="status_update" name="status" :options="[
                    ['value' => 'pending', 'label' => 'Pending'],
                    ['value' => 'approved', 'label' => 'Approved'],
                    ['value' => 'rejected', 'label' => 'Rejected'],
                ]" placeholder="Select Status" />
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
        $('#status_update').on('change', function() {
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
            ajax: "{{ route('admin.owner.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'restaurant.name',
                    name: 'restaurant.name'
                },
                {
                    data: 'proff',
                    name: 'proff'
                },
                {
                    data: 'status',
                    name: 'status'
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
                url: '{{ route('admin.owner.getById', ['id' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#form_update').attr('action', '{{ route('admin.owner.update', ['id' => ':id']) }}'
                        .replace(':id', id));
                        
                    $('#status_update').val(response.data.status).trigger('change');
                    $('#note_update').val(response.data.note); 
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

        $("#datatables").on("click", "[data-delete-id]", function () {
            var id = $(this).data("delete-id");

            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="pt-2 mx-5 mt-4 fs-15">
                            <h4>Are you sure?</h4>
                            <p class="mx-4 mb-0 text-muted">You won't be able to revert this!</p>
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
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: '{{ route("admin.owner.destroy", ["id" => ":id"]) }}'.replace(":id", id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE",
                        },
                        success: function (data) {
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
                        error: function (xhr) {
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
    </script>
@endpush
