<footer class="bg-secondary-background">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0 max-w-md">
                <a href="#" class="flex items-center gap-2">
                    <x-logo class="!h-12" />
                </a>
                <p class="mt-4 text-sm text-muted">
                    {{ config('app.name') }} is your smart companion in discovering the best places to eat, tailored just for you.
                    Powered by intelligent recommendations, it helps you explore local favorites, hidden gems, and top-rated spots—all based on your taste, location, and budget.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase">Get In Touch</h2>
                    <ul class="text-muted text-sm space-y-2">
                        <li>
                            <a href="#" class="hover:underline">{{ config('app.name') }}</a>
                        </li>
                        <li>
                            <a href="mailto:support@fudapp.com" class="hover:underline">support@fudapp.com</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase">Follow Us</h2>
                    <ul class="text-muted text-sm space-y-2">
                        <li>
                            <a href="#" class="hover:underline">GitHub</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Instagram</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="mb-6 text-sm font-semibold uppercase">Legal</h2>
                    <ul class="text-muted text-sm space-y-2">
                        <li>
                            <a href="#" class="hover:underline">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Terms & Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="my-6 border-muted/10 sm:mx-auto lg:my-8" />

        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-muted sm:text-center block">
                © {{ date('Y') }} <a href="#" class="hover:underline">{{ config('app.name') }}™</a>. All Rights Reserved.
            </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0 gap-5">
                <!-- Replace href with actual links -->
                @foreach (['facebook', 'discord', 'twitter', 'github', 'dribbble'] as $platform)
                    <a href="#" class="text-muted hover:text-muted">
                        <x-icons.{{ $platform }} class="w-4 h-4" />
                        <span class="sr-only">{{ ucfirst($platform) }} page</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
