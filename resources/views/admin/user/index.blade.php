@extends('layouts.panel')

@section('content')
<x-card title="Manage User">
    <x-button label="Create" data-modal-target="createModal" data-modal-toggle="createModal" />
    <table id="datatables" class="display">
        <thead>
            <tr>
                <th>NO</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</x-card>

<!-- Modal -->
<x-modal id="createModal" title="Create User">
    <form method="POST">
        @csrf
        <div class="mb-3">
            <x-input 
                label="Name"
                id="name"
                name="name" 
                placeholder="Name" 
                type="text"
            />
        </div>
        <div class="mb-3">
            <x-input 
                label="Username"
                id="username"
                name="username" 
                placeholder="Username" 
                type="text"
            />
        </div>
        <div class="mb-3">
            <x-input 
                label="Email"
                id="email"
                name="email" 
                placeholder="Email" 
                type="email"
            />
        </div>
        <x-button label="Submit" type="submit" />
        <x-button label="Reset" type="reset" />
    </form>
</x-modal>

<x-modal id="updateModal" title="Update User">
    <form method="POST" id="form_update">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <x-input 
                label="Name"
                id="name_update"
                name="name" 
                placeholder="Name" 
                type="text"
            />
        </div>
        <div class="mb-3">
            <x-input 
                label="Username"
                id="username_update"
                name="username" 
                placeholder="Username" 
                type="text"
            />
        </div>
        <div class="mb-3">
            <x-input 
                label="Email"
                id="email_update"
                name="email" 
                placeholder="Email" 
                type="email"
            />
        </div>
        <x-button label="Submit" type="submit" />
        <x-button label="Reset" type="reset" /> 
    </form>
</x-modal>
@endsection

@push('scripts')
    <script>
        $('#datatables').DataTable(
            {
                processing: true,
                serverSide: false,
                ajax: "{{ route('admin.user.get') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action' }
                ]
            }
        );

        $('#datatables').on('click', '[data-update-id]', function() {
            var id = $(this).data('update-id');
            $.ajax({
                url: '{{ route("admin.user.getById", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#form_update').attr('action', '{{ route("admin.user.update", ["id" => ":id"]) }}'.replace(':id', id));
                    $('#name_update').val(response.data.name);
                    $('#username_update').val(response.data.username);
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
                        url: '{{ route("admin.user.destroy", ["id" => ":id"]) }}'.replace(":id", id),
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