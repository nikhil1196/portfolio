@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Open Tickets</div><div class="stat-value">{{ $stats['Open Tickets'] }}</div></div>
    <div class="stat-card"><div class="stat-label">In Progress</div><div class="stat-value">{{ $stats['In Progress'] }}</div></div>
    <div class="stat-card"><div class="stat-label">AI Replies</div><div class="stat-value">{{ $stats['AI Replies'] }}</div></div>
    <div class="stat-card"><div class="stat-label">KB Articles</div><div class="stat-value">{{ $stats['KB Articles'] }}</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Ticket Queue</h2><a class="btn btn-sm" href="{{ route('tickets.index') }}">All tickets</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Ticket</th><th>Customer</th><th>Subject</th><th>Priority</th><th>Agent</th><th>Status</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->ticket_no }}</code></td>
                    <td><strong>{{ $r->customer }}</strong></td>
                    <td>{{ $r->subject }}</td>
                    <td><span class="badge">{{ $r->priority }}</span></td>
                    <td>{{ $r->agent->name ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">Queue is clear</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
