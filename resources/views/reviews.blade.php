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
                <lord-icon
                    src="https://cdn.lordicon.com/abhwievu.json"
                    trigger="loop"
                    class="size-12"
                >
                </lord-icon>
                <div class="flex flex-col">
                    <h5 class="flex text-lg font-bold">
                        You Know What People Says?
                    </h5>
                    <span class="text-xs">Join the flavor conversation, reviews from real food lovers!</span>
                </div>
            </div>
            <div class="mb-3" id="restaurant-list">
                <div class="grid grid-cols-12 gap-6">
                    @foreach($comments as $comment)
                        <div class="col-span-12 lg:col-span-4">
                            <div class="mb-3">
                                <x-card.review-card 
                                    :userName="$comment->user->name" 
                                    :commentDate="$comment->created_at->format('d M Y')" 
                                    :userImage="$comment->user->avatar" 
                                    :rating="$comment->rating" 
                                    :restaurantName="$comment->restaurant->name"
                                    :commentAttachments="$comment->attachments" 
                                    :commentText="$comment->comment" 
                                    :commentId="$comment->id"
                                />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $comments->links() }}
                </div>
            </div>    
        </div>
    </div>
</section>
@endsection

@push('scripts')
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