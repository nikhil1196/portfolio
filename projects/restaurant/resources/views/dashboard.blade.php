@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Today's Orders</div><div class="stat-value">{{ $stats['Today\'s Orders'] }}</div><div class="stat-sub">Order::whereDate('created_at', today())->count()</div></div>
    <div class="stat-card"><div class="stat-label">Live Orders</div><div class="stat-value">{{ $stats['Live Orders'] }}</div><div class="stat-sub">Order::whereIn('status', ['Pending','Preparing','Ready'])->count()</div></div>
    <div class="stat-card"><div class="stat-label">Today's Revenue</div><div class="stat-value">{{ $stats['Today\'s Revenue'] }}</div><div class="stat-sub">'₹'.number_format(Order::where('payment','Paid')->whereDate('created_at', today())->sum('total'))</div></div>
    <div class="stat-card"><div class="stat-label">Menu Items</div><div class="stat-value">{{ $stats['Menu Items'] }}</div><div class="stat-sub">MenuItem::where('available',1)->count()</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Live Orders</h2><a class="btn btn-sm" href="{{ route('kitchen') }}">Open Kitchen Display</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Order</th><th>Table</th><th>Placed</th><th>Total</th><th>Status</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->order_no }}</code></td>
                    <td>{{ $r->diningTable->name ?? "—" }}</td>
                    <td>{{ $r->created_at->format('h:i A') }}</td>
                    <td>₹{{ number_format($r->total) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No live orders</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
