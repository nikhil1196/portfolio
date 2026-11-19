@extends('layouts.app')
@section('title', 'Pipeline')
@section('content')
<div class="stats-row" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
    <div class="stat-card"><div class="stat-label">Open Pipeline</div><div class="stat-value">₹{{ number_format($totalOpen) }}</div><div class="stat-sub">across active stages</div></div>
    @foreach($stages as $s)
        <div class="stat-card"><div class="stat-label">{{ $s }}</div><div class="stat-value">{{ $deals->get($s, collect())->count() }}</div><div class="stat-sub">₹{{ number_format($deals->get($s, collect())->sum('value')) }}</div></div>
    @endforeach
</div>
<div class="board">
    @foreach($stages as $s)
        <div class="board-col">
            <h3>{{ $s }} <span class="cnt">{{ $deals->get($s, collect())->count() }}</span></h3>
            @forelse($deals->get($s, collect()) as $d)
                <div class="board-card">
                    <div class="bc-title">{{ $d->title }}</div>
                    <div class="bc-val">₹{{ number_format($d->value) }}</div>
                    <div class="bc-sub">{{ $d->contact->name ?? '—' }}@if($d->close_date) · closes {{ \Carbon\Carbon::parse($d->close_date)->format('d M') }}@endif</div>
                    <form method="POST" action="{{ route('deals.stage', $d) }}">
                        @csrf @method('PATCH')
                        <select name="stage" data-autosubmit onchange="this.form.submit()">
                            @foreach($stages as $opt)<option value="{{ $opt }}" @selected($d->stage === $opt)>Move to {{ $opt }}</option>@endforeach
                        </select>
                    </form>
                </div>
            @empty
                <div class="note" style="text-align:center;padding:8px 0">No deals</div>
            @endforelse
        </div>
    @endforeach
</div>
@endsection
