@extends('layouts.panel')

@section('content')
    <x-card title="My Reviews">
        <div class="mb-3">
            <div class="flex items-center gap-2">
                <img class="size-32 rounded-full" src="{{ Auth::user()->avatar }}" alt="Image description" srcset="">
                <div class="flex flex-col w-full">
                    <h5 class="text-lg font-semibold">{{ Auth::user()->name }}</h5>
                    <p class="text-sm text-secondary">Local Explorer Level 6</p>
                    <div class="w-full">
                        <div class="text-right text-xs text-gray-700 mt-1">
                            169 Points &gt;
                        </div>

                        <div class="relative w-full h-2 bg-gray-300 rounded">
                            <div class="absolute top-0 left-0 h-2 bg-orange-600 rounded" style="width: 55%;">
                            </div>
                        </div>

                        <div class="flex justify-between text-sm text-gray-500 mb-1">
                            <span>55</span>
                            <span>300</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <h5 class="text-lg font-semibold">Latest Reviews</h5>
            <div class="grid grid-cols-12 gap-6">
                @forelse ($comments as $comment)
                    <div class="col-span-12 md:col-span-6">
                        <div class="mb-3">
                            <x-card.review-card :userName="$comment->user->name" :commentDate="$comment->created_at->format('d M Y')" :userImage="$comment->user->avatar" :rating="$comment->rating"
                                :restaurantName="$comment->restaurant->name" :commentImage="$comment->image" :commentText="$comment->comment" :commentId="$comment->id" />
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
