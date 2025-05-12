<section class="p-4 md:px-2 bg-light bg-opacity-90" id="{{ $sectionId }}">
    <div class="max-w-screen-xl mx-auto">
        <div class="owl-carousel owl-theme" id="owl-carousel">
            @foreach($items as $item)
                <x-carousel-item :src="$item['src']" />
            @endforeach
        </div>
    </div>
</section>
