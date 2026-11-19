@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Units</div><div class="stat-value">{{ $stats['Units'] }}</div><div class="stat-sub">Unit::count()</div></div>
    <div class="stat-card"><div class="stat-label">Residents</div><div class="stat-value">{{ $stats['Residents'] }}</div><div class="stat-sub">Resident::count()</div></div>
    <div class="stat-card"><div class="stat-label">Maintenance Due</div><div class="stat-value">{{ $stats['Maintenance Due'] }}</div><div class="stat-sub">'₹'.number_format(Maintenance::where('status','Due')->sum('amount'))</div></div>
    <div class="stat-card"><div class="stat-label">Open Complaints</div><div class="stat-value">{{ $stats['Open Complaints'] }}</div><div class="stat-sub">Complaint::where('status','Open')->count()</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Active Complaints</h2><a class="btn btn-sm" href="{{ route('complaints.index') }}">All</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Flat</th><th>Resident</th><th>Subject</th><th>Category</th><th>Status</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->resident->unit->flat_no ?? "—" }}</td>
                    <td><strong>{{ $r->resident->name ?? "—" }}</strong></td>
                    <td>{{ $r->subject }}</td>
                    <td>{{ $r->category }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No open complaints</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
