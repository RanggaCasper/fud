@props([
    'label' => '',
    'name',
    'id' => $name,
    'options' => [],
    'selected' => null,
    'required' => true
])

<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-semibold">
        {{ $label }}
        @if ($required) 
            <span class="text-red-500">*</span>
        @endif
    </label>
    <div class="relative">
        <select id="{{ $id }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full bg-transparent border focus:border-primary focus:border-2 text-sm text-muted focus:outline-none rounded-lg focus:border-primary p-2.5']) }}>
        
            <option value="">{{ $attributes['placeholder'] ?? 'Select an option' }}</option>
        
            @foreach ($options as $option)
                @php
                    if (is_array($option)) {
                        $value = $option['value'];
                        $label = $option['label'];
                    } else {
                        $value = $option;
                        $label = ucfirst($option);
                    }
                @endphp
                <option class="text-muted" value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
</div>
