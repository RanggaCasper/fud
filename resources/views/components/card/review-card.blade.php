<div class="mx-auto bg-white rounded-xl shadow overflow-hidden p-6">
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center space-x-3">
            @if ($userImage)
                <img class="w-9 h-9 rounded-full border-2 border-gray-300 lazyload" data-src="{{ $userImage }}"
                    alt="profile picture">
            @else
                <span
                    class="w-9 h-9 flex items-center justify-center bg-primary text-white text-sm font-medium rounded-full">
                    {{ strtoupper(substr($userName, 0, 1)) }}
                </span>
            @endif
            <div class="space-y-0">
                <p class="font-semibold text-dark text-md line-clamp-1">{{ $userName }}</p>
                <p class="text-xs text-secondary">{{ $commentDate }}</p>
            </div>
        </div>

        <div class="flex items-center space-x-1 mb-3">
            <x-star rating="{{ $rating }}" />
        </div>
    </div>

    <div class="border-t w-full opacity-25 mb-3"></div>

    <a href="{{ Route('restaurant.index', ['slug' => Str::slug($restaurantName)]) }}"
        class="font-semibold mb-3 hover:text-primary">{{ $restaurantName }}</a>
    <div class="swiper reviewSwiper rounded-lg mb-3">
        <div class="gallery-{{ $commentId }}">
            <div class="swiper-wrapper ">
                @foreach ($commentAttachments as $attachment)
                    <div class="swiper-slide">
                        <img class="gallery-image w-full h-48 object-cover rounded-lg lazyload"
                            data-src="{{ Storage::url($attachment->source) }}" alt="Review Image">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="comment-wrapper">
        <p class="text-sm line-clamp-2 comment-text">
            {{ $commentText }}
        </p>
        <span class="toggle-readmore hover:underline text-sm text-primary cursor-pointer">Read More</span>
    </div>


    <div class="flex items-center justify-between gap-2">
        <div>
            <button class="hover:rounded-full hover:bg-gray-200 hover:text-primary py-0.5 px-1.5"><i
                    class="ri-thumb-up-line text-2xl"></i></button>
            <span></span>
        </div>
        <div>
            <button data-dropdown-toggle="dropdownReview{{ $commentId }}" data-dropdown-placement="bottom-end"
                class="hover:rounded-full hover:bg-gray-200 hover:text-primary py-0.5 px-1.5"><i
                    class="ri ri-more-2-line hover:text-primary text-2xl"></i></button>
        </div>
    </div>
</div>
<div id="dropdownReview{{ $commentId }}"
    class="z-10 hidden bg-secondary-background divide-y divide-gray-100 rounded-lg shadow-sm w-36">
    <ul class="py-2 text-sm text-black" aria-labelledby="dropdownReviewButton">
        <li>
            <a href="#" data-modal-target="reportModal" data-modal-toggle="reportModal"
                data-comment-id="{{ $commentId }}"
                class="reporting px-4 py-2 hover:!text-white hover:bg-danger flex items-center">
                <i class="ti ti-alert-circle text-lg me-1.5"></i>
                Report
            </a>
        </li>
    </ul>
</div>

@once
    @push('scripts')
        <x-modal title="Report Comment" id="reportModal" size="md">
            <form action="{{ route('reason.report') }}" method="POST">
                @csrf
                <input type="hidden" name="comment_id" value="">

                <ul class="space-y-1 text-sm text-gray-700" aria-labelledby="dropdownHelperRadioButton">
                    <x-reason-radio id="reason-1" value="spam" label="Spam"
                        helperText="The content is misleading or unwanted." />

                    <x-reason-radio id="reason-2" value="abuse" label="Abuse"
                        helperText="The content contains abusive language or behavior." />

                    <x-reason-radio id="reason-3" value="other" label="Other"
                        helperText="Some other reason not listed above." />
                </ul>

                <div class="flex justify-end mt-4">
                    <x-button type="submit">Submit Report</x-button>
                </div>
            </form>
        </x-modal>
        <script>
            $(document).ready(function() {
                $('.comment-wrapper').each(function() {
                    const $wrapper = $(this);
                    const $text = $wrapper.find('.comment-text');
                    const $toggle = $wrapper.find('.toggle-readmore');

                    const $clone = $text.clone().css({
                        'visibility': 'hidden',
                        'position': 'absolute',
                        'height': 'auto',
                        'max-height': 'none',
                        'overflow': 'visible'
                    }).removeClass('line-clamp-2').appendTo('body');

                    const actualHeight = $clone.height();
                    const lineHeight = parseFloat($text.css('line-height'));
                    const maxLines = 2;

                    $clone.remove();

                    if (actualHeight > lineHeight * maxLines) {
                        $toggle.removeClass('hidden');
                    }

                    $toggle.on('click', function() {
                        const isExpanded = !$text.hasClass('line-clamp-2');

                        if (isExpanded) {
                            $text.addClass('line-clamp-2');
                            $toggle.text('Read More');
                        } else {
                            $text.removeClass('line-clamp-2');
                            $toggle.text('Read Less');
                        }
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.reporting').forEach(function(el) {
                    el.addEventListener('click', function() {
                        const commentId = this.getAttribute('data-comment-id');
                        const modal = document.getElementById('reportModal');
                        const input = modal.querySelector('input[name="comment_id"]');
                        input.value = commentId;
                    });
                });
            });
        </script>
    @endpush
@endonce
