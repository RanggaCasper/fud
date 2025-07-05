<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-0 left-0 z-50 block w-80 h-screen transition-transform -translate-x-full shadow-md bg-secondary-background sm:hidden sm:translate-x-0"
    aria-label="Sidebar">
    <div class="flex items-center justify-between px-6 py-4 border-b border-dashed border-dark/50">
        <a href="/" class="flex items-center gap-2">
            <x-logo />
        </a>
        <button type="button" data-drawer-hide="sidebar" aria-controls="sidebar" class="inline-flex items-center justify-center text-sm font-medium transition-all rounded-lg hover:ring-primary hover:border-none hover:text-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-9 w-9 text-muted hover:bg-light" >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
    </div>
    <div id="sidebarMenu" class="px-3 py-6 overflow-y-auto h-screen no-scrollbar">
    </div>
</aside>
<!-- End Sidebar -->
