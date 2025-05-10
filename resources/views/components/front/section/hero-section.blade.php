<div class="relative w-full h-screen">
    <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover z-0">
        <source src="{{ $videoSource }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Dark Overlay -->
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-25 z-10"></div>
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-black to-transparent opacity-75 z-10"></div>

    <!-- Content centered -->
    <div class="relative z-20 flex items-center justify-center w-full h-full px-4 md:px-2 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
        <div class="space-y-4">
            <h5 class="mb-2 text-3xl font-bold text-white">{{ $title }}</h5>
            <p class="mb-5 text-base text-white sm:text-lg">{{ $description }}</p>
            <div class="flex items-center justify-center space-x-4 rtl:space-x-reverse">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Scroll Down Button -->
    <div class="absolute bottom-10 left-0 right-0 flex justify-center z-20">
        <a href="{{ $scrollToId }}" class="w-12 h-12 rounded-full border-2 border-white flex justify-center items-center text-white text-xl animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7 7 7-7"></path>
            </svg>
        </a>
    </div>
</div>
