@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<div class="stats-row">
    @foreach($reports as $r)
        <div class="stat-card"><div class="stat-label">{{ $r['title'] }}</div>
            <div class="stat-value">{{ $r['total'] }}</div>
            <div class="stat-sub">+{{ $r['month'] }} this month</div></div>
    @endforeach
</div>
<div class="card">
    <div class="card-head"><h2>Status Breakdown</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'reports') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Module</th><th>Total</th><th>New This Month</th><th>By Status</th></tr>
            @foreach($reports as $r)
                <tr>
                    <td><a href="{{ url('/' . $r['uri']) }}"><strong>{{ $r['title'] }}</strong></a></td>
                    <td>{{ $r['total'] }}</td>
                    <td>{{ $r['month'] }}</td>
                    <td>@foreach($r['byStatus'] as $st => $c)<span class="badge">{{ $st }}: {{ $c }}</span> @endforeach</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
