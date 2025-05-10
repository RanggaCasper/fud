@extends('layouts.app')

@section('header')
<div class="mt-[72px]">
    <!-- Background image with gradient overlay -->
        <div class="py-6 px-4 md:px-2 bg-[url('https://b.zmtcdn.com/data/pictures/3/20863533/118f53d82aeefc075bfc84ca724490d3.jpeg?fit=around|771.75:416.25&crop=771.75:416.25;*,*')] bg-cover bg-no-repeat relative">
            <div class="absolute inset-0 bg-black opacity-25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-75"></div>
            
            <div class="max-w-screen-xl mx-auto pt-[100px] relative z-10">
                <div class="flex flex-col space-y-2">
                    <h5 class="font-semibold text-4xl text-white">Cé La Vie Kitchen & Bar</h5>
                    <div class="flex items-center gap-2">
                        <div class="bg-primary flex items-center text-white text-sm font-bold px-2 py-0.5 rounded-lg shadow">
                            <span>4.5</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 text-white fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.217 3.736h3.925c.969 0 1.371 1.24.588 1.81l-3.177 2.308 1.217 3.737c.3.921-.755 1.688-1.54 1.117L10 13.347l-3.181 2.288c-.784.571-1.838-.196-1.539-1.117l1.217-3.737-3.177-2.308c-.783-.57-.38-1.81.588-1.81h3.925L9.049 2.927z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <h5 class="text-sm text-white">
                                10.000+ (Ratings)
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mt-4">
                    <div class="mb-3">
                        <h5 class="text-white">
                            Indonesian, Asian, Seafood
                        </h5>
                        <p class="text-sm text-white">Bali, Denpasar Timur, Gg. Trengguli (Alamat Lengkap)</p>
                    </div>
                    <div class="flex items-center gap-1 mb-3">
                        <span class="bg-success text-white text-xs font-medium px-2.5 py-0.5 rounded-lg">Open</span>
                        <span class="text-sm font-semibold text-white flex">
                            <span>11:00 AM - 7:00 PM</span>
                            <span class="border-s mx-2 border-white/50"></span>
                            <a href="tel:6283189944777" class="underline flex items-center gap-1 hover:text-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 4l-2 2" />
                                    <path d="M22 10.5l-2.5 -.5" />
                                    <path d="M13.5 2l.5 2.5" />
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2c-8.072 -.49 -14.51 -6.928 -15 -15a2 2 0 0 1 2 -2" />
                                </svg>
                                +6283189944777
                            </a>
                            <span class="border-s mx-2 border-white/50"></span>
                            <a href="https://littlealohasf.com" class="underline flex items-center gap-1 hover:text-primary text-white">
                                <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="size-4 text-primary" 
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                >
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M3.6 9h16.8" />
                                <path d="M3.6 15h16.8" />
                                <path d="M11.5 3a17 17 0 0 0 0 18" />
                                <path d="M12.5 3a17 17 0 0 1 0 18" />
                                </svg>
                                littlealohasf.com
                            </a>
                        </span>
                    </div>
                </div>

                <!-- Share, View Photo, and Favorite Buttons (Responsive layout) -->
                <div class="md:absolute md:bottom-4 md:right-0 flex md:gap-3 gap-1 z-20 text-white">
                    <button class="bg-primary flex gap-2 items-center py-2 px-4 border border-secondary rounded-lg text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M8.7 10.7l6.6 -3.4" />
                            <path d="M8.7 13.3l6.6 3.4" />
                        </svg>
                        Share
                    </button>
                    <button class="bg-primary flex gap-2 items-center py-2 px-4 border border-secondary rounded-lg text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.286 21.09q -1.69 .001 -5.288 -2.615q -3.596 2.617 -5.288 2.616q -2.726 0 -.495 -6.8q -9.389 -6.775 2.135 -6.775h.076q 1.785 -5.516 3.574 -5.516q 1.785 0 3.574 5.516h.076q 11.525 0 2.133 6.774q 2.23 6.802 -.497 6.8" />
                        </svg>
                        Favorite
                    </button>
                    <button class="bg-primary flex gap-2 items-center py-2 px-4 border border-secondary rounded-lg text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M4 6v13" />
                            <path d="M20 19v-13" />
                            <path d="M4 10h16" />
                            <path d="M15 6v8a2 2 0 0 0 2 2h3" />
                        </svg>
                        Booking
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="px-4 md:px-2 bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6"  id="restoran">
    <div class="max-w-screen-xl mx-auto">
        <div class="mb-3">
           <div class="grid grid-cols-12 gap-3">
               <div class="col-span-12 md:col-span-8 p-4 rounded-lg bg-white">
                    <h5 class="font-semibold text-xl mb-3">Menu</h5>
                </div>
                <div class="col-span-12 md:col-span-4 p-4 rounded-lg bg-white">
                    <h5 class="font-semibold text-xl mb-3">Route</h5>
                    <img alt="image" data-src="https://maps.zomato.com/php/staticmap?center=28.6354845416,77.2194425014&amp;maptype=zomato&amp;markers=28.6354845416,77.2194425014,pin_res32&amp;sensor=false&amp;scale=2&amp;zoom=16&amp;language=id&amp;size=240x150&amp;size=400x240&amp;size=650x250" loading="lazy" class="lazyload w-full h-auto rounded-lg">
                    <p class="font-regular">Bali, Denpasar Timur, Gg. Trengguli (Alamat Lengkap)</p>
                    <div class="flex items-center gap-2">
                        <button class="bg-transparent flex gap-2 items-center py-2 px-4 border border-secondary rounded-lg text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Copy
                        </button>
                         <button class="bg-transparent flex gap-2 items-center py-2 px-4 border border-secondary rounded-lg text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                <path d="M9 4v13" />
                                <path d="M15 7v5.5" />
                                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                <path d="M19 18v.01" />
                            </svg>
                            Route
                        </button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</section>
@endsection