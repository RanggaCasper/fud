<nav class="bg-white px-4 md:px-2 border-b border-gray-200 fixed top-0 left-0 right-0 z-30">
    <div class="py-4 max-w-screen-xl mx-auto flex items-center justify-between space-x-4">

        <!-- Logo + Search -->
        <div class="flex items-center space-x-4 flex-1">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse shrink-0">
                <x-logo />
            </a>

            <!-- Search Bar -->
            <!-- Desktop view -->
            <div class="hidden md:block w-full max-w-sm">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari Restoran" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387-1.414 1.414-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <!-- Hasil Pencarian -->
                    <div id="searchResults" class="absolute left-0 right-0 bg-white border border-gray-300 mt-2 rounded-lg max-h-60 overflow-y-auto hidden"></div>
                </div>
            </div>

            <div id="searchContainer" class="w-0 max-w-xl hidden fixed top-0 left-0 right-0 z-50 bg-white shadow-lg p-4 transition-all duration-500 ease-in-out opacity-0">
                <div class="relative">
                    <input type="text" id="searchInputMobile" placeholder="Cari Restoran" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387-1.414 1.414-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <!-- Hasil Pencarian -->
                    <div id="searchResultsMobile" class="absolute left-0 right-0 bg-white border border-gray-300 mt-2 rounded-lg max-h-60 overflow-y-auto hidden"></div>
                    <!-- Close Button -->
                    <button id="closeSearch" type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                        <i class="ri ri-close-line text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Navigasi + Aksi -->
        <div class="flex items-center gap-4 ml-auto">
            <!-- Menu Navigasi (Tombol Dropdown atau Menu) -->
            <div id="main-nav" class="hidden md:flex items-center space-x-6 text-sm text-black font-medium">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('list') }}" class="nav-link">Restaurant</a>
                <a href="#review" class="nav-link">Review</a>
                <a href="#download" class="nav-link">Download</a>
                <a href="#">Work with Us</a>
                <a href="#faq" class="nav-link">FAQ</a>
            </div>

            <div class="flex gap-2">
                <button id="showSearch" type="button" class="inline-flex hover:bg-primary/10 font-semibold items-center justify-center size-10 rounded-lg border hover:border-2 text-primary border-primary md:hidden">
                    <i class="ri ri-search-line text-xl"></i>
                </button>
                @auth
                    <!-- Dropdown Button -->
                    <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar" data-dropdown-placement="bottom-end" class="flex text-sm bg-gray-800 size-10 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300" type="button">
                        <span class="sr-only">Open user menu</span>
                        
                        <!-- Check if the user has an avatar -->
                        @if(Auth::user()->avatar)
                            <!-- Show Avatar if exists -->
                            <img class="size-10 rounded-full" src="{{ Auth::user()->avatar }}" alt="user photo">
                        @else
                            <span class="size-10 flex items-center justify-center bg-primary text-white text-sm font-medium rounded-full">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownAvatar" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                        <div class="px-4 py-3 text-sm text-black">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                        </div>
                        <ul class="py-2 text-sm text-black" aria-labelledby="dropdownUserAvatarButton">
                            <li>
                                <a href="{{ route('dashboard.index') }}" class="block px-4 py-2 hover:bg-gray-100"><i class="ri ri-dashboard-line me-1.5"></i>Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}" class="block px-4 py-2 hover:bg-gray-100"><i class="ri ri-settings-line me-1.5"></i>Favorite</a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}" class="block px-4 py-2 hover:bg-gray-100"><i class="ri ri-settings-line me-1.5"></i>Review</a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}" class="block px-4 py-2 hover:bg-gray-100"><i class="ri ri-settings-line me-1.5"></i>Settings</a>
                            </li>
                        </ul>
                        <div class="py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block px-4 py-2 w-full text-left text-sm text-danger hover:bg-gray-100"><i class="ri ri-arrow-left-circle-line me-0.5"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex gap-2">
                        <a href="{{ route('auth.login.index') }}" class="btn btn-primary btn-md">Login</a>
                    </div>
                @endauth

                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex hover:bg-primary/10 font-semibold items-center justify-center size-10 rounded-lg border hover:border-2 text-primary border-primary md:hidden" aria-expanded="false">
                    <i class="ri ri-menu-line text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
