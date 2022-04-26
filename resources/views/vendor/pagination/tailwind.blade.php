<div class="shop_toolbar t_bottom">
    <div class="pagination">
        <ul>
            @if ($paginator->hasPages())
                {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                    {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="current"><span>{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                            @endforeach
                        @endif
                    @endforeach
            @endif
        </ul>

    </div>
</div>
