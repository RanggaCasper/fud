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
        @php
            $comments = [
                [
                    'userName' => 'Alexandre Petrov',
                    'commentDate' => '07 May 2025',
                    'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                    'rating' => 3,
                    'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                ],
                [
                    'userName' => 'Alexandre Petrov',
                    'commentDate' => '07 May 2025',
                    'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                    'rating' => 3,
                    'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                ],
                [
                    'userName' => 'Alexandre Petrov',
                    'commentDate' => '07 May 2025',
                    'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                    'rating' => 3,
                    'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                ],
                [
                    'userName' => 'Alexandre Petrov',
                    'commentDate' => '07 May 2025',
                    'userImage' => 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png',
                    'rating' => 3,
                    'commentImage' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w1NzgzNjl8MHwxfHNlYXJjaHwxOXx8Zm9vZHxlbnwwfHx8fDE3NDY1NTA0NzF8MA&ixlib=rb-4.1.0&q=80&w=1080',
                    'commentText' => 'Taste like lorem ipsum kolor si memet, consectetur adipiscing elit. Mauris scelerisque tortor et magna feugiat, eu vehicula erat consequat.'
                ],
            ];
        @endphp

        @foreach($comments as $comment)
            <div class="mb-3">
                <x-card.comment-card 
                    :userName="$comment['userName']" 
                    :commentDate="$comment['commentDate']" 
                    :userImage="$comment['userImage']" 
                    :rating="$comment['rating']" 
                    :commentImage="$comment['commentImage']" 
                    :commentText="$comment['commentText']" 
                />
            </div>
        @endforeach

        <div class="flex items-center justify-between">
            <span class="text-sm text-dark">Showing 1-4 of 4 enteries</span>
            <nav aria-label="Page navigation example">
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="z-10 flex items-center justify-center px-3 h-8 leading-tight text-primary border border-primary bg-blue-50 hover:bg-blue-100 hover:text-primary/90">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">4</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">5</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">
                            <span class="sr-only">Next</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</x-card>
@endsection