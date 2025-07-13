@extends('layouts.app')
@section('title', 'Claim Your Restaurant - Fudz!')

@section('content')
    <div class="mt-[72px]">
        <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-3"
            id="restaurant-detail">
            <div class="max-w-screen-xl mx-auto px-4 md:px-0 py-6">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-8">
                        <x-card.card title="Claim Your Restaurant">
                            <form method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="relative">
                                        <x-filepond class="filepond-document" label="Upload Proof of Ownership"
                                            name="ownership_proof" id="image" />
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="mt-4">
                                    <x-button type="submit">Submit</x-button>
                                </div>
                            </form>
                        </x-card.card>
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <x-card.card>
                            <img src="{{ $restaurant->thumbnail }}" class="aspect-square w-full h-64 rounded-lg mb-3"
                                alt="{{ $restaurant->name }}">
                            <h5 class="font-semibold text-2xl">{{ $restaurant->name }}</h5>
                            @php
                                $googleRating = $restaurant->rating ?? 0;
                                $fudRating = $restaurant->reviews()->avg('rating') ?? 0;
                                $combinedRating =
                                    $googleRating && $fudRating
                                        ? number_format(($googleRating + $fudRating) / 2, 1)
                                        : number_format($googleRating ?: $fudRating, 1);
                            @endphp
                            <span class="text-sm"><i class="ti ti-star-filled text-warning"></i> {{ $combinedRating }} (
                                {{ number_format($restaurant->reviews()->count() + $restaurant->reviews, 0, ',', '.') }}
                                Reviews )</span>
                            <p class="text-sm text-muted mt-2">{{ $restaurant->address }}</p>
                        </x-card.card>
                        <span class="text-sm text-muted mt-2">
                            Looking for more restaurants? <a class="underline hover:text-primary"
                                href="{{ route('list') }}">Check them out</a>
                        </span>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
