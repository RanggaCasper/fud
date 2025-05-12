@props(['label', 'name', 'id' => null, 'value' => null, 'placeholder' => '', 'type' => 'text', 'attr' => '', 'disabled' => false, 'required' => true])

<div>
    <label for="{{ $id }}" class="block mb-1 text-sm font-semibold text-black">
        {{ $label }}
        @if ($required && !$disabled) 
            <span class="text-red-500">*</span>
        @endif
    </label>
    <div class="relative">
        <input 
            type="{{ $type }}" 
            id="{{ $id }}" 
            name="{{ $name }}" 
            placeholder="{{ $placeholder }}" 
            value="{{ $value }}"
            class="w-full text-sm text-dark rounded-lg border focus:border-primary focus:border-2 p-2.5 
                {{ $type === 'password' ? 'password-field' : '' }} 
                {{ $disabled ? 'bg-gray-100 text-gray-500 cursor-not-allowed border-gray-400' : '' }}" 
            {{ $attr }} 
            @if($disabled) disabled @endif
        >
        @if ($type === 'password' && !$disabled)
            <button type="button" class="absolute inset-y-0 flex items-center text-black right-2 hover:text-black focus:outline-none toggle-password">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 eye-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>
        @endif
    </div>
</div>
