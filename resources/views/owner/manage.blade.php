@extends('layouts.panel')

@section('content')
    <x-card.card title="Manage Restaurant">
        <form method="POST" data-reset="false">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <x-input label="Name" id="name" name="name" value="{{ Auth::user()->owned->restaurant->name }}"
                    type="name" />
            </div>
            <div class="mb-3">
                <x-input label="Phone" id="phone" name="phone" value="{{ Auth::user()->owned->restaurant->phone }}"
                    type="text" :required="false" />
            </div>
            <div class="mb-3">
                <x-input label="Website" id="Website" name="Website"
                    value="{{ Auth::user()->owned->restaurant->website }}" type="text" :required="false" />
            </div>
            <div class="mb-3">
                <x-input label="Reservation Link" id="reservation_link" name="reservation_link"
                    value="{{ Auth::user()->owned->restaurant->reservation_link }}" type="url" :required="false" />
            </div>
            <div class="mb-3">
                <x-input label="Address" id="address" name="address"
                    value="{{ Auth::user()->owned->restaurant->address }}" type="text" />
            </div>
            <div class="mb-3">
                <x-input label="Description" id="description" name="description"
                    value="{{ Auth::user()->owned->restaurant->description }}" type="text" :required="false" />
            </div>
            <x-button type="submit">Submit</x-button>
        </form>
    </x-card.card>
@endsection
