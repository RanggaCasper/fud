@extends('layouts.app')

@section('header')
<div class="mt-[72px]">
    <!-- Background image with gradient overlay -->
       <div class="py-6 px-4 md:px-2 relative">
            <img data-src="{{ $restaurant->thumbnail }}" alt="{{ $restaurant->name }}" class="lazyload w-full h-full object-cover absolute inset-0 z-0" />
            <div class="absolute inset-0 bg-black opacity-25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-75"></div>
            
            <div class="max-w-screen-xl mx-auto pt-[100px] relative z-10">
                <div class="flex flex-col space-y-2">
                    <h5 class="font-bold text-4xl text-white">{{ $restaurant->name }}</h5>
                    <div class="flex items-center gap-2">
                        <div class="bg-primary flex items-center text-white text-sm font-bold gap-0.5 px-2 py-0.5 rounded-lg shadow-md">
                            <svg class="size-3.5 text-warning" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                            </svg>
                            <span>{{ $restaurant->rating }}</span>
                        </div>
                        <div class="flex flex-col">
                            <h5 class="text-sm text-white">
                                {{ number_format($restaurant->reviews, 0,',','.') }}+ (Ratings)
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mt-4">
                    <div class="mb-3">
                        <h5 class="text-white">
                            {{ implode(', ', $restaurant->offerings->take(5)->pluck('name')->toArray()) }}
                        </h5>
                        <p class="text-sm text-white">{{ $restaurant->address }}</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-1 mb-3">
                        <div class="text-white">
                            @if ($restaurant->isClosed())
                                <span class="bg-danger text-xs font-medium px-2.5 py-0.5 rounded-lg">Closed</span>
                            @else
                                <span class="bg-success text-xs font-medium px-2.5 py-0.5 rounded-lg">Open</span>
                            @endif

                            <span class="font-semibold">{{ $restaurant->getTodayOperatingHours() }}</span>
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
                                {{ $restaurant->phone }}
                            </a>
                        </span>
                    </div>
                </div>

                <!-- Share, View Photo, and Favorite Buttons (Responsive layout) -->
                <div class="md:absolute md:bottom-4 md:right-0 flex md:gap-3 gap-1 z-20 text-white">
                    <x-button class="btn-icon" data-modal-target="shareModal" data-modal-toggle="shareModal">
                        <i class="ri ri-share-line text-sm me-1.5"></i>
                        Share
                    </x-button>
                    <x-button class="btn-icon">
                        <i class="ri ri-star-line text-sm me-1.5"></i>
                        Favorite
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6"  id="restaurant-detail">
    <div class="max-w-screen-xl mx-auto px-4 md:px-0 py-2">
        <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap no-scrollbar">
            <a href="#write-a-review" class="btn btn-md btn-outline-primary btn-icon">
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
            </a>
            <a href="{{ $restaurant->website }}" target="_blank" class="btn btn-md btn-outline-primary btn-icon">
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
            </a>
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
                                    <div class="flex items-center">
                                        <span class="text-xs text-secondary">Rp. 10.000</span>    
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center">
                                        <span class="text-xs text-secondary">Rp. 10.000</span>    
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center">
                                        <span class="text-xs text-secondary">Rp. 10.000</span>    
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover" src="https://s3-media0.fl.yelpcdn.com/bphoto/IawDcF1QmHSzUQDczHYVuw/ls.jpg" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Chicken Satay</h6>
                                    <div class="flex items-center">
                                        <span class="text-xs text-secondary">Rp. 10.000</span>    
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>
                    <div class="mb-3">
                        <x-card title="About Restaurant">
                            <div class="grid grid-cols-2 md:grid-cols-4">
                                <div>
                                    <img class="size-44 object-cover lazyload" data-src="{{ $restaurant->thumbnail }}" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Inside</h6>
                                    <div class="flex items-center">
                                        <span class="text-xs text-secondary">1 Photos</span>    
                                    </div>
                                </div>
                                <div>
                                    <img class="size-44 object-cover lazyload" data-src="{{ $restaurant->thumbnail }}" alt="Image description">
                                    <h6 class="text-lg font-medium text-black">Outside</h6>
                                    <div class="flex items-center">
                                        <span class="text-xs text-secondary">1 Photos</span>    
                                    </div>
                                </div>
                                <div>
                                    <div class="relative size-44">
                                        <div class="absolute inset-0 bg-black opacity-70"></div>
                                        <div class="absolute text-center text-white z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-4xl font-bold">
                                            <span>2+</span>
                                        </div>
                                        <img class="size-44 object-cover lazyload" data-src="{{ $restaurant->thumbnail }}" alt="Image description">
                                    </div>
                                    <h6 class="text-lg font-medium text-black">All Photos</h6>
                                    <div class="flex items-center">
                                        <span class="text-xs text-secondary">2 Photos</span>    
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>
                    <div class="mb-3" id="write-a-review">
                        <x-card title="Write a Review">
                            @if (Auth::check())
                                <div class="flex justify-between">
                                    <div class="flex items-center gap-2">
                                        <img class="size-24 rounded-full" src="{{ Auth::user()->avatar }}" alt="Image description" srcset="">
                                        <div class="flex flex-col">
                                            <h5 class="text-lg font-semibold">{{ Auth::user()->name }}</h5>
                                            <p class="text-sm text-secondary">Local Explorer Level 6</p>
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
                            @else
                                <div class="text-center">
                                    <p class="text-sm text-secondary mb-2">You need to be logged in to write a review.</p>
                                    <a href="{{ route('auth.login.index') }}" class="btn btn-md btn-primary">Login</a>
                                </div>
                            @endif
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
                    <div class="sticky top-[78px]">
                        <x-card title="Location & Hours">
                            <div id="map" class="h-44"></div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-sm">{{ $restaurant->address }}</span>
                                </div>
                                <div class="flex">
                                    <a href="{{ 'https://maps.google.com/maps?ll=' . $restaurant->latitude . ',' . $restaurant->longitude }}" target="_blank" class="btn btn-primary btn-md">
                                        Directions
                                    </a>
                                </div>
                            </div>
                            <table class="min-w-full table-auto">
                                <tbody>
                                    @foreach ($restaurant->operatingHours as $hours)
                                        <tr>
                                            <td class="text-dark font-semibold py-1">{{ $hours->day }}</td>
                                            <td class="text-dark font-semibold py-1">{{ $hours->operating_hours }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-modal title="{{ $restaurant->name }}" id="reviewModal">
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

<x-modal title="Share" id="shareModal">
    <h5 class="font-semibold text-lg">Share this restaurant</h5>
    <div class="mb-3">
        <div class="flex flex-wrap items-center">
           <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                </svg>
                Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="text-white bg-[#1da1f2] hover:bg-[#1da1f2]/90 focus:ring-4 focus:outline-none focus:ring-[#1da1f2]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1da1f2]/55 me-2 mb-2">
                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                </svg>
                Twitter
            </a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode(request()->fullUrl()) }}" target="_blank" class="text-white bg-[#25D366] hover:bg-[#25D366]/90 focus:ring-4 focus:outline-none focus:ring-[#25D366]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#25D366]/55 me-2 mb-2">
                <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-brand-whatsapp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.497 4.409a10 10 0 0 1 -10.36 16.828l-.223 -.098l-4.759 .849l-.11 .011a1 1 0 0 1 -.11 0l-.102 -.013l-.108 -.024l-.105 -.037l-.099 -.047l-.093 -.058l-.014 -.011l-.012 -.007l-.086 -.073l-.077 -.08l-.067 -.088l-.056 -.094l-.034 -.07l-.04 -.108l-.028 -.128l-.012 -.102a1 1 0 0 1 0 -.125l.012 -.1l.024 -.11l.045 -.122l1.433 -3.304l-.009 -.014a10 10 0 0 1 1.549 -12.454l.215 -.203a10 10 0 0 1 13.226 -.217m-8.997 3.09a1.5 1.5 0 0 0 -1.5 1.5v1a6 6 0 0 0 6 6h1a1.5 1.5 0 0 0 0 -3h-1l-.144 .007a1.5 1.5 0 0 0 -1.128 .697l-.042 .074l-.022 -.007a4.01 4.01 0 0 1 -2.435 -2.435l-.008 -.023l.075 -.041a1.5 1.5 0 0 0 .704 -1.272v-1a1.5 1.5 0 0 0 -1.5 -1.5" /></svg>
                WhatsApp
            </a>
            <a href="https://www.instagram.com/share?url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="text-white bg-[#d62976] hover:bg-[#d62976]/90 focus:ring-4 focus:outline-none focus:ring-[#d62976]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#d62976]/55 me-2 mb-2">
                <svg class="w-4 h-4 me-2"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-brand-instagram"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 3a5 5 0 0 1 5 5v8a5 5 0 0 1 -5 5h-8a5 5 0 0 1 -5 -5v-8a5 5 0 0 1 5 -5zm-4 5a4 4 0 0 0 -3.995 3.8l-.005 .2a4 4 0 1 0 4 -4m4.5 -1.5a1 1 0 0 0 -.993 .883l-.007 .127a1 1 0 0 0 1.993 .117l.007 -.127a1 1 0 0 0 -1 -1" /></svg>
                Instagram
            </a>
        </div>
    </div>
    <div class="mb-3">
        <h5 class="font-semibold text-lg">Share this restaurant link</h5>
        <div class="grid grid-cols-8 gap-2 w-full">
            <label for="restaurantLink" class="sr-only">Label</label>
            <input id="restaurantLink" type="text" class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" value="{{ request()->fullUrl() }}" disabled readonly>
            <button data-copy-to-clipboard-target="restaurantLink" class="col-span-2 text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm w-full sm:w-auto py-2.5 text-center items-center inline-flex justify-center">
                <span id="default-message">Copy</span>
                <span id="success-message" class="hidden">
                    <div class="inline-flex items-center">
                        <svg class="w-3 h-3 text-white me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                        </svg>
                        Copied!
                    </div>
                </span>
            </button>
        </div>
    </div>
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
    <script>
        var latitude = {{ $restaurant->latitude }};
        var longitude = {{ $restaurant->longitude }};
        
        var map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    
        var marker = L.marker([latitude, longitude]).addTo(map);
        marker.bindPopup('<b>{{ $restaurant->name }}</b><br>{{ $restaurant->address }}').openPopup();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const copyButton = document.querySelector('[data-copy-to-clipboard-target="restaurantLink"]');
            const inputField = document.getElementById('restaurantLink');
            const defaultMessage = document.getElementById('default-message');
            const successMessage = document.getElementById('success-message');
            
            copyButton.addEventListener('click', function() {
                inputField.select();
                inputField.setSelectionRange(0, 99999);

                navigator.clipboard.writeText(inputField.value).then(function() {
                    defaultMessage.classList.add('hidden');
                    successMessage.classList.remove('hidden');

                    setTimeout(function() {
                        defaultMessage.classList.remove('hidden');
                        successMessage.classList.add('hidden');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Error copying text: ', err);
                });
            });
        });
    </script>
@endpush