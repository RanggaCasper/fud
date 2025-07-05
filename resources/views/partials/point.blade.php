<div class="mb-3">
    <div class="flex items-center gap-6">
        @if (Auth::user()->avatar)
            <img class="size-24 rounded-full object-cover" src="{{ Auth::user()->avatar }}" alt="user photo">
        @else
            <span
                class="size-24 flex items-center justify-center bg-primary text-white text-xl font-medium rounded-full">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
        @endif
        <div class="flex flex-col w-full">
            <h5 class="text-lg font-semibold">{{ Auth::user()->name }}</h5>
            @php
                $level = \App\Helpers\Point::getLevel(Auth::user());
                $progress = \App\Helpers\Point::getProgressData(Auth::user());
            @endphp

            <p class="text-sm text-secondary">
                {{ $level->name ?? 'Level 0' }}
            </p>

            <div class="w-full">
                <div class="text-right text-xs text-gray-700 mt-1">
                    <a class="hover:text-primary hover:underline"
                        href="{{ route('user.point.index') }}">{{ $progress['current_points'] }} Points &gt;</a>
                </div>

                <div class="relative w-full h-2 bg-gray-300 rounded">
                    <div class="absolute top-0 left-0 h-2 bg-primary rounded"
                        style="width: {{ $progress['progress'] }}%;">
                    </div>
                </div>

                <div class="flex justify-between text-sm text-gray-500 mb-1">
                    <span>{{ $progress['min'] }}</span>
                    <span>{{ $progress['max'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
