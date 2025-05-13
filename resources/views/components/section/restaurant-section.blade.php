<section class="px-4 md:px-2 bg-[url('{{ $backgroundImage }}')] py-6" id="restoran">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex gap-2 mb-3">
        <x-button class="space-x-1" :outline="true" data-modal-target="filterModal" data-modal-toggle="filterModal"><i class="ri ri-filter-line"></i><span>Filter</span></x-button>
            <x-button :outline="true">Cuisines <i class="ri ri-arrow-down-line"></i></x-button>
            <x-button :outline="true">Popular</x-button>
            <x-button :outline="true">Rating 4.5</x-button>
            <x-button :outline="true">Halal</x-button>
        </div>

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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                {{ $slot }}
            </div>
        
            <div class="flex justify-center mt-4">
                <a href="/list" class="px-4 py-2 text-sm font-semibold text-white bg-primary hover:bg-primary/90 rounded-md transition-all">
                    See More
                    <i class="ri ri-arrow-right-line"></i>
                </a>
            </div>
        </div>    
    </div>
</section>

<x-modal title="Filter" id="filterModal">

</x-modal>
