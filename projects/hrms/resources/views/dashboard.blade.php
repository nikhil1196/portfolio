@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Employees</div><div class="stat-value">{{ $stats['Employees'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Departments</div><div class="stat-value">{{ $stats['Departments'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Present Today</div><div class="stat-value">{{ $stats['Present Today'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Pending Leaves</div><div class="stat-value">{{ $stats['Pending Leaves'] }}</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Today's Attendance</h2><a class="btn btn-sm" href="{{ route('attendance.index') }}">Mark</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Code</th><th>Employee</th><th>Check-in</th><th>Status</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->employee->emp_code ?? "—" }}</code></td>
                    <td><strong>{{ $r->employee->name ?? "—" }}</strong></td>
                    <td>{{ $r->check_in ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">Not marked yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
