<div class="hidden col-span-3 lg:block">
    <div class="w-full h-full py-4 overflow-y-auto bg-transparent">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="#"
                class="flex items-center p-2 rounded-lg text-muted hover:bg-primary hover:text-white gap-2 group {{ request()->is('dashboard') ? 'bg-primary text-white' : '' }}">
                    <i class="ri ri-dashboard-line text-xl"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#"
                class="flex items-center p-2 rounded-lg text-muted hover:bg-primary hover:text-white gap-2 group {{ request()->is('favorite') ? 'bg-primary text-white' : '' }}">
                    <i class="ri ri-heart-line text-xl"></i>
                    <span>Favorite</span>
                </a>
            </li>
            <li>
                <a href="#"
                class="flex items-center p-2 rounded-lg text-muted hover:bg-primary hover:text-white gap-2 group {{ request()->is('settings') ? 'bg-primary text-white' : '' }}">
                    <i class="ri ri-settings-line text-xl"></i>
                    <span>Settings</span>
                </a>
            </li>
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
