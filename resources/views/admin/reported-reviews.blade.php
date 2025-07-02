@extends('layouts.panel')

@section('content')
    <x-card title="Reported Reviews">
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Reporting</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

    <x-modal id="viewModal" title="View Reported Review">
        <div class="space-y-4">
            <div class="flex flex-col gap-3">
                <div class="flex flex-col items-start">
                    <span class="text-muted font-semibold">User</span>
                    <span id="review-user" class="text-secondary text-sm"></span>
                </div>

                <div class="flex flex-col items-start">
                    <span class="text-muted font-semibold">Comment</span>
                    <span id="review-comment" class="text-secondary text-sm"></span>
                </div>

                <div class="flex flex-col items-start">
                    <span class="text-muted font-semibold">Attachments</span>
                    <div id="review-attachments" class="flex flex-wrap gap-2"></div>
                </div>
            </div>

            <div>
                <span class="text-muted font-semibold">Report Reasons</span>
                <div id="reason-list" class="list-disc"></div>
            </div>
            
            <form method="POST" id="form_view">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <x-button type="submit" class="btn btn-danger">Delete Review</x-button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection

@push('scripts')
    <script>
        $('#datatables').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            ajax: "{{ route('admin.reported-reviews.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'comment',
                    name: 'comment'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        $('#datatables').on('click', '[data-view-id]', function() {
            var id = $(this).data('view-id');
            $.ajax({
                url: `{{ route('admin.reported-reviews.getById', ['id' => ':id']) }}`.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    const data = response.data;
                    const review = data.review;
                    const reasonCount = data.reasonCount;

                    // Set form action
                    $('#form_view').attr(
                        'action',
                        `{{ route('admin.reported-reviews.destroy', ['id' => ':id']) }}`.replace(
                            ':id', review.id)
                    );

                    $('#review-user').text(review.user?.name || '-');
                    $('#review-restaurant').text(review.restaurant?.name || '-');
                    $('#review-rating').text(review.rating);
                    $('#review-comment').text(review.comment);

                    let html = '';
                    for (const [key, value] of Object.entries(reasonCount)) {
                        html += `
        <div class="flex items-center justify-between bg-gray-100 border border-gray-300 rounded px-3 py-2 mb-2 shadow-sm">
            <span class="capitalize font-medium text-gray-700">${key.replace(/_/g, ' ')}</span>
            <span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">${value}</span>
        </div>`;
                    }
                    $('#reason-list').html(html);


                    const attachments = review.attachments || [];

                    let attachmentsHtml = '';
                    if (response.data.review.attachments.length > 0) {
                        response.data.review.attachments.forEach(attachment => {
                            const imageUrl = `{{ Storage::url('') }}` + attachment.source;
                            attachmentsHtml += `
                                <a href="${imageUrl}" target="_blank">
                                    <img src="${imageUrl}" class="h-24 rounded border object-cover" />
                                </a>`;
                        });
                    } else {
                        attachmentsHtml =
                            `<p class="text-sm text-gray-500 italic">No attachments available.</p>`;
                    }

                    $('#review-attachments').html(attachmentsHtml);
                },
                error: function(error) {
                    console.error(error);
                    Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data review.', 'error');
                }
            });
        });
    </script>
@endpush
