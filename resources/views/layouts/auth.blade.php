<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-light lg:flex-row-reverse">

    <!-- Close Button -->
    <div class="absolute z-10 right-4 top-4">
        <a href="/" class="inline-flex items-center justify-center text-sm font-medium transition-all rounded-lg shadow-md hover:ring-primary hover:border-none hover:text-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-9 w-9 text-muted bg-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </a>
    </div>
    
    <!-- Left Section (Fixed Image) -->
    <div class="hidden lg:flex lg:w-7/12 fixed top-0 left-0 h-screen">
        <img src="https://w.wallhaven.cc/full/ly/wallhaven-ly9qzq.jpg" 
             alt="Background Image" 
             loading="lazy"
             class="object-cover w-full h-full">
    </div>

    <!-- Right Section (Scrolls) -->
    <div class="flex flex-col items-start justify-center p-8 text-light lg:w-5/12 lg:p-16 overflow-y-auto h-screen">
        <div class="w-full max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-primary">@yield('title', 'Masuk')</h2>
            <p class="text-black font-semibold text-sm mb-6">@yield('description', 'Masuk dengan akun yang telah Kamu daftarkan.')</p>
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    @stack('scripts')
</body>
</html>
