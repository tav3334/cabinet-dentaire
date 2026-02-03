@props(['title', 'value', 'icon', 'gradient' => 'primary', 'trend' => null])

@php
    $gradients = [
        'primary' => 'from-purple-500 to-purple-700',
        'success' => 'from-green-500 to-green-700',
        'warning' => 'from-amber-500 to-amber-700',
        'danger' => 'from-red-500 to-red-700',
        'info' => 'from-cyan-500 to-cyan-700',
    ];
    $selectedGradient = $gradients[$gradient] ?? $gradients['primary'];
@endphp

<div class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-gradient-to-br {{ $selectedGradient }} opacity-10 rounded-full"></div>

    <div class="p-6 relative z-10">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">{{ $title }}</p>
                <div class="flex items-baseline mt-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
                    @if($trend)
                        <span class="ml-2 text-sm font-medium {{ $trend > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trend > 0 ? '+' : '' }}{{ $trend }}%
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-16 h-16 rounded-xl bg-gradient-to-br {{ $selectedGradient }} shadow-lg">
                    <i class="{{ $icon }} text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="h-1 bg-gradient-to-r {{ $selectedGradient }}"></div>
</div>
