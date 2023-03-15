<style>
    .title-pagination
    {
        margin-left:10px;
    }
    .pagination-notification
    {
        
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 10px 0px;

    }
    .page-notification a,.previous-page a,.next-page a,.page-notification span,.previous-page span,.next-page span
    {
        border: 1px solid;
        border-radius:10px;
        padding: 4px 20px;
    }
    .page-notification.disabled,.previous-page.disabled,.next-page.disabled
    {
        color:gray
    }
    .page-notification
    {

    }
    .previous-page
    {
        margin-right:10px
    }
    .next-page
    {
        margin-left:10px
    }
    .page-notification.active
    {
        
    }

</style>
@if ($paginator->hasPages())
    <nav>
    <div class="title-pagination">
                <p class="text-sm text-gray-700 leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>
        <ul class="pagination pagination-notification">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled previous-page" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="previous-page">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li  class="active page-notification" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li class="page-notification"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="next-page">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled next-page" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
