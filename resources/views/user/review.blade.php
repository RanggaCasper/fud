@extends('layouts.panel')

@section('content')
    <x-card title="My Reviews">
        @include('partials.point')
        <div class="mb-3">
            <h5 class="text-lg font-semibold">Latest Reviews</h5>
            <div class="grid grid-cols-12 gap-6">
                @forelse ($comments as $comment)
                    <div class="col-span-12 md:col-span-6">
                        <div class="mb-3">
                            <x-card.review-card :comment="$comment" />
                        </div>
                    </div>
                @empty
                    <div class="col-span-12">
                        <div class="mt-6">
                            <img src="{{ asset('assets/svg/undraw_empty_4zx0.svg') }}" class="h-64 mx-auto"
                                alt="No reviews">
                            <div class="text-center text-muted font-semibold mt-3">
                                You haven't made any reviews yet.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $comments->links() }}
            </div>
        </div>
    </x-card>
@endsection
