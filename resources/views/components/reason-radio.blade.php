@props([
    'id' => 'radio-' . uniqid(),
    'name' => 'radio_group',
    'value' => '',
    'label' => '',
    'helperText' => ''
])
<li>
    <div class="flex p-2 rounded-sm hover:bg-gray-100">
        <div class="flex items-center h-5">
            <input
                id="{{ $id }}"
                name="{{ $name ?? 'radio-group' }}"
                type="radio"
                value="{{ $value ?? '' }}"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
            >
        </div>
        <div class="ms-2 text-sm">
            <label for="{{ $id }}" class="font-medium text-gray-900">
                <div>{{ $label }}</div>
                <p id="helper-radio-text-{{ $id }}" class="text-xs font-normal text-gray-500">
                    {{ $helperText }}
                </p>
            </label>
        </div>
    </div>
</li>