@extends('layouts.app')

@section('title', $page->title)

@section('content')
<div class="mt-[72px]">
    <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-6" id="restaurant">
        <div class="max-w-screen-xl mx-auto">
            <div class="px-4 md:px-2 pb-6 pt-3">
                <h5 class="text-2xl font-bold mb-4">{{ $page->title }}</h5>
                <p class="text-muted text-sm mb-4">
                    Updated on {{ $page->updated_at->format('F j, Y') }}
                </p>
                <div class="prose">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection