@extends('layouts.app')
@section('title', 'Attendance Report')
@section('content')
<div class="card">
    <div class="card-head"><h2>Attendance Report — {{ $month }}</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar"><form method="GET">
            <input type="month" name="month" value="{{ $month }}">
            <button class="btn" type="submit">Load</button>
        </form></div>
        <table class="tbl"><tr><th>Student</th><th>Roll</th><th>Days</th><th>Present</th><th>Absent</th><th>Late</th><th>%</th></tr>
        @forelse($rows as $r)
        <tr><td>{{ $r['student'] }}</td><td>{{ $r['roll'] }}</td><td>{{ $r['total'] }}</td>
            <td><span class="badge b-present">{{ $r['present'] }}</span></td>
            <td><span class="badge b-absent">{{ $r['absent'] }}</span></td>
            <td><span class="badge b-late">{{ $r['late'] }}</span></td>
            <td><strong>{{ $r['pct'] }}%</strong></td></tr>
        @empty<tr><td colspan="7" class="empty">No attendance recorded this month.</td></tr>@endforelse
        </table>
    </div>
</div>
@endsection