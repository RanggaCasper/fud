@extends('layouts.app')
@section('showNavbot', true)

@section('header')
    <x-section.hero-section :videoSource="asset('assets/video/IMG_44891.mp4')" title="Are you Hungry?"
        description="Discover your next favorite meal, whether you're craving a quick snack or a full-course feast."
        scrollToId="#restaurant">
        <div class="flex space-x-2">
            <a href="#">
                <img src="https://lh3.googleusercontent.com/zWYJUppfU-TunHSxKMA6i1LRpv2POWaGCOOcvwR2h1E_R8LZ3RCiMUgbyxJDGFQqePR3G5BA3MdpUw4_BtQ_mefV36WH3tnBrV3ZkuSj=e365-pa-nu-s0"
                    class="w-50" alt="">
            </a>
            <a href="#">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/2560px-Download_on_the_App_Store_Badge.svg.png"
                    class="w-50" alt="">
            </a>
        </div>
    </x-section.hero-section>

@endsection

@section('content')
    <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6" id="restaurant">
        <div class="px-4 md:px-2">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex mb-3">
                    <lord-icon src="https://cdn.lordicon.com/tqvrfslk.json" trigger="loop" class="size-12">
                    </lord-icon>
                    <div class="flex flex-col">
                        <h5 class="flex text-lg font-bold">
                            Dine Around You
                        </h5>
                        <span class="text-xs">Popular picks, tasty bites, near you. All ready to explore!</span>
                    </div>
                </div>
                <div class="mb-3" id="restaurant-list">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        @foreach ($ranked->take(6) as $restaurant)
                            <x-card.restaurant-card :title="$restaurant->name" :slug="Str::slug($restaurant->name)" :rating="$restaurant->rating" :reviews="$restaurant->reviews"
                                :location="$restaurant->address" :distance="$restaurant->distance . 'km'" :image="$restaurant->thumbnail" :isPromotion="false"
                                :isClosed="$restaurant->isClosed()" :isHalal="$restaurant->offerings->contains(function ($offering) {
                                    return str_contains(strtolower($offering->name), 'halal');
                                })" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <a href="{{ route('list') }}" class="btn btn-md btn-primary btn-icon">
                See More
                <i class="ti ti-arrow-right text-lg"></i>
            </a>
        </div>
    </section>

    <section class="px-4 md:px-2 py-6 bg-primary" id="review">
        <div class="max-w-screen-xl py-4 mx-auto">
            <div class="flex text-white mb-3">
                <lord-icon src="https://cdn.lordicon.com/abhwievu.json" trigger="loop" class="size-12">
                </lord-icon>
                <div class="flex flex-col">
                    <h5 class="flex text-lg font-bold">
                        Every Bite Has a Story
                    </h5>
                    <span class="text-xs">Real reviews, honest bites. See what people are loving to eat!</span>
                </div>
            </div>
            <div class="swiper">
                <div class="swiper-wrapper py-3">
                    @foreach ($comments as $comment)
                        <div class="swiper-slide">
                            <x-card.review-card :userName="$comment->user->name" :commentDate="$comment->created_at->format('d M Y')" :userImage="$comment->user->avatar" :rating="$comment->rating"
                                :restaurantName="$restaurant->name" :commentImage="$comment->image" :commentText="$comment->comment" :commentId="$comment->id" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <a href="{{ route('reviews') }}" class="btn btn-md btn-warning btn-icon">
                    Explore
                    <i class="ti ti-arrow-right text-lg"></i>
                </a>
            </div>
        </div>
    </section>

    @include('partials.faq')

@endsection

@push('scripts')
    <script>
        let sendLocation = () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                        $.ajax({
                            url: '{{ route('location.store') }}',
                            method: 'POST',
                            data: {
                                latitude: lat,
                                longitude: lng,
                                timezone: timezone,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                console.log('Location sent successfully:', response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error sending location:', error);
                            }
                        });
                    },
                    function(error) {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Permission Denied',
                                    text: 'User denied the request for Geolocation.',
                                });
                                break;
                            case error.POSITION_UNAVAILABLE:
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Position Unavailable',
                                    text: 'Location information is unavailable.',
                                });
                                break;
                            case error.TIMEOUT:
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Timeout',
                                    text: 'The request to get user location timed out.',
                                });
                                break;
                            case error.UNKNOWN_ERROR:
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Unknown Error',
                                    text: 'An unknown error occurred.',
                                });
                                break;
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Geolocation not supported',
                    text: 'Your browser does not support geolocation.',
                });
            }
        }

        sendLocation();

        setInterval(sendLocation, 60000);
    </script>
@endpush
