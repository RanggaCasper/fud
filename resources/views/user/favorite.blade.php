@extends('layouts.panel')

@section('content')
<x-card title="My Favorite">
    <div class="mb-3">
        <div class="grid grid-cols-12 gap-6">
                @forelse ($favorites as $favorite)
                    <div class="col-span-12 md:col-span-6">
                        <x-card.restaurant-card :title="$favorite->restaurant->name" :slug="Str::slug($favorite->restaurant->name)" :rating="$favorite->restaurant->rating" :reviews="$favorite->restaurant->reviews"
                            :location="$favorite->restaurant->address" :image="$favorite->restaurant->thumbnail" :isPromotion="false" :isClosed="$favorite->restaurant->isClosed()"
                            :isHalal="$favorite->restaurant->offerings->contains(function ($offering) {
                                return str_contains(strtolower($offering->name), 'halal');
                            })" />
                    </div>
                @empty
                    <div class="col-span-12">
                        <div class="mt-6">
                            <img src="{{ asset('assets/svg/undraw_empty_4zx0.svg') }}" class="h-64 mx-auto"
                                alt="No favorites">
                            <div class="text-center text-muted font-semibold mt-3">
                                You haven't made any favorites yet.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $favorites->links() }}
            </div>
        </div>
    </div>
</x-card>
@endsection