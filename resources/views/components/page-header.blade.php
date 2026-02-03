@props(['title', 'description' => null, 'icon' => null])

<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            @if($icon)
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                    <i class="{{ $icon }} text-white text-2xl"></i>
                </div>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $title }}</h1>
                @if($description)
                    <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
                @endif
            </div>
        </div>
        <div>
            {{ $actions ?? '' }}
        </div>
    </div>
</div>
