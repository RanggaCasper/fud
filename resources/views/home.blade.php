@extends('layouts.app')
@section('showNavbot', true)

@section('header')
<x-front.section.hero-section
    :videoSource="asset('assets/video/IMG_44891.mp4')"
    title="Are you Hungry?"
    description="Discover your next favorite meal, whether you're craving a quick snack or a full-course feast."
    scrollToId="#restoran"
>
    <div class="flex space-x-2">
        <a href="#">
            <img src="https://lh3.googleusercontent.com/zWYJUppfU-TunHSxKMA6i1LRpv2POWaGCOOcvwR2h1E_R8LZ3RCiMUgbyxJDGFQqePR3G5BA3MdpUw4_BtQ_mefV36WH3tnBrV3ZkuSj=e365-pa-nu-s0" class="w-50" alt="">
        </a>
        <a href="#">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/2560px-Download_on_the_App_Store_Badge.svg.png" class="w-50" alt="">
        </a>
    </div>
</x-front.section.hero-section>

@endsection

@section('content')
<x-front.section.restaurant-section 
    backgroundImage="https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg" 
    icon="https://cdn.lordicon.com/tqvrfslk.json"
    title="Restoran"
    description="Jelajahi daftar terpilih untuk restoran, kafe, dan bar terbaik di dan di sekitar Delhi NCR, berdasarkan tren."
>
    @foreach(range(1, 6) as $i)
        <x-front.card.service-card 
            slug="lorem" 
            name="Lorem {{ $i }}" 
            desc="Hello kamu {{ $i }}" 
            image="https://b.zmtcdn.com/data/pictures/3/20863533/06fc9c8faa0fcf64c1a56859ae934abb_featured_v2.jpg?output-format=webp" />
    @endforeach
</x-front.section.restaurant-section>

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

<x-front.section.testimonial-section 
    sectionId="review"
    iconSrc="https://cdn.lordicon.com/abhwievu.json"
    title="Every Bite Has a Story"
    description="Jelajahi daftar terpilih untuk restoran, kafe, dan bar terbaik di dan di sekitar Delhi NCR, berdasarkan tren."
    :comments="$comments" />

@php
    $faqs = [
        [
            'question' => 'What is Flowbite?',
            'answer' => 'Flowbite is an open-source library of interactive components built on top of Tailwind CSS...',
            'link' => '/docs/getting-started/introduction/'
        ],
        [
            'question' => 'Is there a Figma file available?',
            'answer' => 'Flowbite is first conceptualized and designed using the Figma software...',
            'link' => 'https://flowbite.com/figma/'
        ],
        [
            'question' => 'What are the differences between Flowbite and Tailwind UI?',
            'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit... Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit... Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit...',
        ]
    ];
@endphp

<x-front.section.faq-section 
    sectionId="faq"
    title="FAQ"
    description="Jelajahi daftar terpilih untuk restoran, kafe, dan bar terbaik di dan di sekitar Delhi NCR, berdasarkan tren."
    :faqs="$faqs" />

@endsection

