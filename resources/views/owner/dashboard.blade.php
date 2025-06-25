@extends('layouts.panel')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="col-span-1">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="flex items-center justify-between p-3 gap-3 border-b border-gray-200">
                <div class="bg-primary/10 p-3 rounded-lg inline-flex items-center justify-center">
                    <div class="bg-primary p-2 rounded-lg inline-flex items-center justify-center">
                        <i class="ti ti-users text-white text-lg"></i>
                    </div>
                </div>
                <div class="w-full">
                    <h5 class="text-xl font-semibold">{{ $userCount }}</h5>
                    <p class="text-sm text-gray-500">Total Users</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-1">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="flex items-center justify-between p-3 gap-3 border-b border-gray-200">
                <div class="bg-primary/10 p-3 rounded-lg inline-flex items-center justify-center">
                    <div class="bg-primary p-2 rounded-lg inline-flex items-center justify-center">
                        <i class="ti ti-chef-hat text-white text-lg"></i>
                    </div>
                </div>
                <div class="w-full">
                    <h5 class="text-xl font-semibold">{{ $restaurantCount }}</h5>
                    <p class="text-sm text-gray-500">Total Restaurants</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection