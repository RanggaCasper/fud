<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 block w-64 h-screen transition-transform -translate-x-full shadow-md bg-light sm:hidden sm:translate-x-0" aria-label="Sidebar">  
    <div class="flex items-center justify-between px-6 py-4 border-b border-dashed border-dark/50">  
        <a href="/">  
            <x-logo />
        </a>
    </div>
    <div class="px-3 py-4 overflow-y-auto">
        <ul class="flex flex-col space-y-2 font-medium mb-2" id="sidebar-menu">
        </ul>
        <ul class="flex flex-col space-y-2 font-medium">
            <a href="{{ route('auth.register.index') }}" class="block py-2 px-4 rounded hover:bg-primary/10 text-dark hover:text-primary transition">Register</a>
            <a href="{{ route('auth.login.index') }}" class="flex justify-between py-2 px-4 rounded bg-primary text-white transition">Login <i class="ri ri-arrow-right-circle-line"></i></a>
        </ul>
    </div>
</aside>
<!-- End Sidebar -->
