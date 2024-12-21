@if ($paginator->hasPages())
    <nav style="display: flex; justify-content: center; margin-top: 20px;">
        <ul style="display: flex; list-style-type: none; padding: 0; margin: 0;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li style="margin: 0 5px; color: gray;">
                    <span style="padding: 5px 10px; background-color: lightgray; border-radius: 5px; cursor: not-allowed;">&lsaquo;</span>
                </li>
            @else
                <li style="margin: 0 5px;">
                    <a href="{{ $paginator->previousPageUrl() }}" style="text-decoration: none; padding: 5px 10px; background-color: green; color: white; border-radius: 5px;">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li style="margin: 0 5px; color: gray;">
                        <span style="padding: 5px 10px; background-color: lightgray; border-radius: 5px;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li style="margin: 0 5px;">
                                <span style="padding: 5px 10px; background-color: darkgreen; color: white; border-radius: 5px;">{{ $page }}</span>
                            </li>
                        @else
                            <li style="margin: 0 5px;">
                                <a href="{{ $url }}" style="text-decoration: none; padding: 5px 10px; background-color: green; color: white; border-radius: 5px;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li style="margin: 0 5px;">
                    <a href="{{ $paginator->nextPageUrl() }}" style="text-decoration: none; padding: 5px 10px; background-color: green; color: white; border-radius: 5px;">&rsaquo;</a>
                </li>
            @else
                <li style="margin: 0 5px; color: gray;">
                    <span style="padding: 5px 10px; background-color: lightgray; border-radius: 5px; cursor: not-allowed;">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
