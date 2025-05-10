<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6">
    <!-- Comment Card Content -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
            <!-- Profile Image -->
            <img class="w-10 h-10 rounded-full border-2 border-gray-300 lazyload" loading="lazy" data-src="{{ $userImage }}" alt="profile picture">
            <div class="space-y-0">
                <p class="font-semibold text-dark text-md">{{ $userName }}</p>
                <p class="text-xs text-secondary">{{ $commentDate }}</p>
            </div>
        </div>

        <!-- Rating -->
        <div class="flex items-center space-x-1 mb-4">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $rating)
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                    </svg>
                @endif
            @endfor
        </div>
    </div>

    <!-- Comment Image -->
    <img class="w-full h-48 object-cover rounded-lg mb-4" src="{{ $commentImage }}" alt="Food Image">

    <!-- Comment Text -->
    <p class="text-sm mb-4">
        {{ $commentText }}
        <span class="text-primary">Read More...</span>
    </p>
</div>
