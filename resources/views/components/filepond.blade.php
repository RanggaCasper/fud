@props([
    'class' => 'filepond-image', // filepond-image, filepond-audio
    'label' => 'Image',
    'id' => 'filepond',
    'required' => true,
    'name',
    'maxFileSizeImage' => 2,
    'maxFileSizeAudio' => 20
])

<div>
    <label class="block mb-1 text-sm font-semibold text-muted" @if($id) for="{{ $id }}" @endif>
        {{ $label }}
        @if ($required) <span class="!text-danger">*</span> @endif
    </label>

    <input 
        type="file" 
        class="{{ $class }} filepond" 
        name="{{ $name }}" 
        {{ $attributes }}
        @if ($required) @endif
        @if($id) id="{{ $id }}" @endif
    />
</div>

@once
    @push('styles')
        <!-- FilePond CSS -->
        <link href="https://cdn.jsdelivr.net/npm/filepond@4.30.4/dist/filepond.min.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <!-- FilePond JS -->
        <script src="https://cdn.jsdelivr.net/npm/filepond@4.30.4/dist/filepond.min.js"></script>

        <!-- Plugins -->
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-size@2.2.7/dist/filepond-plugin-file-validate-size.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/filepond-plugin-image-exif-orientation@1.0.11/dist/filepond-plugin-image-exif-orientation.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/filepond-plugin-file-encode@2.1.9/dist/filepond-plugin-file-encode.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

        <script>
            // Set FilePond options
            FilePond.setOptions({
                server: {
                    url: "{{ config('filepond.server.url') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                    }
                },
            });

            // Register FilePond plugins
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType,
                FilePondPluginImageExifOrientation,
                FilePondPluginImagePreview
            );

            $("input.filepond-image").each(function() {
                FilePond.create(this, {
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    allowMultiple: true,
                    allowImagePreview: true,
                    allowFileSizeValidation: true,
                    maxFileSize: {{ 1000000 * $maxFileSizeImage }},
                    labelMaxFileSizeExceed: 'Maximum file size is {filesize}',
                    maxFiles: 3,
                    onaddfilestart: () => {
                        $('button[type="submit"]').prop('disabled', true);
                    },
                    onprocessfile: () => {
                        $('button[type="submit"]').prop('disabled', false);
                    },
                    onerror: () => {
                        $('button[type="submit"]').prop('disabled', false);
                    }
                });
            });

            $("input.filepond-audio").each(function() {
                FilePond.create(this, {
                    acceptedFileTypes: ['audio/mpeg', 'audio/ogg', 'audio/wav'],
                    allowFileSizeValidation: true,
                    maxFileSize: {{ 1000000 * $maxFileSizeAudio }},
                    labelMaxFileSizeExceed: 'Maximum file size is {filesize}',
                    allowMultiple: false,
                    maxFiles: 1,
                });
            });

            // Initialize FilePond for circular image upload (opsional)
            FilePond.create($(".filepond-input-circle")[0], {
                labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
                imagePreviewHeight: 170,
                imageCropAspectRatio: "1:1",
                imageResizeTargetWidth: 200,
                imageResizeTargetHeight: 200,
                stylePanelLayout: "compact circle",
                styleLoadIndicatorPosition: "center bottom",
                styleProgressIndicatorPosition: "right bottom",
                styleButtonRemoveItemPosition: "left bottom",
                styleButtonProcessItemPosition: "right bottom"
            });
        </script>
    @endpush
@endonce