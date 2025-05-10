<section class="px-4 md:px-2 bg-[url('{{ $backgroundImage }}')] py-6" id="restoran">
    <div class="max-w-screen-xl mx-auto">
        <h5 class="flex text-2xl font-semibold me-3">
            <lord-icon
                src="{{ $icon }}"
                trigger="loop"
                style="width:32px;height:32px"
            >
            </lord-icon>
            {{ $title }}
        </h5>
        <span class="text-xs">{{ $description }}</span>
        <div class="mt-3">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-4">
                {{ $slot }}
            </div>
        
            <div class="flex justify-center mt-4">
                <a href="/list" class="px-4 py-2 text-sm font-semibold text-white bg-primary hover:bg-primary/90 rounded-md transition-all">
                    See More
                </a>
            </div>
        </div>    
    </div>
</section>
