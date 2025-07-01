@extends('layouts.app')
@section('title', 'Reviews On Fudz!')

@section('content')
    <div class="mt-[72px]">
        @php
            $carouselItems = [
                ['src' => 'https://b.zmtcdn.com/data/o2_assets/85e14f93411a6b584888b6f3de3daf081716296829.png'],
            ];
        @endphp

        <x-section.carousel-section sectionId="home" :items="$carouselItems" />
    </div>

    <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6" id="restaurant">
        <div class="px-4 md:px-2">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex my-3">
                    <lord-icon src="https://cdn.lordicon.com/abhwievu.json" trigger="loop" class="size-12">
                    </lord-icon>
                    <div class="flex flex-col">
                        <h5 class="flex text-lg font-bold">
                            You Know What People Says?
                        </h5>
                        <span class="text-xs">Join the flavor conversation, reviews from real food lovers!</span>
                    </div>
                </div>
                <div class="mb-3" id="restaurant-list">
                    <div id="comment-container" class="columns-1 sm:columns-2 lg:columns-3 gap-6">
                        @foreach ($comments as $comment)
                            <div class="break-inside-avoid mb-6">
                                <x-card.review-card :comment="$comment" />
                            </div>
                        @endforeach
                    </div>

                    @if ($comments->hasMorePages())
                        <div id="scroll-loader" class="text-center mt-6" data-next-page="{{ $comments->nextPageUrl() }}">
                            <span class="text-sm text-gray-500">Loading more...</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let isLoading = false;
            const $container = $('#comment-container');

            const observer = new IntersectionObserver(function(entries) {
                if (entries[0].isIntersecting && !isLoading) {
                    loadMoreComments();
                }
            }, {
                threshold: 1.0
            });

            if ($('#scroll-loader').length) {
                observer.observe(document.querySelector('#scroll-loader'));
            }

            function loadMoreComments() {
                const $loader = $('#scroll-loader');
                const nextPage = $loader.data('next-page');
                if (!nextPage) return;

                isLoading = true;
                $loader.find('span').text('Loading...');

                $.get(nextPage, function(response) {
                    const $html = $('<div>').html(response);

                    const $newItems = $html.find('.break-inside-avoid.mb-6');
                    const $newLoader = $html.find('#scroll-loader');

                    $newItems.find('img[data-src]').each(function() {
                        const src = $(this).attr('data-src');
                        $(this).attr('src', src).removeAttr('data-src');
                    });


                    $container.append($newItems);

                    if ($newLoader.length) {
                        observer.unobserve($loader[0]);
                        $loader.replaceWith($newLoader);
                        observer.observe(document.querySelector('#scroll-loader'));
                    } else {
                        $loader.remove();
                    }

                    isLoading = false;
                }).fail(function() {
                    $('#scroll-loader').find('span').text('Something went wrong!');
                    isLoading = false;
                });
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $("#owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                nav: false,
                dots: false,
            });
        });
    </script>
@endpush
