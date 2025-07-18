<footer class="bg-white print:hidden">
    <div class="mx-auto w-full max-w-screen-xl px-4 md:px-2 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0 max-w-md">
                <a href="#" class="flex items-center gap-2">
                    <x-logo class="!h-12" />
                </a>
                <p class="mt-4 text-sm text-muted">
                    {{ config('app.name') }} - Find Ur Delicious Zone. A smart restaurant recommendation platform that helps you find the most delicious places to eat, effortlessly and accurately. Powered by intelligent tech, built for true food lovers.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase">Information</h2>
                    <ul class="text-muted text-sm space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="hover:underline">{{ config('app.name') }}</a>
                        </li>
                        <li>
                            <a href="https://casperproject.my.id" class="hover:underline">Casper Project</a>
                        </li>
                        <li>
                            <a href="https://stats.uptimerobot.com/lsccdRbvah" target="_blank" class="hover:underline">Status</a>
                        </li>
                        <li>
                            <a href="https://forms.gle/cB7RpSGDX4vCcaNX8" target="_blank" class="hover:underline">Feedback</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase">Sitemap</h2>
                    <ul class="text-muted text-sm space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="hover:underline">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('list') }}" class="hover:underline">Restaurants</a>
                        </li>
                        <li>
                            <a href="{{ route('reviews') }}" class="hover:underline">Reviews</a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ route('logout') }}" class="hover:underline">Logout</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('auth.login.index') }}" class="hover:underline">Login</a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase">Company</h2>
                    <ul class="text-muted text-sm space-y-2">
                        {!! App\Models\Page::get()->map(function ($page) {
                            return '<li><a href="' . route('page.index', ['slug' => $page->slug]) . '" class="hover:underline">' . $page->title . '</a></li>';
                        })->implode('') !!}
                    </ul>
                </div>
            </div>
        </div>

        <hr class="my-6 border-muted/10 sm:mx-auto lg:my-8" />

        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-muted sm:text-center block">
                © {{ date('Y') }} <a href="#" class="hover:underline">{{ config('app.name') }}™</a>. All Rights Reserved.
            </span>
            <span class="text-xs text-muted sm:text-center block">
                {{ number_format((microtime(true) - LARAVEL_START) * 1000, 2) }} ms
            </span>
        </div>
    </div>
</footer>
