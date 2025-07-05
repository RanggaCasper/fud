<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    
    <meta name="description" content="{{ config('app.name') }} helps you discover the best restaurants and delivers your favorite food right to your door. Fast, easy, and delicious.">
    <meta name="keywords" content="{{ config('app.name') }}, food delivery, order food online, food courier, nearby restaurants, affordable food">
    <meta name="author" content="RanggaCasper">

    <!-- Responsive & SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">

    <!-- Open Graph (Facebook, WhatsApp, etc.) -->
    <meta property="og:title" content="{{ config('app.name') }} - For Ur Dining" />
    <meta property="og:description" content="Discover your favorite restaurants and enjoy fast, reliable food delivery with {{ config('app.name') }}." />
    <meta property="og:image" content="{{ asset('assets/image/logo.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/image/logo.png') }}" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdn.datatables.net/v/ju/dt-2.3.0/datatables.min.css" rel="stylesheet" integrity="sha384-+x/E2KZ93ibXj/usuRdE/vr2kctLTVcFrDD4d7u0VdTut8YB5R/TetuZ/1U5t6ZB" crossorigin="anonymous">
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    @include('partials.navbar')
    @include('partials.sidebar')

    <div class="mt-[72px]">
        <div class="px-4 md:px-2 bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')]">
            <div class="max-w-screen-xl mx-auto">
                <div class="grid w-full grid-cols-12 gap-3 mx-auto">
                    <!-- Sidebar -->
                    @include('partials.mini-sidebar')
                
                    <!-- Content -->
                    <div class="col-span-12 gap-3 p-0 space-y-6 py-4 lg:col-span-9">
                        @yield('content')             
                    </div>
                </div>
            </div> 
        </div>
    </div>

    @include('partials.search-modal')

    @include('partials.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>