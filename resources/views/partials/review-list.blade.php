@foreach ($comments as $comment)
    <div class="break-inside-avoid mb-6">
        <x-card.review-card :comment="$comment" />
    </div>
@endforeach

@if ($comments->hasMorePages())
    <div id="scroll-loader" class="text-center mt-6" data-next-page="{{ $comments->nextPageUrl() }}">
        <span class="text-sm text-gray-500">Loading more...</span>
    </div>
@endif
