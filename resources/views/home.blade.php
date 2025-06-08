@extends('layouts.app')
@section('showNavbot', true)

@section('header')
<x-section.hero-section
    :videoSource="asset('assets/video/IMG_44891.mp4')"
    title="Are you Hungry?"
    description="Discover your next favorite meal, whether you're craving a quick snack or a full-course feast."
    scrollToId="#restaurant"
>
    <div class="flex space-x-2">
        <a href="#">
            <img src="https://lh3.googleusercontent.com/zWYJUppfU-TunHSxKMA6i1LRpv2POWaGCOOcvwR2h1E_R8LZ3RCiMUgbyxJDGFQqePR3G5BA3MdpUw4_BtQ_mefV36WH3tnBrV3ZkuSj=e365-pa-nu-s0" class="w-50" alt="">
        </a>
        <a href="#">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/2560px-Download_on_the_App_Store_Badge.svg.png" class="w-50" alt="">
        </a>
    </div>
</x-section.hero-section>

@endsection

@section('content')
<x-section.restaurant-section 
    backgroundImage="https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg" 
    icon="https://cdn.lordicon.com/tqvrfslk.json"
    title="Dine Around You"
    description="Popular picks, tasty bites, near you. All ready to explore!"
>
@foreach($ranked->take(6) as $restaurant)
    <x-card.service-card
        :title="$restaurant->name"
        :slug="Str::slug($restaurant->name)"
        :rating="$restaurant->rating"
        :reviews="$restaurant->reviews"
        :location="$restaurant->address"
        :distance="$restaurant->distance . 'km'"
        :image="$restaurant->thumbnail"
        :isPromotion="false"
        :isClosed="$restaurant->isClosed()"
        :isHalal="($restaurant->offerings->contains(function ($offering) {
            return str_contains(strtolower($offering->name), 'halal');
        }))"
    />
@endforeach

</x-section.restaurant-section>

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

<x-section.testimonial-section 
    sectionId="review"
    iconSrc="https://cdn.lordicon.com/abhwievu.json"
    title="Every Bite Has a Story"
    description="Real reviews, honest bites. See what people are loving to eat!"
    :comments="$comments" />

@php
    $faqs = [
        [
            'question' => 'What is the purpose of this website?',
            'answer' => 'This website is designed to help you discover and explore the best restaurants in your area based on personalized recommendations and user reviews.',
        ],
        [
            'question' => 'How are restaurant recommendations made?',
            'answer' => 'Our system uses a combination of factors like user reviews, restaurant ratings, food preferences, and location to provide tailored restaurant recommendations.',
        ],
        [
            'question' => 'Can I leave a review for a restaurant?',
            'answer' => 'Yes! You can share your experience with other users by leaving a review and rating for any restaurant you’ve visited.',
        ],
        [
            'question' => 'How can I find the best restaurants near me?',
            'answer' => 'Simply enable location services, and our website will suggest the best restaurants near your location based on popular trends and user ratings.',
        ]
    ];

@endphp

<x-section.faq-section 
    sectionId="faq"
    title="FAQ"
    description="Frequently Asked Questions"
    :faqs="$faqs" />

@endsection

