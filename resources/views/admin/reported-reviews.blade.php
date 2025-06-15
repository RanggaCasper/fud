@extends('layouts.panel')

@section('content')
<x-card title="Manage Reported Reviews">
    <table id="datatables" class="display">
        <thead>
            <tr>
                <th>NO</th>
                <th>Reporting</th>
                <th>Comment</th>
                <th>Restaurant</th>
                <th>Reason</th>
                <th>Reported By</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</x-card>
@endsection

@push('scripts')
    <script>
        $('#datatables').DataTable(
            {
                processing: true,
                serverSide: false,
                scrollX: true,  
                ajax: "{{ route('admin.reported-reviews.get') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'review.user.name', name: 'review.user.name' },
                    { data: 'review.comment', name: 'review.comment' },
                    { data: 'review.restaurant.name', name: 'review.restaurant.name' },
                    { data: 'reason', name: 'reason' },
                    { data: 'user.name', name: 'user.name' },
                    // { data: 'action', name: 'action' }
                ]
            }
        );
    </script>
@endpush    