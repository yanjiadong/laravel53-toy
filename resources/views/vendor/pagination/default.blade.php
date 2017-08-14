@if ($paginator->hasPages())
<div class="toolbar bottom-toolbar clearfix">
    <div class="right">
        <div class="pagination pagination-mini">
            <ul>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="disabled"><a href="javascript:;">首页</a></li>
                @else
                    <li><a href="{{ $paginator->previousPageUrl() }}">上一页</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><span>{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a></li>
                @else
                    <li class="disabled"><a href="javascript:;">最后一页</a></li>
                @endif

            </ul>
        </div>
    </div>
</div>
@endif