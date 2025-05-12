<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link href="https://cdn.datatables.net/v/ju/dt-2.3.0/datatables.min.css" rel="stylesheet" integrity="sha384-+x/E2KZ93ibXj/usuRdE/vr2kctLTVcFrDD4d7u0VdTut8YB5R/TetuZ/1U5t6ZB" crossorigin="anonymous">
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

    @include('partials.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.datatables.net/v/ju/dt-2.3.0/datatables.min.js" integrity="sha384-uJ+tZxF5bsmAk/MmG5UtHUL++Dm2gCoViN7DNvzonU8y4mx6Qr4rVEW15BwozH0Y" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>