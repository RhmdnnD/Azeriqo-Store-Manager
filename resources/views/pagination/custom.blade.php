@if ($paginator->hasPages())
    <div class="pagination-container">
        <nav role="navigation" aria-label="Pagination">
            <ul class="pagination-list">
                {{-- Tombol Previous --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="pagination-item disabled">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-item">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                    </li>
                @endif

                {{-- Element Pagination --}}
                @foreach ($elements as $element)
                    {{-- Separator "..." --}}
                    @if (is_string($element))
                        <li><span class="pagination-dots">{{ $element }}</span></li>
                    @endif

                    {{-- Link Halaman --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><span class="pagination-item active">{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}" class="pagination-item">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Tombol Next --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-item">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="pagination-item disabled">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif