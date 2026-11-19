@extends('layouts.app')
@section('title', 'Expense Report')
@section('content')
<div class="card">
    <div class="card-head"><h2>Expense Report — {{ $year }}</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar"><form method="GET">
            <input type="number" name="year" value="{{ $year }}" min="2000" max="2100">
            <button class="btn" type="submit">Load</button>
        </form></div>
        <table class="tbl"><tr><th>Category</th><th>Entries</th><th>Total</th></tr>
        @forelse($byCat as $c)
        <tr><td>{{ $c->category }}</td><td>{{ $c->n }}</td><td><strong>₹{{ number_format($c->total) }}</strong></td></tr>
        @empty<tr><td colspan="3" class="empty">No expenses this year.</td></tr>@endforelse
        </table>
        @if($byMonth->isNotEmpty())
        <div style="padding:16px">@foreach($byMonth as $m => $t)
            <div style="display:flex;gap:10px;align-items:center;margin:4px 0">
                <span style="width:36px;font-size:12px;color:#888">{{ DateTime::createFromFormat('!m', $m)->format('M') }}</span>
                <div style="background:#4f46e5;height:14px;border-radius:3px;width:{{ max(4, $t / max(1,$byMonth->max()) * 60) }}%"></div>
                <span style="font-size:12px">₹{{ number_format($t) }}</span>
            </div>
        @endforeach</div>
        @endif
    </div>
</div>
@endsection