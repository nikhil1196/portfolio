@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Patients</div><div class="stat-value">{{ $stats['Patients'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Doctors</div><div class="stat-value">{{ $stats['Doctors'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Today's Appointments</div><div class="stat-value">{{ $stats['Today\'s Appointments'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Revenue (Month)</div><div class="stat-value">{{ $stats['Revenue (Month)'] }}</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Today's Appointments</h2><a class="btn btn-sm" href="{{ route('appointments.index') }}">All</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Time</th><th>Patient</th><th>Doctor</th><th>Reason</th><th>Status</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->appt_time }}</td>
                    <td><strong>{{ $r->patient->name }}</strong></td>
                    <td>{{ $r->doctor->name }}</td>
                    <td>{{ $r->reason }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">Nothing scheduled today</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
