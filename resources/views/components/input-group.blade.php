@props([
    'label' => '',
    'name',
    'id' => null,
    'value' => null,
    'placeholder' => '',
    'type' => 'text',
    'buttonText' => 'Go',
    'buttonType' => 'button',
    'buttonClass' => 'flex items-center rounded-e-lg text-sm bg-primary text-white hover:bg-primary focus:bg-primary focus:outline-none',
    'buttonId' => null,
    'disabled' => false,
    'required' => true
])

<div>
    @if ($label)
        <label for="{{ $id ?? $name }}" class="block mb-1 text-sm font-semibold text-muted">
            {{ $label }}
            @if ($required && !$disabled)
                <span class="!text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <div class="flex">
            <input
                type="{{ $type }}"
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                placeholder="{{ $placeholder }}"
                class="w-full text-sm text-muted bg-transparent border border-gray-700/50 focus:border-primary placeholder:text-gray-400 focus:border-2 rounded-s-lg p-2.5 {{ $disabled ? '!text-gray-500 cursor-not-allowed' : '' }}"
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes }}
            >
    
            <button type="{{ $buttonType }}" id="{{ $buttonId }}" class="px-4 {{ $buttonClass }}">
                {{ $buttonText }}
            </button>
        </div>
    </div>
</div>