@extends('layouts.app')
@section('showNavbot', true)

@section('content')
    <div class="mt-[72px]">
        @php
            $carouselItems = [
                ['src' => 'https://b.zmtcdn.com/data/o2_assets/e067a1cf0d3fe27b366402b98b994e9f1716296909.png'],
                [
                    'src' =>
                        'https://www.bangjeff.com/_next/image?url=https%3A%2F%2Fcdn.bangjeff.com%2F10245926-3cbf-4cbe-adb5-e64e3db0b84f.webp&w=1920&q=100',
                ],
            ];
        @endphp

        <x-section.carousel-section sectionId="home" :items="$carouselItems" />

        <x-section.restaurant-section backgroundImage="https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg"
            icon="https://cdn.lordicon.com/tqvrfslk.json" title="Restoran"
            description="Jelajahi daftar terpilih untuk restoran, kafe, dan bar terbaik di dan di sekitar Delhi NCR, berdasarkan tren.">
            @foreach (range(1, 30) as $i)
                <x-card.service-card title="Lorem {{ $i }}" slug="lorem" :rating="rand(3, 5)" :reviews="rand(0, 1000)"
                    location="Jakarta" :distance="rand(1, 10) . ' km'" image="https://picsum.photos/200/300?random={{ $i }}"
                    :isClosed="rand(0, 1)" :isPromotion="rand(0, 1)" :isHalal="rand(0, 1)" />
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
