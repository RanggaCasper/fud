@props([
    'rating' => 0,
    'max' => 5
])

<div class="flex items-center space-x-1">
    @for ($i = 1; $i <= $max; $i++)
        @if ($i <= $rating)
            <i class="ti ti-star-filled text-warning"></i>
        @else
            <i class="ti ti-star-filled text-gray-300"></i>
        @endif
    @endfor
</div>
