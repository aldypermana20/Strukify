@props(['items' => []])

<nav class="flex items-center gap-2 text-sm mb-2">
    @foreach($items as $index => $item)
        @if($index > 0)
            <svg class="w-3.5 h-3.5 text-gray-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        @endif

        @if(isset($item['url']) && $index < count($items) - 1)
            <a href="{{ $item['url'] }}" class="text-gray-400 hover:text-primary-400 transition-colors truncate">{{ $item['label'] }}</a>
        @else
            <span class="text-gray-300 font-medium truncate">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
