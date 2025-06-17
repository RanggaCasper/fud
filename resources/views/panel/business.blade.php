@extends('layouts.panel')

@section('content')
<x-card title="Claim your restaurant">
    <div class="mb-3">
        <form class="flex items-center mx-auto gap-2">
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="ri ri-search-line"></i>
                </div>
                <input type="text" id="simple-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                    placeholder="Search restaurant name..." required />
            </div>
            <x-button type="submit" class="text-nowrap">
                Claim Now
            </x-button>
        </form>
        <p class="text-sm text-dark">Search your restaurant name and claim to manage details, update menus, and engage with customers. Our team will assist you through a quick verification process.</p>
    </div>
    <div class="mb-3">
       
    </div>

</x-card>
{{-- <div class="flex items-center w-full my-4">
    <span class="flex-grow border-t border-gray-300"></span>
    <span class="mx-4 text-sm font-medium text-gray-500">OR</span>
    <span class="flex-grow border-t border-gray-300"></span>
</div>
<x-card title="Add Restaurant">
    <form method="POST">
        @csrf
        <div class="mb-3">
            <div class="grid grid-cols-2 gap-3">
                <x-input
                    label="Restaurant Name"
                    name="name"
                    placeholder="Enter restaurant name"
                    required
                />
                <x-input
                    label="Business Number"
                    name="business_number"
                    placeholder="Enter business number"
                    required
                />
                <x-input
                    label="Address"
                    name="address"
                    placeholder="Enter address"
                    required
                />
                <x-input
                    label="Restaurant Website"
                    name="website"
                    placeholder="Enter restaurant website"
                    required
                />
            </div>
        </div>
        <x-button type="submit">Add Restaurant</x-button>
        <x-button type="reset">Reset</x-button>
        <p class="mt-2 text-sm text-gray-500">Submit your restaurant to appear on {{ config('app.name') }} and reach more customers. All submissions go through a quick verification process to ensure accuracy and we’ll notify you once it’s approved and published.</p>
    </form>
</x-card> --}}
@endsection