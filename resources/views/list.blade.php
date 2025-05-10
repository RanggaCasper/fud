@extends('layouts.app')
@section('showNavbot', true)

@section('content')
<div class="mt-[72px]">
   @php
        $carouselItems = [
            ['src' => 'https://b.zmtcdn.com/data/o2_assets/e067a1cf0d3fe27b366402b98b994e9f1716296909.png'],
        ];
    @endphp

    <x-front.section.carousel-section 
        sectionId="home"
        :items="$carouselItems" />
    
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
</div>

@endsection

@push('scripts')
@vite(['resources/js/swiper.init.js'])
<script>
    $(document).ready(function() {
        $("#owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            nav: false,
            dots: false,
        });
    });
</script>
@endpush