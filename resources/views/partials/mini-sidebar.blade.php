<div class="hidden col-span-3 lg:block">
    <div class="w-full h-full py-4 overflow-y-auto bg-transparent">
        <ul class="space-y-2 font-medium">
            <x-nav-item href="{{ route('settings.index') }}" icon="ti ti-settings"
                active="{{ request()->is('settings*') }}">
                Settings
            </x-nav-item>

            @if (Auth::user()->hasRole('admin'))
                <x-nav-item href="{{ route('admin.dashboard.index') }}" icon="ti ti-layout-dashboard"
                    active="{{ request()->routeIs('admin.dashboard.index') }}">
                    Dashboard
                </x-nav-item>
                <x-nav-item href="{{ route('admin.user.index') }}" icon="ti ti-users"
                    active="{{ request()->routeIs('admin.user.index') }}">
                    Manage Users
                </x-nav-item>
                <x-nav-item href="{{ route('admin.restaurant.index') }}" icon="ti ti-chef-hat"
                    active="{{ request()->routeIs('admin.restaurant.index') }}">
                    Manage Restaurants
                </x-nav-item>
                <x-nav-item href="{{ route('admin.reported-reviews.index') }}" icon="ti ti-file-alert"
                    active="{{ request()->routeIs('admin.reported-reviews.index') }}">
                    Reported Reviews
                </x-nav-item>
            @elseif (Auth::user()->hasRole('user'))
                <li class="flex items-center gap-2 px-4 text-xs font-semibold text-muted uppercase">
                    <span>User Menu</span>
                    <div class="flex-grow border-b border-muted"></div>
                </li>


                <x-nav-item href="{{ route('user.review.index') }}" icon="ti ti-message-2"
                    active="{{ request()->routeIs('user.review.index') }}">
                    My Reviews
                </x-nav-item>
                <x-nav-item href="{{ route('user.favorite.index') }}" icon="ti ti-heart"
                    active="{{ request()->routeIs('user.favorite.index') }}">
                    My Favorite
                </x-nav-item>
                @if (!Auth::user()->owned)
                    <x-nav-item href="{{ route('business.index') }}" icon="ti ti-briefcase-2"
                        active="{{ request()->routeIs('business.index') }}">
                        {{ config('app.name') }} For Business
                    </x-nav-item>
                @endif

                @if (Auth::user()->owned)
                    <li class="flex items-center gap-2 px-4 text-xs font-semibold text-muted uppercase">
                        <span>Owner Menu</span>
                        <div class="flex-grow border-b border-muted"></div>
                    </li>
                    <x-nav-item href="{{ route('owner.dashboard.index') }}" icon="ti ti-layout-dashboard"
                        active="{{ request()->routeIs('owner.dashboard.index') }}">
                        Dashboard
                    </x-nav-item>
                    <x-nav-item href="{{ route('owner.manage.index') }}" icon="ti ti-chef-hat"
                        active="{{ request()->routeIs('owner.manage.index') }}">
                        Manage Restaurant
                    </x-nav-item>
                @endif
            @endif

            {{-- Logout --}}
            <a href="{{ route('logout') }}"
                class="flex items-center font-semibold text-sm px-4 py-2.5 rounded-lg border-s-4 border-transparent hover:border-danger hover:bg-danger/10 focus:border-danger focus:bg-danger/10 !text-danger gap-2">
                <i class="ti ti-logout text-xl"></i>
                Logout
            </a>
        </ul>

    </div>
</div>
