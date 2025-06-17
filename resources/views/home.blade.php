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
                <div id="restaurant-list" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    @include('partials.restaurant-items', ['restaurants' => $restaurants])
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
                                :restaurantName="$comment->restaurant->name" :commentAttachments="$comment->attachments" :commentText="$comment->comment" :commentId="$comment->id" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <a href="{{ route('reviews') }}" class="btn btn-md btn-warning btn-icon">
                    Explore
                    <i class="ti ti-compass text-lg"></i>
                </a>
            </div>
        </div>
    </section>

    @include('partials.faq')
@endsection
