<div class="hidden col-span-3 lg:block">
    <div class="w-full h-full py-4 overflow-y-auto bg-transparent">
        <ul class="space-y-2 font-medium">
            <x-nav-item href="{{ route('settings.index') }}" icon="ti ti-settings" active="{{ request()->is('settings') }}">
                Settings
            </x-nav-item>
            @if (Auth::user()->hasRole('admin'))
                <x-nav-item href="{{ route('admin.dashboard.index') }}" icon="ti ti-layout-dashboard" active="{{ request()->routeIs('admin.dashboard.index') }}">
                    Dashboard
                </x-nav-item>
                <x-nav-item href="{{ route('admin.user.index') }}" icon="ti ti-users" active="{{ request()->routeIs('admin.user.index') }}">
                    Manage Users
                </x-nav-item>
                <x-nav-item href="{{ route('admin.restaurant.index') }}" icon="ti ti-chef-hat" active="{{ request()->routeIs('admin.restaurant.index') }}">
                    Manage Restaurants
                </x-nav-item>
                <x-nav-item href="{{ route('admin.reported-reviews.index') }}" icon="ti ti-file-alert" active="{{ request()->routeIs('admin.reported-reviews.index') }}">
                    Manage Reported Reviews
                </x-nav-item>
            @else
                <x-nav-item href="{{ route('user.review.index') }}" icon="ri-message-2-line" active="{{ request()->routeIs('user.review.index') }}">
                    My Reviews
                </x-nav-item>
                <x-nav-item href="{{ route('my-favorite.index') }}" icon="ri-heart-line" active="{{ request()->routeIs('my-favorite.index') }}">
                    My Favorite
                </x-nav-item>
                <x-nav-item href="{{ route('business.index') }}" icon="ri-briefcase-2-line" active="{{ request()->routeIs('business.index') }}">
                    {{ config('app.name') }} For Business
                </x-nav-item>
            @endif
            <a href="{{ route('logout') }}"
                class="flex items-center font-semibold text-sm px-4 py-2.5 rounded-lg border-s-4 border-transparent hover:border-danger hover:bg-danger/10 focus:border-danger focus:bg-danger/10 !text-danger gap-2">
                <i class="ti ti-logout text-xl"></i>
                Logout
            </a>
        </ul>
    </div>
</div>
