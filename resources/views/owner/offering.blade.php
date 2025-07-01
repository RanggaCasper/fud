@extends('layouts.panel')

@section('content')
    <x-card.card title="Manage Offerings">
        <form method="POST" data-reset="false">
            @csrf
            @method('PUT')
            @php
                $ownedOfferings = Auth::user()->owned->restaurant->offerings;
                $offerings = \App\Models\Restaurant\Offering::select('name')->groupBy('name')->orderBy('name')->get();
            @endphp
            <div class="grid grid-cols-2">
                @foreach ($offerings as $index => $offering)
                    <div class="flex items-center mb-4">
                        <input id="offering-checkbox-{{ $index }}" type="checkbox" name="offerings[]"
                            value="{{ $offering->name }}"
                            class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded-sm focus:ring-primary focus:ring-2"
                            @checked($ownedOfferings->pluck('name')->contains($offering->name))>
                        <label for="offering-checkbox-{{ $index }}" class="ms-2 text-sm font-medium text-gray-900">
                            {{ $offering->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <x-button type="submit">Submit</x-button>
            <x-button type="reset">Reset</x-button>
        </form>
    </x-card.card>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('input[name="offerings[]"]').on('change', function() {
                const checked = $('input[name="offerings[]"]:checked').length;

                if (checked > 8) {
                    this.checked = false;
                    Swal.fire({
                        html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/azxkyjta.json" trigger="loop" style="width:100px;height:100px"></lord-icon>
                    <div class="pt-2 mx-5 mt-4 fs-15">
                        <h4 class="text-2xl font-semibold text-muted">Oops!!</h4>
                        <p class="mx-4 mb-0 text-muted">You can only select up to 8 offerings.</p>
                    </div>
                </div>
            `,
                        customClass: {
                            confirmButton: "btn btn-primary btn-md mx-1",
                        },
                    });
                }
            });
        });
    </script>
@endpush
