<div class="mx-auto bg-white rounded-xl shadow overflow-hidden p-6">
    <!-- Comment Card Content -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center space-x-3">
            <!-- Profile Image -->
            <img class="w-10 h-10 rounded-full border-2 border-gray-300 lazyload" loading="lazy"
                data-src="{{ $userImage }}" alt="profile picture">
            <div class="space-y-0">
                <p class="font-semibold text-dark text-md line-clamp-1">{{ $userName }}</p>
                <p class="text-xs text-secondary">{{ $commentDate }}</p>
            </div>
        </div>

        <!-- Rating -->
        <div class="flex items-center space-x-1 mb-3">
            <x-star rating="{{ $rating }}" />
        </div>
    </div>

    <div class="border-t w-full opacity-25 mb-3"></div>

    <!-- Comment Image -->
    <a href="{{ Route('restaurant.index', ['slug' => Str::slug($restaurantName)]) }}"
        class="font-semibold mb-3 hover:text-primary">{{ $restaurantName }}</a>
        <div class="swiper reviewSwiper rounded-lg mb-3">
            <div class="swiper-wrapper">
                @forelse($commentAttachments as $attachment)
                    <div class="swiper-slide">
                        <img class="w-full h-48 object-cover rounded-lg lazyload" data-src="{{ Storage::url($attachment->source) }}"
                            alt="Review Image">
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="w-full h-48 rounded-lg flex items-center justify-center bg-gray-200 text-gray-500 text-sm font-medium italic">
                            No Image Available
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>

    <!-- Comment Text -->
    <p class="text-sm mb-3">
        {{ $commentText }}
    </p>

    <div class="flex items-center justify-between gap-2">
        <div>
            <button class="hover:rounded-full hover:bg-gray-200 hover:text-primary py-0.5 px-1.5"><i
                    class="ri-thumb-up-line text-2xl"></i></button>
            <span>1</span>
        </div>
        <div>
            <button data-dropdown-toggle="dropdownReview{{ $commentId }}" data-dropdown-placement="bottom-end"
                class="hover:rounded-full hover:bg-gray-200 hover:text-primary py-0.5 px-1.5"><i
                    class="ri ri-more-2-line hover:text-primary text-2xl"></i></button>
        </div>
    </div>
</div>

<!-- Dropdown menu for each comment -->
<div id="dropdownReview{{ $commentId }}"
    class="z-10 hidden bg-secondary-background divide-y divide-gray-100 rounded-lg shadow-sm w-36">
    <ul class="py-2 text-sm text-black" aria-labelledby="dropdownReviewButton">
        <li>
            <a href="{{ Route('restaurant.index', ['slug' => Str::slug($restaurantName)]) }}"
                class="px-4 py-2 hover:!text-white hover:bg-primary flex items-center">
                <i class="ti ti-share text-lg me-1.5"></i>
                Share
            </a>
        </li>
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
    <!-- Modal for reporting comments -->

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
