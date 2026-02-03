@props(['variant' => 'default', 'dot' => false])

@php
    $variants = [
        'default' => 'bg-gray-100 text-gray-800',
        'primary' => 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800',
        'success' => 'bg-gradient-to-r from-green-100 to-green-200 text-green-800',
        'warning' => 'bg-gradient-to-r from-amber-100 to-amber-200 text-amber-800',
        'danger' => 'bg-gradient-to-r from-red-100 to-red-200 text-red-800',
        'info' => 'bg-gradient-to-r from-cyan-100 to-cyan-200 text-cyan-800',
        'pending' => 'bg-gradient-to-r from-amber-100 to-amber-200 text-amber-800',
        'confirmed' => 'bg-gradient-to-r from-green-100 to-green-200 text-green-800',
        'canceled' => 'bg-gradient-to-r from-red-100 to-red-200 text-red-800',
    ];

    $dotColors = [
        'default' => 'bg-gray-400',
        'primary' => 'bg-purple-600',
        'success' => 'bg-green-600',
        'warning' => 'bg-amber-600',
        'danger' => 'bg-red-600',
        'info' => 'bg-cyan-600',
        'pending' => 'bg-amber-600',
        'confirmed' => 'bg-green-600',
        'canceled' => 'bg-red-600',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];
    $dotColor = $dotColors[$variant] ?? $dotColors['default'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold $variantClass"]) }}>
    @if($dot)
        <span class="w-2 h-2 mr-2 rounded-full {{ $dotColor }} animate-pulse"></span>
    @endif
    {{ $slot }}
</span>
