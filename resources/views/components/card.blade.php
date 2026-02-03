@props(['title' => null, 'padding' => true, 'hover' => false])

@php
    $hoverClass = $hover ? 'hover:shadow-xl hover:-translate-y-1' : '';
    $paddingClass = $padding ? 'p-6' : '';
@endphp

<div {{ $attributes->merge(['class' => "bg-white rounded-2xl shadow-lg transition-all duration-300 $hoverClass"]) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        </div>
    @endif

    <div class="{{ $paddingClass }}">
        {{ $slot }}
    </div>
</div>
