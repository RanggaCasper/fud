@props(['comment'])

@php
    $commentId = $comment->id;
    $user = $comment->user;
    $userName = $user->name ?? 'User';
    $userImage = $user->avatar ?? null;
    $commentDate = $comment->created_at->locale('en')->diffForHumans();
    $rating = $comment->rating;
    $commentText = $comment->comment;
    $restaurantName = $comment->restaurant->name ?? 'Restaurant';
    $commentAttachments = $comment->attachments ?? collect();
    $hasLiked = $comment->likes->contains('user_id', auth()->id());
@endphp

<div class="mx-auto bg-white rounded-xl shadow overflow-hidden p-6 h-full flex flex-col">
    {{-- Header --}}
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
            <div>
                <p class="font-semibold text-dark text-md line-clamp-1">{{ $userName }}</p>
                @php
                    $level = \App\Helpers\Point::getLevel($user);
                @endphp
                <p class="text-xs text-secondary">{{ $level->name ?? 'Level 0' }}</p>
            </div>
        </div>
    </div>

    <div class="border-t w-full opacity-25 mb-3"></div>

    <div class="mb-1">
        <x-star rating="{{ $rating }}" />
    </div>

    {{-- Restaurant --}}
    <a href="{{ route('restaurant.index', ['slug' => Str::slug($restaurantName)]) }}"
        class="font-semibold mb-3 hover:text-primary block">{{ $restaurantName }}</a>

    {{-- Comment --}}
    <div class="comment-wrapper mb-3 flex-grow">
        <p class="text-sm line-clamp-2 comment-text">{{ $commentText }}</p>
        <span class="toggle-readmore hover:underline text-sm text-primary cursor-pointer hidden">Read More</span>
    </div>

    {{-- Attachments --}}
    @if ($commentAttachments->isNotEmpty())
        <div class="viewer-gallery grid grid-cols-2 md:grid-cols-3 gap-3 mb-3">
            @foreach ($commentAttachments as $attachment)
                <div>
                    <img class="w-full cursor-zoom-in aspect-square object-cover rounded-lg lazyload"
                        data-src="https://fudz.my.id/storage/{{ $attachment->source }}"
                        src="https://fudz.my.id/storage/{{ $attachment->source }}" alt="Review Image">
                </div>
            @endforeach
        </div>
    @endif

    <p class="text-xs mb-3 text-secondary">Posted {{ $commentDate }}</p>

    {{-- Footer --}}
    <div class="flex items-center justify-between gap-2 mt-auto pt-2 border-t border-gray-100">
        <div class="flex items-center space-x-1">
            <button data-like-id="{{ $commentId }}"
                class="like-button hover:rounded-full hover:bg-gray-200 hover:text-primary py-0.5 px-1.5">
                <i class="ti {{ $hasLiked ? 'ti-thumb-up-filled text-primary' : 'ti-thumb-up' }} text-2xl"></i>
            </button>
            <span class="like-count" data-like-id="{{ $commentId }}">{{ $comment->likes->count() }}</span>
        </div>
        <div>
            <button data-dropdown-toggle="dropdownReview{{ $commentId }}" data-dropdown-placement="bottom-end"
                class="hover:rounded-full hover:bg-gray-200 hover:text-primary py-0.5 px-1.5">
                <i class="ti ti-dots-vertical hover:text-primary text-2xl"></i>
            </button>
        </div>
    </div>
</div>

<div id="dropdownReview{{ $commentId }}"
    class="z-10 hidden bg-secondary-background divide-y divide-gray-100 rounded-lg shadow-sm w-36">
    <ul class="py-2 text-sm text-black" aria-labelledby="dropdownReviewButton">
        @if ($comment->user_id === Auth::id())
            <li>
                <button id="btnReviewUpdate" data-modal-target="reviewUpdateModal" data-modal-toggle="reviewUpdateModal"
                    data-edit-comment="{{ $commentId }}"
                    class="edit-comment w-full px-4 py-2 hover:!text-white hover:bg-primary flex items-center">
                    <i class="ti ti-edit text-lg me-1.5"></i> Edit
                </button>
            </li>
            <li>
                <form action="{{ route('user.review.destroy', $commentId) }}" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="delete-comment w-full px-4 py-2 hover:!text-white hover:bg-danger flex items-center">
                        <i class="ti ti-trash text-lg me-1.5"></i> Delete
                    </button>
                </form>
            </li>
        @else
            <li>
                <button data-modal-target="reportModal" data-modal-toggle="reportModal"
                    data-comment-id="{{ $commentId }}"
                    class="reporting w-full px-4 py-2 hover:!text-white hover:bg-danger flex items-center">
                    <i class="ti ti-alert-circle text-lg me-1.5"></i> Report
                </button>
            </li>
        @endif
    </ul>
</div>

@once
    <x-modal title="Update Your Review" id="reviewUpdateModal">
        <form method="POST" id="formReviewUpdate" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <div class="relative">
                    <label class="block w-full mb-2 text-sm font-semibold tracking-wide" for="starRating_update">
                        Update your rating <span class="!text-danger">*</span>
                    </label>
                    <input type="hidden" name="rating" id="ratingInput_update" value="{{ $comment->rating }}">
                    <div id="starRating_update" class="flex space-x-1 cursor-pointer">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="ti ti-star-filled text-2xl transition-transform cursor-pointer 
                        {{ $i <= $comment->rating ? 'text-warning' : 'text-gray-300' }}"
                                data-index="{{ $i }}"></i>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="relative">
                    <label class="block w-full mb-2 text-sm font-semibold tracking-wide" for="comment_update">
                        Update your review <span class="text-red-500">*</span>
                    </label>
                    <textarea name="comment"
                        id="comment_update"
                        class="w-full h-32 border-2 border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary px-3 py-2"
                        placeholder="Any changes or updates?" required></textarea>
                </div>
            </div>

            <div class="mb-3">
                <x-filepond class="filepond-image" label="Add some photos" name="attachments[]" id="imageReview_update"
                    multiple :required="false" />
                <span class="text-xs text-secondary">This will replace your attachments</span>
            </div>

            <x-button type="submit" class="w-full">
                Update Review
            </x-button>
        </form>
    </x-modal>

    <x-modal title="Report a Problem" id="reportModal" size="md">
        <form action="{{ route('user.review.report') }}" method="POST">
            @csrf
            <input type="hidden" name="comment_id">

            <ul class="space-y-1 text-sm text-gray-700">
                <x-reason-radio id="reason-1" value="spam" label="Spam"
                    helperText="The content is misleading or unwanted." />
                <x-reason-radio id="reason-2" value="abuse" label="Abuse"
                    helperText="The content contains abusive language or behavior." />
                <x-reason-radio id="reason-3" value="hate-speech" label="Hate Speech"
                    helperText="The content promotes violence or hatred against individuals or groups." />
                <x-reason-radio id="reason-4" value="harassment" label="Harassment"
                    helperText="The content is targeting someone in a threatening or bullying manner." />
                <x-reason-radio id="reason-5" value="false-information" label="False Information"
                    helperText="The content contains inaccurate or misleading claims." />
                <x-reason-radio id="reason-6" value="off-topic" label="Off-topic"
                    helperText="The content is irrelevant or not related to the discussion." />
            </ul>

            <div class="flex justify-end mt-4">
                <x-button type="submit">Submit Report</x-button>
            </div>
        </form>
    </x-modal>
    @push('scripts')

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/viewerjs@1.11.6/dist/viewer.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/viewerjs@1.11.6/dist/viewer.min.js"></script>
        <script>
            function initViewer() {
                const galleries = document.querySelectorAll('.viewer-gallery');

                galleries.forEach(function(gallery) {
                    if (!gallery._viewer) {
                        gallery._viewer = new Viewer(gallery, {
                            toolbar: true,
                            navbar: false,
                            title: false,
                            tooltip: true,
                            movable: true,
                            transition: true,
                        });
                    }
                });
            }

            function initReporting() {
                $('.reporting').on('click', function() {
                    const commentId = $(this).data('comment-id');
                    const $modal = $('#reportModal');
                    const $input = $modal.find('input[name="comment_id"]');
                    $input.val(commentId);
                });
            }
        </script>

        <script>
            const starsUpdate = document.querySelectorAll('#starRating_update i');
            const ratingInputUpdate = document.getElementById('ratingInput_update');

            starsUpdate.forEach((star, index) => {
                star.addEventListener('click', () => {
                    const rating = index + 1;
                    ratingInputUpdate.value = rating;

                    starsUpdate.forEach((s, i) => {
                        if (i < rating) {
                            s.classList.remove('text-gray-300');
                            s.classList.add('text-warning');
                        } else {
                            s.classList.remove('text-warning');
                            s.classList.add('text-gray-300');
                        }
                    });
                });
            });
        </script>

        <script>
            $('.edit-comment').on('click', function() {
                var id = $(this).data('edit-comment');
                $.ajax({
                    url: '{{ route('user.review.getById', ['id' => ':id']) }}'.replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#formReviewUpdate').attr('action',
                            '{{ route('user.review.update', ['id' => ':id']) }}'.replace(':id', id));
                        $('#ratingInput_update').val(response.data.rating);
                        $('#comment_update').val(response.data.comment);
                        $('#starRating_update').find('i').each(function(index) {
                            if (index < response.data.rating) {
                                $(this).removeClass('text-gray-300').addClass('text-warning');
                            } else {
                                $(this).removeClass('text-warning').addClass('text-gray-300');
                            }
                        });
                    },
                    error: function(error) {
                        console.error(error);
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat mengambil data kategori.',
                            'error'
                        );
                    }
                });
            });

            $('.comment-wrapper').each(function() {
                const $wrapper = $(this);
                const $text = $wrapper.find('.comment-text');
                const $toggle = $wrapper.find('.toggle-readmore');

                const fullText = $text.text().trim();
                const maxChars = 100;

                if (fullText.length > maxChars) {
                    $toggle.removeClass('hidden');
                } else {
                    $toggle.addClass('hidden');
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

            $(document).ready(function() {
                initViewer();
                initReporting();
                $(document).on('click', '.like-button', function() {
                    const button = $(this);
                    const commentId = button.data('like-id');
                    const icon = button.find('i');

                    $.ajax({
                        url: '{{ route('user.review.like', ['id' => ':id']) }}'.replace(':id',
                            commentId),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                        },
                        success: function(response) {
                            $(`.like-count[data-like-id="${commentId}"]`).text(response.data.likes);
                            if (response.data.liked) {
                                icon.removeClass('ti-thumb-up').addClass(
                                    'ti-thumb-up-filled text-primary');
                            } else {
                                icon.removeClass('ti-thumb-up-filled text-primary').addClass(
                                    'ti-thumb-up');
                            }
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || 'Something went wrong.';
                            window.location.href = xhr.responseJSON.redirect_url;
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce
