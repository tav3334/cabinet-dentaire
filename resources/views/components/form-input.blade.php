@props(['label', 'name', 'type' => 'text', 'required' => false, 'placeholder' => '', 'value' => ''])

<div class="mb-6">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-200 transition-all duration-200 outline-none']) }}
    >

    @error($name)
        <p class="mt-2 text-sm text-red-600 flex items-center">
            <i class="bi bi-exclamation-circle mr-1"></i>
            {{ $message }}
        </p>
    @enderror
</div>
