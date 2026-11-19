@extends('layouts.app')
@section('title', 'Audit Log')
@section('content')
<div class="card">
    <div class="card-head"><h2>Audit Log</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search summary / model…">
                <input type="date" name="from" value="{{ request('from') }}">
                <input type="date" name="to" value="{{ request('to') }}">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'audit') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>When</th><th>User</th><th>Action</th><th>Model</th><th>Summary</th></tr>
            @forelse($rows as $r)
            <tr><td>{{ $r->created_at->diffForHumans() }}</td><td>{{ $r->user->name ?? 'system' }}</td>
            <td><span class="badge">{{ $r->action }}</span></td><td>{{ $r->model_type }} #{{ $r->model_id }}</td><td>{{ $r->summary }}</td></tr>
            @empty<tr><td colspan="5" class="empty">No activity yet.</td></tr>@endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
