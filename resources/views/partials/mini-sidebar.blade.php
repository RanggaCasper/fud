@auth
    <div class="hidden col-span-3 lg:block">
    <div class="w-full h-full py-4 overflow-y-auto bg-transparent" id="panelSidebar">
        <ul class="flex flex-col space-y-2">
            <x-nav-item href="{{ route('settings.index') }}" icon="ti ti-settings"
                active="{{ request()->is('settings*') }}">
                Settings
            </x-nav-item>

            @if (Auth::user()->hasRole('admin'))
                <li class="flex items-center gap-2 pt-4 ps-5 text-sm font-semibold text-muted uppercase">
                    <span>Admin Menu</span>
                    <div class="flex-grow border-b border-secondary"></div>
                </li>

                <x-nav-item href="{{ route('admin.dashboard.index') }}" icon="ti ti-layout-dashboard"
                    active="{{ request()->routeIs('admin.dashboard.index') }}">
                    Dashboard
                </x-nav-item>
                <x-nav-item href="{{ route('admin.user.index') }}" icon="ti ti-users"
                    active="{{ request()->routeIs('admin.user.index') }}">
                    Manage Users
                </x-nav-item>
                <x-nav-item href="{{ route('admin.point.index') }}" icon="ti ti-clover"
                    active="{{ request()->routeIs('admin.point.index') }}">
                    Manage Point Levels
                </x-nav-item>
                <x-nav-item href="{{ route('admin.restaurant.index') }}" icon="ti ti-chef-hat"
                    active="{{ request()->routeIs('admin.restaurant.index') }}">
                    Manage Restaurants
                </x-nav-item>
                <x-nav-item href="{{ route('admin.owner.index') }}" icon="ti ti-rosette-discount-check"
                    active="{{ request()->routeIs('admin.owner.index') }}">
                    Manage Ownership
                </x-nav-item>
                <x-nav-item href="{{ route('admin.ad.type.index') }}" icon="ti ti-headset"
                    active="{{ request()->routeIs('admin.ad.type.index') }}">
                    Manage Ads Types
                </x-nav-item>
                <x-nav-item href="{{ route('admin.ad.index') }}" icon="ti ti-headset"
                    active="{{ request()->routeIs('admin.ad.index') }}">
                    Manage Ads
                </x-nav-item>
                <x-nav-item href="{{ route('admin.reported-reviews.index') }}" icon="ti ti-file-alert"
                    active="{{ request()->routeIs('admin.reported-reviews.index') }}">
                    Reported Reviews
                </x-nav-item>
                <x-nav-item href="{{ route('admin.page.index') }}" icon="ti ti-app-window"
                    active="{{ request()->routeIs('admin.page.index') }}">
                    Manage Pages
                </x-nav-item>
                <x-nav-item href="{{ route('admin.criteria.index') }}" icon="ti ti-list"
                    active="{{ request()->routeIs('admin.criteria.index') }}">
                    Manage Criteria
                </x-nav-item>
            @elseif (Auth::user()->hasRole('user'))
                <li class="flex items-center gap-2 pt-4 ps-5 text-sm font-semibold text-muted uppercase">
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
                <x-nav-item href="{{ route('user.point.index') }}" icon="ti ti-clover"
                    active="{{ request()->routeIs('user.point.index') }}">
                    My Points
                </x-nav-item>

                @if (!Auth::user()->owned)
                    <x-nav-item href="{{ route('user.claim.index') }}" icon="ti ti-briefcase-2"
                        active="{{ request()->routeIs('user.claim.index') }}">
                        {{ config('app.name') }} For Business
                    </x-nav-item>
                @endif

                @if (Auth::user()->owned)
                    <li class="flex items-center gap-2 pt-4 ps-5 text-sm font-semibold text-muted uppercase">
                        <span>Owner Menu</span>
                        <div class="flex-grow border-b border-muted"></div>
                    </li>
                    <x-nav-item href="{{ route('owner.manage.index') }}" icon="ti ti-chef-hat"
                        active="{{ request()->routeIs('owner.manage.index') }}">
                        Manage Restaurant
                    </x-nav-item>
                    <x-nav-item href="{{ route('owner.seo.index') }}" icon="ti ti-settings-search"
                        active="{{ request()->routeIs('owner.seo.index') }}">
                        Manage SEO
                    </x-nav-item>
                    <x-nav-item href="{{ route('owner.ads.index') }}" icon="ti ti-headset"
                        active="{{ request()->routeIs('owner.ads.index') }}">
                        Promote Restaurant
                    </x-nav-item>
                    <x-nav-item href="{{ route('owner.operatingHours.index') }}" icon="ti ti-clock-24"
                        active="{{ request()->routeIs('owner.operatingHours.index') }}">
                        Manage Operating Hours
                    </x-nav-item>
                    <x-nav-item href="{{ route('owner.offering.index') }}" icon="ti ti-bell"
                        active="{{ request()->routeIs('owner.offering.index') }}">
                        Manage Offerings
                    </x-nav-item>
                    <x-nav-item href="{{ route('owner.features.index') }}" icon="ti ti-tools-kitchen-2"
                        active="{{ request()->routeIs('owner.features.index') }}">
                        Manage Features
                    </x-nav-item>
                @endif
            @endif

            {{-- Logout --}}
            <a href="{{ route('logout') }}"
                class="flex items-center font-semibold text-sm ps-5 py-2.5 rounded-lg border-s-4 border-transparent hover:border-danger hover:bg-danger/10 focus:border-danger focus:bg-danger/10 !text-danger gap-2">
                <i class="ti ti-logout text-xl"></i>
                Logout
            </a>
        </ul>

    </div>
</div>
@endauth
