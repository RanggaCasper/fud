<nav class="bg-white px-4 md:px-2 border-b border-gray-200 fixed top-0 left-0 right-0 z-30">
    <div class="py-4 max-w-screen-xl mx-auto flex items-center justify-between space-x-4">

        <!-- Logo + Search -->
        <div class="flex items-center space-x-4 flex-1">
            <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex p-2 hover:bg-primary/10 font-semibold items-center justify-center rounded-lg border text-primary border-primary md:hidden" aria-expanded="false">
                <i class="ti ti-menu-2 text-xl"></i>
            </button>
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse shrink-0">
                <x-logo />
            </a>

            <!-- Search Bar -->
            <!-- Desktop view -->
            <div class="hidden md:block w-full max-w-sm">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari Restoran"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387-1.414 1.414-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <!-- Hasil Pencarian -->
                    <div id="searchResults"
                        class="absolute left-0 right-0 bg-white border border-gray-300 mt-2 rounded-lg max-h-60 overflow-y-auto hidden">
                    </div>
                </div>
            </div>

            <div id="searchContainer"
                class="w-0 max-w-xl hidden fixed top-0 left-0 right-0 z-50 bg-white shadow-lg p-4 transition-all duration-500 ease-in-out opacity-0">
                <div class="relative">
                    <input type="text" id="searchInputMobile" placeholder="Cari Restoran"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387-1.414 1.414-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <!-- Hasil Pencarian -->
                    <div id="searchResultsMobile"
                        class="absolute left-0 right-0 bg-white border border-gray-300 mt-2 rounded-lg max-h-60 overflow-y-auto hidden">
                    </div>
                    <!-- Close Button -->
                    <button id="closeSearch" type="button"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                        <i class="ri ri-close-line text-xl"></i>
                    </button>
                </div>
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
                        <a href="#faq" class="flex text-nowrap items-center gap-1.5 text-sm font-semibold text-gray-800 hover:text-primary hover:bg-primary/10 dark:hover:text-primary focus:ring-primary dark:hover:bg-primary/10 dark:focus:ring-primary transition duration-200 ease-in-out p-2 rounded-lg border-b-2 border-transparent hover:border-primary active:border-primary">
                            <i class="ti ti-message text-xl"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="flex gap-2">
                <button id="showSearch" type="button"
                    class="inline-flex p-2 hover:bg-primary/10 font-semibold items-center justify-center rounded-lg border text-primary border-primary md:hidden">
                    <i class="ti ti-search text-lg"></i>
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
                            <li>
                                <a href="{{ route('admin.dashboard.index') }}" class="px-4 py-2 hover:!text-white hover:bg-primary flex items-center">
                                    <i class="ti ti-layout-dashboard text-lg me-1.5"></i>
                                    Dashboard
                                </a>
                            </li>
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
                    <div class="hidden md:flex gap-2">
                        <a href="{{ route('auth.login.index') }}" class="btn btn-primary btn-md">Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
