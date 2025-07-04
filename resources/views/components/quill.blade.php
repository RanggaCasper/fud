@props([
    'id' => 'editor-' . uniqid(),
    'name' => 'content',
    'label' => 'Content',
])

<label for="{{ $id }}" class="block mb-2 text-sm font-semibold text-muted">{{ $label }}</label>
<div id="{{ $id }}" class="quill {{ $id }}" data-input="{{ $name }}"></div>
<input type="hidden" name="{{ $name }}" />

@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            $(document).ready(function () {
                $('.quill').each(function () {
                    const $el = $(this);
                    const inputName = $el.data('input');
                    const $input = $(`input[name="${inputName}"]`);
                    const quill = new Quill(this, { theme: 'snow' });

                    quill.on('text-change', function () {
                        if ($input.length) {
                            $input.val(quill.root.innerHTML);
                        }
                    });

                    const initialValue = $input.val();
                    if (initialValue) {
                        quill.root.innerHTML = initialValue;
                    }
                });
            });
        </script>
    @endpush
@endonce
