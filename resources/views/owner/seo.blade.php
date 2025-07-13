@extends('layouts.panel')

@section('content')
    <x-card.card title="Manage SEO">
        <form method="POST" data-reset="false">
            @csrf
            @method('PUT')
            <div class="mb-3 flex justify-end">
                <x-button id="generate-seo" type="button" color="success">
                    Generate With AI
                </x-button>
            </div>
            <div class="mb-3">
                <x-input label="Meta Title" id="meta_title" name="meta_title"
                    value="{{ optional(Auth::user()->owned->restaurant->metaTag)->meta_title }}" type="text" />
            </div>

            <div class="mb-3">
                <x-input label="Meta Description" id="meta_description" name="meta_description"
                    value="{{ optional(Auth::user()->owned->restaurant->metaTag)->meta_description }}" type="text" />
            </div>

            <div class="mb-3">
                <x-input label="Meta Keywords" id="meta_keywords" name="meta_keywords"
                    value="{{ implode(',', optional(Auth::user()->owned->restaurant->metaTag)->meta_keywords ?? []) }}"
                    type="text" />
            </div>

            <x-button type="submit">Submit</x-button>
            <x-button type="reset">Reset</x-button>
        </form>
    </x-card.card>

    @php
        $faqs = [
            [
                'question' => 'What are meta tags on a website?',
                'answer' =>
                    'Meta tags are snippets of HTML code placed in the <head> section of a webpage to provide metadata such as title, description, and preview information for search engines and social media.',
            ],
            [
                'question' => 'Why are meta tags important for SEO?',
                'answer' =>
                    'Meta tags help search engines understand the content of your page. Proper use of meta titles and descriptions can improve visibility and click-through rates in search results.',
            ],
            [
                'question' => 'Can I customize meta tags for each page?',
                'answer' =>
                    'Yes, modern websites and frameworks allow you to set dynamic meta tags for each page to improve relevance and search engine performance.',
            ],
        ];
    @endphp

    @include('partials.faq', ['faqs' => $faqs])
@endsection

@push('scripts')
    <script>
        $('#generate-seo').on('click', function() {
            const $btn = $(this);
            const defaultText = $btn.text();

            $btn.text('Generating...').attr('disabled', true);

            $.ajax({
                url: '{{ route('owner.seo.generate') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                contentType: 'application/json',
                data: JSON.stringify({}),
                success: function(res) {
                    if (res.status) {
                        $('#meta_title').val(res.data.meta_title);
                        $('#meta_description').val(res.data.meta_description);
                        $('#meta_keywords').val(res.data.meta_keywords.join(', '));
                    } else {
                        alert('Gagal generate SEO: ' + (res.error || 'Unknown error'));
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghubungi AI.');
                },
                complete: function() {
                    $btn.text(defaultText).removeAttr('disabled');
                }
            });
        });
    </script>
@endpush
