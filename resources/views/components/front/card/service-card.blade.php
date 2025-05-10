<a href="/id-id/{{ $slug }}">
    <div
        class="group relative rounded-xl bg-light shadow-md hover:shadow-lg hover:ring-2 hover:ring-primary overflow-hidden">
        <img alt="{{ $name }}" loading="lazy" data-src="{{ $image }}"
            class="lazyload w-full object-cover object-center bg-gray-700
                max-h-[150px] min-h-[185px] lg:max-h-[250px] lg:min-h-[250px]
                group-hover:brightness-75">
        <!-- Like icon -->
        <div class="absolute top-2 left-2 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-danger fill-current shadow" viewBox="0 0 20 20">
                <path
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
            </svg>
        </div>

        <!-- Rating -->
        <div class="absolute top-2 right-2 bg-primary text-white text-sm font-bold px-2 py-1 rounded-lg shadow">
            <span>4.5</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 ml-1 -mt-1 text-white fill-current"
                viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.217 3.736h3.925c.969 0 1.371 1.24.588 1.81l-3.177 2.308 1.217 3.737c.3.921-.755 1.688-1.54 1.117L10 13.347l-3.181 2.288c-.784.571-1.838-.196-1.539-1.117l1.217-3.737-3.177-2.308c-.783-.57-.38-1.81.588-1.81h3.925L9.049 2.927z" />
            </svg>
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black to-transparent text-white">
            <div class="flex flex-col">
                <h4 class="text-md font-bold truncat">
                    {{ $name ?? 'Judul' }}
                </h4>
                <p class="text-xs text-light truncate">
                    5 Reviews | 3 Kilometer
                </p>
            </div>
        </div>
    </div>
</a>
