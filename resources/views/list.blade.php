@extends('layouts.app')
@section('showNavbot', true)

@section('content')
    <div class="mt-[72px]">
        @php
            $carouselItems = [
                ['src' => 'https://b.zmtcdn.com/data/o2_assets/85e14f93411a6b584888b6f3de3daf081716296829.png'],
            ];
        @endphp

        <x-section.carousel-section sectionId="home" :items="$carouselItems" />

        <x-section.restaurant-section backgroundImage="https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg"
            icon="https://cdn.lordicon.com/tqvrfslk.json" title="Restoran"
            description="Jelajahi daftar terpilih untuk restoran, kafe, dan bar terbaik di dan di sekitar Delhi NCR, berdasarkan tren.">
           @foreach($ranked as $restaurant)
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
                    :isHalal="$restaurant->is_halal"
                />
            @endforeach
        </x-section.restaurant-section>

        @php
            $faqs = [
                [
                    'question' => 'What is Flowbite?',
                    'answer' =>
                        'Flowbite is an open-source library of interactive components built on top of Tailwind CSS...',
                    'link' => '/docs/getting-started/introduction/',
                ],
                [
                    'question' => 'Is there a Figma file available?',
                    'answer' => 'Flowbite is first conceptualized and designed using the Figma software...',
                    'link' => 'https://flowbite.com/figma/',
                ],
                [
                    'question' => 'What are the differences between Flowbite and Tailwind UI?',
                    'answer' =>
                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit... Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit... Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                ],
            ];
        @endphp

        <x-section.faq-section sectionId="faq" title="FAQ"
            description="Jelajahi daftar terpilih untuk restoran, kafe, dan bar terbaik di dan di sekitar Delhi NCR, berdasarkan tren."
            :faqs="$faqs" />
    </div>

@endsection

@push('scripts')
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
