@if ($paginator->hasPages())
    <nav role="navigation" class="flex items-center justify-center space-x-1 mt-4 select-none">
        
        {{-- PREVIOUS --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 bg-gray-800 text-gray-500 rounded cursor-not-allowed">«</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-gray-200 rounded transition">«</a>
        @endif

        {{-- NUMBERS --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 bg-gray-800 text-gray-400 rounded">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-blue-600 text-white rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-gray-200 rounded transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- NEXT --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-gray-200 rounded transition">»</a>
        @else
            <span class="px-3 py-1 bg-gray-800 text-gray-500 rounded cursor-not-allowed">»</span>
        @endif

    </nav>
@endif
