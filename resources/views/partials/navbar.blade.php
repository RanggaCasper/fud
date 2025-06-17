<nav class="bg-white px-4 md:px-2 border-b border-gray-200 fixed top-0 left-0 right-0 z-30">
    <div class="py-4 max-w-screen-xl mx-auto flex items-center justify-between space-x-4">

        <!-- Logo + Search -->
        <div class="flex items-center space-x-4 flex-1">
            <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex p-2 hover:bg-primary/10 font-semibold items-center justify-center rounded-lg border text-primary border-primary md:hidden" aria-expanded="false">
                <i class="ti ti-menu-2 text-xl"></i>
            </button>
            <!-- Logo -->
            <a href="{{ route('home') }}" class="hidden lg:flex items-center space-x-3 rtl:space-x-reverse shrink-0">
                <x-logo />
            </a>

            <!-- Search Bar -->
            <!-- Desktop view -->
            <button data-modal-target="searchModal" data-modal-toggle="searchModal" type="button" class="hidden lg:flex items-center gap-2 px-4 py-1.5 w-full max-w-3xs border border-gray-300 rounded-lg bg-gray-100 text-black hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                <i class="ti ti-search"></i>
                <span>Search</span>
                <kbd class="ml-auto px-1 py-1 text-xs text-nowrap font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg">Ctrl + K</kbd>
            </button>

            <button class="btn !text-primary text-sm btn-icon" data-dropdown-toggle="locationDropdown" data-dropdown-placement="bottom-start" >
                <i class="ti ti-location text-lg"></i>
                <span class="text-nowrap">Select Location</span>
            </button>

            <div id="locationDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-56">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="locationDropdownButton">
                    <li>
                        <a href="#" class="block px-4 py-2 font-semibold text-primary hover:bg-gray-100" id="useCurrentLocation">
                            <i class="ti ti-current-location mr-1"></i> Current Location
                        </a>
                    </li>
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-lat="-8.670458" data-lng="115.212629">Denpasar, Bali, Indonesia</a></li>
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-lat="-8.717911" data-lng="115.168518">Kuta, Bali, Indonesia</a></li>
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-lat="-8.690727" data-lng="115.167175">Seminyak, Bali, Indonesia</a></li>
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-lat="-8.506939" data-lng="115.262476">Ubud, Bali, Indonesia</a></li>
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-lat="-8.807981" data-lng="115.225939">Nusa Dua, Bali, Indonesia</a></li>
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-lat="-8.692945" data-lng="115.261116">Sanur, Bali, Indonesia</a></li>
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-lat="-8.647817" data-lng="115.138519">Canggu, Bali, Indonesia</a></li>
                </ul>
            </div>
        </div>

        <!-- Menu Navigasi + Aksi -->
        <div class="flex items-center gap-4 ml-auto">
            <!-- Menu Navigasi (Tombol Dropdown atau Menu) -->
            <div id="navbarMenu" class="hidden md:flex items-center gap-2 text-sm font-semibold text-gray-800">
                <ul class="flex">
                    <li class="flex">
                        <a href="{{ route('home') }}" class="flex text-nowrap items-center gap-1.5 text-sm font-semibold text-gray-800 hover:text-primary hover:bg-primary/10 dark:hover:text-primary focus:ring-primary dark:hover:bg-primary/10 dark:focus:ring-primary transition duration-200 ease-in-out p-2 rounded-lg border-b-2 border-transparent hover:border-primary active:border-primary">
                            <i class="ti ti-smart-home text-xl"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li class="flex">
                        <a href="{{ route('list') }}" class="flex text-nowrap items-center gap-1.5 text-sm font-semibold text-gray-800 hover:text-primary hover:bg-primary/10 dark:hover:text-primary focus:ring-primary dark:hover:bg-primary/10 dark:focus:ring-primary transition duration-200 ease-in-out p-2 rounded-lg border-b-2 border-transparent hover:border-primary active:border-primary">
                            <i class="ti ti-chef-hat text-xl"></i>
                            <span>Restaurant</span>
                        </a>
                    </li>

                    <li class="flex">
                        <a href="{{ route('reviews') }}" class="flex text-nowrap items-center gap-1.5 text-sm font-semibold text-gray-800 hover:text-primary hover:bg-primary/10 dark:hover:text-primary focus:ring-primary dark:hover:bg-primary/10 dark:focus:ring-primary transition duration-200 ease-in-out p-2 rounded-lg border-b-2 border-transparent hover:border-primary active:border-primary">
                            <i class="ti ti-sparkles text-xl"></i>
                            <span>Reviews</span>
                        </a>
                    </li>

                    <li class="flex">
                        <a href="{{ route('home') }}#about-us" class="flex text-nowrap items-center gap-1.5 text-sm font-semibold text-gray-800 hover:text-primary hover:bg-primary/10 dark:hover:text-primary focus:ring-primary dark:hover:bg-primary/10 dark:focus:ring-primary transition duration-200 ease-in-out p-2 rounded-lg border-b-2 border-transparent hover:border-primary active:border-primary">
                            <i class="ti ti-message text-xl"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="flex gap-2">
                <button data-modal-target="searchModal" data-modal-toggle="searchModal" type="button"
                    class="flex sm:hidden items-center !text-primary justify-center p-2 border border-primary rounded-lg bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary">
                    <i class="ti ti-search text-xl"></i>
                </button>
                @auth
                    <!-- Dropdown Button -->
                    <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar" data-dropdown-placement="bottom-end" class="flex text-sm bg-primary size-9 rounded-full md:me-0 focus:ring-2 focus:ring-primary" type="button">
                        <span class="sr-only">Open user menu</span>
                        
                        @if(Auth::user()->avatar)
                            <!-- Show Avatar if exists -->
                            <img class="size-9 rounded-full" src="{{ Auth::user()->avatar }}" alt="user photo">
                        @else
                            <span class="size-9 flex items-center justify-center bg-primary text-white text-sm font-medium rounded-full">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownAvatar" class="z-10 hidden bg-secondary-background divide-y divide-gray-100 rounded-lg shadow-sm w-56">
                        <div class="px-4 py-3 text-sm text-black">
                            <h5 class="font-semibold">Login as</h5>
                            <p class="font-semibold line-clamp-2">{{ Auth::user()->name }}</p>
                        </div>
                        <ul class="py-2 text-sm text-black" aria-labelledby="dropdownUserAvatarButton">
                            @auth
                                @if (Auth::user()->role->name === 'admin')
                                    <li>
                                        <a href="{{ route('admin.dashboard.index') }}" class="px-4 py-2 hover:!text-white hover:bg-primary flex items-center">
                                            <i class="ti ti-layout-dashboard text-lg me-1.5"></i>
                                            Dashboard
                                        </a>
                                    </li>
                                @endif
                            @endauth
                            <li>
                                <a href="{{ route('settings.index') }}" class="px-4 py-2 hover:!text-white hover:bg-primary flex items-center">
                                    <i class="ti ti-user-cog text-lg me-1.5"></i>
                                    Settings
                                </a>
                            </li>
                        </ul>
                        <ul class="py-2 text-sm text-black" aria-labelledby="dropdownUserAvatarButton">
                            <li>
                                <a href="{{ route('logout') }}" class="px-4 py-2 hover:!text-white hover:bg-danger flex items-center">
                                    <i class="ti ti-logout text-lg me-1.5"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="flex gap-2">
                        <a href="{{ route('auth.login.index') }}" class="btn btn-primary btn-md">Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
