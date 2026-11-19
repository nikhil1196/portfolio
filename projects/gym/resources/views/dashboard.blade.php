@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Total Members</div><div class="stat-value">{{ $totalMembers }}</div><div class="stat-sub">all registrations</div></div>
    <div class="stat-card"><div class="stat-label">Active Members</div><div class="stat-value">{{ $activeMembers }}</div><div class="stat-sub">currently subscribed</div></div>
    <div class="stat-card"><div class="stat-label">Revenue (Month)</div><div class="stat-value">₹{{ number_format($monthRevenue) }}</div><div class="stat-sub">collected payments</div></div>
    <div class="stat-card"><div class="stat-label">Today's Check-ins</div><div class="stat-value">{{ $todayCheckins }}</div><div class="stat-sub">attendance marked</div></div>
</div>
<div class="two-col">
    <div class="card">
        <div class="card-head"><h2>Recent Members</h2><a class="btn btn-sm" href="{{ route('members.index') }}">View all</a></div>
        <div class="card-body" style="padding:0">
            <table class="tbl">
                <tr><th>Name</th><th>Plan</th><th>Status</th></tr>
                @foreach($recentMembers as $m)
                    <tr><td>{{ $m->name }}</td><td>{{ $m->plan->name ?? '—' }}</td><td><span class="badge">{{ $m->status }}</span></td></tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-head"><h2>Currently In Gym</h2><a class="btn btn-sm" href="{{ route('attendance.index') }}">Attendance</a></div>
        <div class="card-body" style="padding:0">
            <table class="tbl">
                <tr><th>Member</th><th>Checked In</th></tr>
                @forelse($inGym as $a)
                    <tr><td>{{ $a->member->name }}</td><td>{{ $a->check_in->format('d M, h:i A') }}</td></tr>
                @empty
                    <tr><td colspan="2" class="empty">No one checked in right now</td></tr>
                @endforelse
            </table>
        </div>
    </div>
</div>
@endsection
