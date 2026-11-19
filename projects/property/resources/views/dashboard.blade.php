@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Properties</div><div class="stat-value">{{ $stats['Properties'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Occupied</div><div class="stat-value">{{ $stats['Occupied'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Active Leases</div><div class="stat-value">{{ $stats['Active Leases'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Rent Due</div><div class="stat-value">{{ $stats['Rent Due'] }}</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Pending Rent</h2><a class="btn btn-sm" href="{{ route('rents.index') }}">All</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Property</th><th>Tenant</th><th>Month</th><th>Amount</th><th>Status</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->lease->property->title ?? "—" }}</td>
                    <td><strong>{{ $r->lease->tenant->name ?? "—" }}</strong></td>
                    <td>{{ $r->month }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">All rent collected</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
