@if ($paginator->hasPages())
    <div class="navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                {{-- <li class="pagination-item disabled">
                    <span class="px-3 py-2 bg-gray-200 text-gray-500 rounded cursor-not-allowed">&laquo;</span>
                </li> --}}
                <li class="disabled page-item">
                    <span class="page-link">
                        <i class="fa-solid fa-angle-left"></i>
                    </span>
                </li>
            @else
                {{-- <li class="pagination-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 bg-white border border-gray-300 rounded hover:bg-gray-100">&laquo;</a>
                </li> --}}
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="previous page-link" title="Trước">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    {{-- <li class="pagination-item disabled">
                        <span class="px-3 py-2">{{ $element }}</span>
                    </li> --}}
                    <li class="page-item">
                        <span class="page-link">...</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- <li class="pagination-item active">
                                <span class="px-3 py-2 bg-blue-500 text-white rounded">{{ $page }}</span>
                            </li> --}}
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            {{-- <li class="pagination-item">
                                <a href="{{ $url }}" class="px-3 py-2 bg-white border border-gray-300 rounded hover:bg-gray-100">{{ $page }}</a>
                            </li> --}}
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link" title="Trang {{ $page }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                {{-- <li class="pagination-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 bg-white border border-gray-300 rounded hover:bg-gray-100">&raquo;</a>
                </li> --}}
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="next page-link" title="Sau">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
            @else
                {{-- <li class="pagination-item disabled">
                    <span class="px-3 py-2 bg-gray-200 text-gray-500 rounded cursor-not-allowed">&raquo;</span>
                </li> --}}
                <li class="disabled page-item">
                    <span class="page-link">
                        <i class="fa-solid fa-angle-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </div>
@endif
