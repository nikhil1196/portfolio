@if ($paginator->hasPages())
<div class="pgn">
    <div class="pgn-info">Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}</div>
    <div class="pgn-links">
        @if ($paginator->onFirstPage())
            <span class="pgn-dis">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">‹</a>
        @endif
        @php
            $cur = $paginator->currentPage(); $last = $paginator->lastPage();
            $from = max(1, $cur - 2); $to = min($last, $cur + 2);
        @endphp
        @if ($from > 1)<a href="{{ $paginator->url(1) }}">1</a>@if($from > 2)<span class="pgn-dis">…</span>@endif @endif
        @for ($i = $from; $i <= $to; $i++)
            @if ($i == $cur)<span class="pgn-cur">{{ $i }}</span>
            @else<a href="{{ $paginator->url($i) }}">{{ $i }}</a>@endif
        @endfor
        @if ($to < $last)@if($to < $last - 1)<span class="pgn-dis">…</span>@endif<a href="{{ $paginator->url($last) }}">{{ $last }}</a>@endif
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">›</a>
        @else
            <span class="pgn-dis">›</span>
        @endif
    </div>
</div>
@endif
