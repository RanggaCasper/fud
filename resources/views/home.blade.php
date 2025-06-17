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

    <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] pb-16" id="about-us">
        <div class="bg-gradient-to-t from-transparent to-primary rounded-b-3xl pb-16 lg:py-0 px-6 md:px-8">
            <div class="max-w-3xl mx-auto pt-16">
                <div class="flex flex-col lg:flex-row items-center justify-center space-y-6 lg:space-y-0 lg:space-x-10">
                    <!-- Device Mockup -->
                    <div
                        class="relative border-gray-800 bg-gray-800 border-[14px] rounded-t-[2.5rem] w-[250px] h-[300px] md:w-[300px] md:h-[340px] shadow-xl shrink-0">

                        <!-- Top Camera Bar -->
                        <div
                            class="w-[120px] md:w-[148px] h-[18px] bg-gray-800 rounded-b-[1rem] absolute top-0 left-1/2 -translate-x-1/2 z-10">
                        </div>

                        <!-- Volume Buttons -->
                        <div
                            class="h-[28px] md:h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[60px] rounded-s-lg z-10">
                        </div>
                        <div
                            class="h-[40px] md:h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[110px] rounded-s-lg z-10">
                        </div>
                        <div
                            class="h-[40px] md:h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[160px] rounded-s-lg z-10">
                        </div>

                        <!-- Power Button -->
                        <div
                            class="h-[56px] md:h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[130px] rounded-e-lg z-10">
                        </div>

                        <!-- Screen -->
                        <div
                            class="absolute top-0 left-0 w-[222px] md:w-[272px] h-[285px] md:h-[325px] overflow-hidden rounded-t-[2rem] z-0">
                            <div class="mockupSwiper w-full h-full">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ asset('assets/image/mockup-1.png') }}"
                                            class="w-full h-full object-cover" alt="Mockup 1">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ asset('assets/image/mockup-2.png') }}"
                                            class="w-full h-full object-cover" alt="Mockup 2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Text -->
                    <div class="text-center lg:text-left">
                        <h5 class="text-xl md:text-2xl font-bold text-muted">
                            Food Finding Effortless,
                            <span class="text-primary">That’s {{ config('app.name') }}</span>
                        </h5>
                        <p class="text-gray-700 my-3 text-sm md:text-base leading-relaxed">
                            {{ config('app.name') }} is your ultimate restaurant recommendation system, available on
                            multiple platforms to help you find the best places to eat, wherever you are.
                        </p>
                        <div class="flex justify-center lg:justify-start space-x-3">
                            <a href="#">
                                <img src="https://lh3.googleusercontent.com/zWYJUppfU-TunHSxKMA6i1LRpv2POWaGCOOcvwR2h1E_R8LZ3RCiMUgbyxJDGFQqePR3G5BA3MdpUw4_BtQ_mefV36WH3tnBrV3ZkuSj=e365-pa-nu-s0"
                                    class="h-12 md:h-14" alt="Google Play">
                            </a>
                            <a href="#">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/2560px-Download_on_the_App_Store_Badge.svg.png"
                                    class="h-12 md:h-14" alt="App Store">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col justify-center mt-16">
            <h5 class="text-center font-bold text-2xl">Discover Our Featured Product</h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-6 py-8 max-w-screen-xl mx-auto">
                <div class="rounded-2xl border-2 border-blue-500 p-6 text-center shadow-md">
                    <img src="https://www.casperproject.my.id/assets/images/logo.jpg" alt="BliEvent" class="h-16 mx-auto mb-4">
                    <h3 class="text-lg font-bold text-muted">Casper Project</h3>
                    <p class="text-sm text-gray-600 mt-2">A foundation for a next-gen software house, shaping solutions with purpose and precision.</p>
                </div>
    
                <div class="rounded-2xl border-2 border-green-500 p-6 text-center shadow-md">
                    <img src="{{ asset('assets/image/fotoin.png') }}" alt="SkyETS" class="h-16 mx-auto mb-4">
                    <h3 class="text-lg font-bold text-muted">Fotoin</h3>
                    <p class="text-sm text-gray-600 mt-2">A freelance platform for photographers to connect, showcase, and get hired.</p>
                </div>
    
                <!-- Card 3 - SkripTI -->
                <div class="rounded-2xl border-2 border-orange-500 p-6 text-center shadow-md">
                    <img src="{{ asset('assets/image/skripti.png') }}" alt="SkripTI" class="h-16 mx-auto mb-4">
                    <h3 class="text-lg font-bold text-muted">SkripTI</h3>
                    <p class="text-sm text-gray-600 mt-2">Platform to guide you through your thesis, making it easier every
                        step.</p>
                </div>

                <div class="rounded-2xl border-2 border-purple-500 p-6 text-center shadow-md">
                    <img src="{{ asset('assets/image/skyets.png') }}" alt="SkyETS!" class="h-16 mx-auto mb-4">
                    <h3 class="text-lg font-bold text-muted">SkyETS</h3>
                    <p class="text-sm text-gray-600 mt-2">Say no to dualism! power up your TOEIC. Practice, learn, and ace perfect score!
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
