<div class="hidden col-span-3 lg:block">
    <div class="w-full h-full py-4 overflow-y-auto bg-transparent">
        <ul class="space-y-2 font-medium">
            
            <x-nav-item href="{{ route('settings.index') }}" icon="ri-settings-line" active="{{ request()->is('settings') }}">
                Settings
            </x-nav-item>
            <x-nav-item href="{{ route('my-reviews.index') }}" icon="ri-message-2-line" active="{{ request()->routeIs('my-reviews.index') }}">
                My Reviews
            </x-nav-item>
            <x-nav-item href="{{ route('my-favorite.index') }}" icon="ri-heart-line" active="{{ request()->routeIs('my-favorite.index') }}">
                My Favorite
            </x-nav-item>
            <x-nav-item href="{{ route('business.index') }}" icon="ri-briefcase-2-line" active="{{ request()->routeIs('business.index') }}">
                {{ config('app.name') }} For Business
            </x-nav-item>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full p-2 hover:bg-primary hover:text-white rounded-lg text-start gap-2 text-muted group">
                        <i class="ri ri-arrow-left-circle-line text-xl"></i>
                        <span class="flex-1 whitespace-nowrap">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
