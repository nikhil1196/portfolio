@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Students</div><div class="stat-value">{{ $stats['Students'] }}</div><div class="stat-sub">Student::where('status','Active')->count()</div></div>
    <div class="stat-card"><div class="stat-label">Teachers</div><div class="stat-value">{{ $stats['Teachers'] }}</div><div class="stat-sub">Teacher::count()</div></div>
    <div class="stat-card"><div class="stat-label">Classes</div><div class="stat-value">{{ $stats['Classes'] }}</div><div class="stat-sub">SchoolClass::count()</div></div>
    <div class="stat-card"><div class="stat-label">Fees Collected</div><div class="stat-value">{{ $stats['Fees Collected'] }}</div><div class="stat-sub">'₹'.number_format(Fee::where('status','Paid')->sum('amount'))</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Recent Admissions</h2><a class="btn btn-sm" href="{{ route('students.index') }}">All students</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Roll No</th><th>Student</th><th>Class</th><th>Guardian</th><th>Status</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->roll_no }}</code></td>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->schoolClass->name ?? "—" }}</td>
                    <td>{{ $r->guardian }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No students yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
