@extends('layouts.panel')

@section('content')
    <x-card title="My Points">
        @include('partials.point')
        <table id="datatables" class="display">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Point</th>
                    <th>From</th>
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
            ajax: "{{ route('user.point.get') }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'points',
                    name: 'points'
                },
                {
                    data: 'from',
                    name: 'from'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                }
            ]
        });
    </script>
@endpush
