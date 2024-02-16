

    <div class="pagination paging" aria-label="{{ __('Pagination Navigation') }}">
        <ul class="w-100" style="list-style: none;">
            {{-- First Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="#">
                    <li>
                        <i class="mdi mdi-page-first text-secondary"></i>
                    </li>
                </a>
            @else
                <a href="{{ \Request::url().'?page=1' }}">
                    <li>
                        <i class="mdi mdi-page-first"></i>
                    </li>
                </a>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a href="#">
                    <li>
                        <i class="mdi mdi-chevron-left text-secondary"></i>
                    </li>
                </a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}">
                    <li>
                        <i class="mdi mdi-chevron-left"></i>
                    </li>
                </a>
            @endif
            

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    {{ $element }}
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="item active" href="#">
                                <li>
                                    {{ $page }}
                                </li>
                            </a>
                        @else
                            <a class="item" href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                <li>
                                    {{ $page }}
                                </li>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">
                    <li>
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                </a>
            @else
                <a href="#">
                    <li>
                        <i class="mdi mdi-chevron-right text-secondary"></i>
                    </li>
                </a>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ \Request::url().'?page='.$paginator->lastPage() }}">
                    <li>
                        <i class="mdi mdi-page-last"></i>
                    </li>
                </a>
            @else
                <a href="#">
                    <li>
                        <i class="mdi mdi-page-last text-secondary"></i>
                    </li>
                </a>
            @endif
        </ul>
    </div>