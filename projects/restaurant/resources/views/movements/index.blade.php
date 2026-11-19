@extends('layouts.app')
@section('title', 'Stock Movements')
@section('content')
<div class="card"><div class="card-head"><h2>Stock Movements</h2>
<a class="btn" href="{{ route('export.csv', 'stock-movements') }}">⬇ CSV</a></div>
<div class="card-body" style="padding:0">
<table class="tbl"><tr><th>When</th><th>Item</th><th>Direction</th><th>Qty</th><th>Reason</th><th>By</th></tr>
@forelse($rows as $r)
<tr><td>{{ $r->created_at->diffForHumans() }}</td><td>{{ $r->item->name ?? '—' }}</td>
<td><span class="badge {{ $r->direction === 'in' ? 'b-paid' : 'b-overdue' }}">{{ strtoupper($r->direction) }}</span></td>
<td>{{ $r->qty }} {{ $r->item->unit ?? '' }}</td><td>{{ $r->reason ?? '—' }}</td><td>{{ $r->user->name ?? 'system' }}</td></tr>
@empty<tr><td colspan="6" class="empty">No movements yet.</td></tr>@endforelse</table>
{{ $rows->links() }}</div></div>
@endsection