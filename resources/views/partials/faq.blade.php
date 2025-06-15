@php
    $faqs = [
        [
            'question' => 'What is Flowbite?',
            'answer' =>
                'Flowbite is an open-source library of interactive components built on top of Tailwind CSS...',
            'link' => '/docs/getting-started/introduction/',
        ],
        [
            'question' => 'Is there a Figma file available?',
            'answer' => 'Flowbite is first conceptualized and designed using the Figma software...',
            'link' => 'https://flowbite.com/figma/',
        ],
        [
            'question' => 'What are the differences between Flowbite and Tailwind UI?',
            'answer' =>
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit... Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit... Lorem ipsum dolor sit amet, consectetur adipiscing elit lorem ipsum dolor sit amet, consectetur adipiscing elit...',
        ],
    ];
    @endphp

<section class="px-4 md:px-2 py-6 bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')]" id="faq">
    <div class="max-w-screen-xl py-4 mx-auto">
        <h5 class="block mb-1 text-2xl font-semibold text-muted">
            FAQ
        </h5>
        <span class="text-xs">Frequently Asked Questions</span>

        <div id="accordion-flush" data-accordion="collapse" data-active-classes="text-muted" data-inactive-classes="text-light">
            @foreach($faqs as $index => $faq)
                <h5 id="accordion-flush-heading-{{ $index }}">
                    <button type="button" class="flex items-center justify-between w-full gap-2 py-3 font-medium transition-all duration-300 ease-in-out border-b border-light text-muted rtl:text-right" data-accordion-target="#accordion-flush-body-{{ $index }}" aria-expanded="false" aria-controls="accordion-flush-body-{{ $index }}">
                        <span class="text-sm text-muted">{{ $faq['question'] }}</span>
                        <svg data-accordion-icon class="w-3 h-3 transition-transform duration-300 rotate-180 text-muted shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-flush-body-{{ $index }}" class="hidden transition-all duration-300 ease-in-out" aria-labelledby="accordion-flush-heading-{{ $index }}">
                    <div class="py-3 border-b border-light">
                        <p class="mb-1 text-sm text-muted">{{ $faq['answer'] }}</p>
                        @if(isset($faq['link']))
                            <p class="text-sm text-muted">Check out this guide: <a href="{{ $faq['link'] }}" class="text-primary hover:underline">get started</a></p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
