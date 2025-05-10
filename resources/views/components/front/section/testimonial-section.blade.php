<section class="px-4 md:px-2 py-6 bg-primary" id="{{ $sectionId }}">
    <div class="max-w-screen-xl py-4 mx-auto">
        <div class="text-white mb-3">
            <h5 class="flex text-2xl font-semibold me-3">
                <lord-icon
                    src="{{ $iconSrc }}"
                    trigger="loop"
                    style="width:32px;height:32px">
                </lord-icon>
                {{ $title }}
            </h5>
            <span class="text-xs">{{ $description }}</span>
        </div>
        
        <div class="swiper">
            <div class="swiper-wrapper py-3">
                @foreach($comments as $comment)
                    <div class="swiper-slide">
                        <x-front.card.comment-card 
                            :userName="$comment['userName']" 
                            :commentDate="$comment['commentDate']" 
                            :userImage="$comment['userImage']" 
                            :rating="$comment['rating']" 
                            :commentImage="$comment['commentImage']" 
                            :commentText="$comment['commentText']" 
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
