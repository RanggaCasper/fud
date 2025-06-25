<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <meta name="description"
        content="{{ config('app.name') }} helps you discover the best restaurants and delivers your favorite food right to your door. Fast, easy, and delicious.">
    <meta name="keywords"
        content="{{ config('app.name') }}, food delivery, order food online, food courier, nearby restaurants, affordable food">
    <meta name="author" content="RanggaCasper">

    <!-- Responsive & SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">

    <!-- Open Graph (Facebook, WhatsApp, etc.) -->
    <meta property="og:title" content="{{ config('app.name') }} - For Ur Dining" />
    <meta property="og:description"
        content="Discover your favorite restaurants and enjoy fast, reliable food delivery with {{ config('app.name') }}." />
    <meta property="og:image" content="{{ asset('assets/image/logo.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/image/logo.png') }}" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    @include('partials.navbar')
    @include('partials.sidebar')

    @yield('header')

    @yield('content')

    @include('partials.search-modal')

    @include('partials.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    @stack('scripts')
</body>

</html>
