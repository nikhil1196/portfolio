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
        <table class="tbl"><tr><th>Employee</th><th>Code</th><th>Days</th><th>Present</th><th>Absent</th><th>Late</th></tr>
        @forelse($rows as $r)
        <tr><td>{{ $r['emp'] }}</td><td>{{ $r['code'] }}</td><td>{{ $r['total'] }}</td>
            <td><span class="badge b-present">{{ $r['present'] }}</span></td>
            <td><span class="badge b-absent">{{ $r['absent'] }}</span></td>
            <td><span class="badge b-late">{{ $r['late'] }}</span></td></tr>
        @empty<tr><td colspan="6" class="empty">No attendance this month.</td></tr>@endforelse
        </table>
    </div>
</div>
@endsection