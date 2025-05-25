@extends('layouts.app')

@section('header')
<div class="mt-[72px]">
    <!-- Background image with gradient overlay -->
        <div class="py-6 px-4 md:px-2 bg-[url('https://b.zmtcdn.com/data/pictures/3/20863533/118f53d82aeefc075bfc84ca724490d3.jpeg?fit=around|771.75:416.25&crop=771.75:416.25;*,*')] bg-cover bg-no-repeat relative">
            <div class="absolute inset-0 bg-black opacity-25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-75"></div>
            
            <div class="max-w-screen-xl mx-auto pt-[100px] relative z-10">
                <div class="flex flex-col space-y-2">
                    <h5 class="font-bold text-4xl text-white">Cé La Vie Kitchen & Bar</h5>
                    <div class="flex items-center gap-2">
                        <div class="bg-primary flex items-center text-white text-sm font-bold gap-0.5 px-2 py-0.5 rounded-lg shadow-md">
                            <svg class="size-3.5 text-warning" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                            </svg>
                            <span>4.5</span>
                        </div>
                        <div class="flex flex-col">
                            <h5 class="text-sm text-white">
                                10.000+ (Ratings)
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mt-4">
                    <div class="mb-3">
                        <h5 class="text-white">
                            Indonesian, Asian, Seafood
                        </h5>
                        <p class="text-sm text-white">Bali, Denpasar Timur, Gg. Trengguli (Alamat Lengkap)</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-1 mb-3">
                        <div class="text-white">
                            <span class="bg-success text-xs font-medium px-2.5 py-0.5 rounded-lg">Open</span>
                            <span class="font-semibold">11:00 AM - 7:00 PM</span>
                        </div>
                        <span class="border-s mx-2 border-white/50"></span>
                        <span class="text-sm font-semibold text-white flex items-center">
                            <a href="tel:6283189944777" class="underline flex items-center gap-1 hover:text-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 4l-2 2" />
                                    <path d="M22 10.5l-2.5 -.5" />
                                    <path d="M13.5 2l.5 2.5" />
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2c-8.072 -.49 -14.51 -6.928 -15 -15a2 2 0 0 1 2 -2" />
                                </svg>
                                +6283189944777
                            </a>
                        </span>
                    </div>
                </div>

                <!-- Share, View Photo, and Favorite Buttons (Responsive layout) -->
                <div class="md:absolute md:bottom-4 md:right-0 flex md:gap-3 gap-1 z-20 text-white">
                    <button class="bg-primary flex gap-2 items-center py-2 px-4 border border-secondary rounded-lg text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M8.7 10.7l6.6 -3.4" />
                            <path d="M8.7 13.3l6.6 3.4" />
                        </svg>
                        Share
                    </button>
                    <button class="bg-primary flex gap-2 items-center py-2 px-4 border border-secondary rounded-lg text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.286 21.09q -1.69 .001 -5.288 -2.615q -3.596 2.617 -5.288 2.616q -2.726 0 -.495 -6.8q -9.389 -6.775 2.135 -6.775h.076q 1.785 -5.516 3.574 -5.516q 1.785 0 3.574 5.516h.076q 11.525 0 2.133 6.774q 2.23 6.802 -.497 6.8" />
                        </svg>
                        Favorite
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6"  id="restaurant-detail">
    <div id="menu-header" class="sticky top-[72px] z-10 bg-transparent">
        <div class="max-w-screen-xl mx-auto px-4 md:px-0 py-2">
            <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap no-scrollbar">
                <x-button class="btn-icon shadow-md" data-modal-target="filterModal" data-modal-toggle="filterModal">
                    <svg
                    class="size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    >
                    <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                    </svg>
                    <span>Write a Review</span>
                </x-button>
                <x-button class="btn-icon" :outline="true">
                    <svg
                    class="size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    >
                    <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                    <path d="M11 13l9 -9" />
                    <path d="M15 4h5v5" />
                    </svg>
                    <span>
                        Resto Website
                    </span>
                </x-button>
                <x-button class="btn-icon" :outline="true">
                    <svg
                    class="size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    >
                    <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" />
                    <path d="M19 16h-12a2 2 0 0 0 -2 2" />
                    <path d="M9 8h6" />
                    </svg>
                    <span>
                        Full Menu
                    </span>
                </x-button>
            </div>
        </div>
    </div>
    <div class="px-4 md:px-2 ">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-12 md:col-span-8">
                    <div class="mb-3">
                        <x-card title="Menu">
                            <h5 class="text-xl font-semibold">Popular Dishes</h5>
                            <div class="grid grid-cols-2 md:grid-cols-4">
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>
                    <div class="mb-3">
                        <x-card title="About Restaurant">
                            <div class="grid grid-cols-2 md:grid-cols-4">
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center mt-0.5">
                                        <span class="text-sm text-secondary">90 Photos</span>
                                        <span class="mx-2 text-secondary">•</span>
                                        <span class="text-sm text-secondary">200 Reviews</span>
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>
                    <div class="mb-3">
                        <x-card title="Recomended Reviews">
                            <div class="flex justify-between">
                                <div class="flex items-center gap-2">
                                    <img class="size-24 rounded-full" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description" srcset="">
                                    <div class="flex flex-col">
                                        <h5 class="text-lg font-semibold">John Doe</h5>
                                        <p class="text-sm text-secondary">Location</p>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex justify-between">
                                        <div class="flex items-center gap-1">
                                            <svg class="size-3 md:size-4 text-secondary" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <svg class="size-3 md:size-4 text-secondary" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <svg class="size-3 md:size-4 text-secondary" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <svg class="size-3 md:size-4 text-secondary" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                            <svg class="size-3 md:size-4 text-secondary" fill="currentColor" viewBox="0 0 22 20">
                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-secondary font-semibold">
                                            0/5
                                        </span>
                                    </div>
                                    <div>
                                        <button type="button" data-modal-target="reviewModal" data-modal-toggle="reviewModal" class="text-xs text-primary" href="">Add your review of restaurant</button>
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>
                    <div class="mb-3">
                        <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap no-scrollbar mb-3">
                            <x-button class="btn-icon shadow-md" data-modal-target="filterModal" data-modal-toggle="filterModal">
                                <svg
                                class="size-4"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                >
                                <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                </svg>
                                <span>Filter</span>
                            </x-button>
                            <x-button class="btn-icon" :outline="true">
                                <svg
                                class="size-4"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                >
                                <path d="M17 3l0 18" />
                                <path d="M10 18l-3 3l-3 -3" />
                                <path d="M7 21l0 -18" />
                                <path d="M20 6l-3 -3l-3 3" />
                                </svg>
                                <span>
                                    Rating
                                </span>
                            </x-button>
                            <x-button :outline="true">
                                <span>
                                    Like
                                </span>
                            </x-button>
                            <x-button :outline="true">
                                <span>
                                    By Date
                                </span>
                            </x-button>
                        </div>
                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-12">
                                @php
                                    $comments = [
                                        [
                                            'userName' => 'Alexandre Petrov',
                                            'commentDate' => '07 May 2025',
                                            'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                                            'rating' => 3,
                                            'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                                            'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                                        ],
                                        [
                                            'userName' => 'Alexandre Petrov',
                                            'commentDate' => '07 May 2025',
                                            'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                                            'rating' => 3,
                                            'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                                            'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                                        ],
                                        [
                                            'userName' => 'Alexandre Petrov',
                                            'commentDate' => '07 May 2025',
                                            'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                                            'rating' => 3,
                                            'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                                            'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                                        ],
                                        [
                                            'userName' => 'Alexandre Petrov',
                                            'commentDate' => '07 May 2025',
                                            'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                                            'rating' => 3,
                                            'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                                            'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                                        ],
                                    ];
                                @endphp
    
                                @foreach($comments as $comment)
                                    <div class="mb-3">
                                        <x-card.comment-card 
                                            :userName="$comment['userName']" 
                                            :commentDate="$comment['commentDate']" 
                                            :userImage="$comment['userImage']" 
                                            :rating="$comment['rating']" 
                                            :commentImage="$comment['commentImage']" 
                                            :commentText="$comment['commentText']" 
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4">
                    <div class="sticky top-[142px]">
                        <x-card title="Location & Hours">
                            <img alt="image" data-src="https://maps.zomato.com/php/staticmap?center=28.6354845416,77.2194425014&amp;maptype=zomato&amp;markers=28.6354845416,77.2194425014,pin_res32&amp;sensor=false&amp;scale=2&amp;zoom=16&amp;language=id&amp;size=240x150&amp;size=400x240&amp;size=650x250" loading="lazy" class="lazyload w-full h-auto rounded-lg mb-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
                                </div>
                                <div class="flex">
                                    <x-button class="btn-icon">
                                        Directions
                                    </x-button>
                                </div>
                            </div>
                            <table class="min-w-full table-auto">
                                <tbody>
                                    <tr>
                                        <td class="text-dark font-semibold py-1">Mon</td>
                                        <td class="text-dark font-semibold py-1">11:30 AM - 9:30 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark font-semibold py-1">Tue</td>
                                        <td class="text-dark font-semibold py-1">11:30 AM - 9:30 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark font-semibold py-1">Wed</td>
                                        <td class="text-dark font-semibold py-1">11:30 AM - 9:30 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark font-semibold py-1">Thu</td>
                                        <td class="text-dark font-semibold py-1">11:30 AM - 9:30 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark font-semibold py-1">Fri</td>
                                        <td class="text-dark font-semibold py-1">11:30 AM - 9:30 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark font-semibold py-1">Sat</td>
                                        <td class="text-dark font-semibold py-1">11:30 AM - 9:30 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark font-semibold py-1">Sun</td>
                                        <td class="text-dark font-semibold py-1">11:30 AM - 9:30 PM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-modal title="Restaurant Name" id="reviewModal">
    <form>
        <div class="mb-3">
            <label class="block mb-2 text-sm font-medium text-dark" for="file_input">Upload file</label>
            <input class="block w-full text-sm text-dark border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" type="file" multi>
        </div>

        <!-- Rating section -->
        <div class="relative mb-4">
            <!-- Star rating on top of the textarea -->
            <div class="absolute top-2 left-2 flex items-center space-x-2">
                <div class="flex items-center">
                    <!-- Star 1 -->
                    <svg class="size-4 text-gray-400 cursor-pointer" fill="currentColor" viewBox="0 0 22 20" data-index="1">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg>
                    <!-- Star 2 -->
                    <svg class="size-4 text-gray-400 cursor-pointer" fill="currentColor" viewBox="0 0 22 20" data-index="2">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg>
                    <!-- Star 3 -->
                    <svg class="size-4 text-gray-400 cursor-pointer" fill="currentColor" viewBox="0 0 22 20" data-index="3">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg>
                    <!-- Star 4 -->
                    <svg class="size-4 text-gray-400 cursor-pointer" fill="currentColor" viewBox="0 0 22 20" data-index="4">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg>
                    <!-- Star 5 -->
                    <svg class="size-4 text-gray-400 cursor-pointer" fill="currentColor" viewBox="0 0 22 20" data-index="5">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg>
                </div>
                <span class="text-sm text-dark">
                    Rate
                </span>
            </div>
            <!-- Review text area with space for stars -->
            <textarea placeholder="Start your review..." class="w-full h-32 px-2 py-6 border-2 border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="5"></textarea>
        </div>
        <!-- Post review button -->
        <x-button>
            Post Review
        </x-button>
    </form>
</x-modal>
@endsection

@push('scripts')
    <script>
        const stars = document.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                let rating = star.getAttribute('data-index');
                stars.forEach(s => {
                    if (s.getAttribute('data-index') <= rating) {
                        s.classList.add('text-yellow-500');
                    } else {
                        s.classList.remove('text-gray-400');
                    }
                });
            });


            star.addEventListener('click', () => {
                let rating = star.getAttribute('data-index');
                stars.forEach(s => {
                    if (s.getAttribute('data-index') <= rating) {
                        s.classList.add('text-yellow-500');
                    } else {
                        s.classList.remove('text-yellow-500');
                    }
                });
            });
        });

    </script>
@endpush