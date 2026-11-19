@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Contacts</div><div class="stat-value">{{ $stats['Contacts'] }}</div><div class="stat-sub">Contact::count()</div></div>
    <div class="stat-card"><div class="stat-label">Open Leads</div><div class="stat-value">{{ $stats['Open Leads'] }}</div><div class="stat-sub">Lead::whereNotIn('stage', ['Won','Lost'])->count()</div></div>
    <div class="stat-card"><div class="stat-label">Pipeline Value</div><div class="stat-value">{{ $stats['Pipeline Value'] }}</div><div class="stat-sub">'₹'.number_format(Deal::where('status','Open')->sum('value'))</div></div>
    <div class="stat-card"><div class="stat-label">Deals Won</div><div class="stat-value">{{ $stats['Deals Won'] }}</div><div class="stat-sub">'₹'.number_format(Deal::where('stage','Won')->sum('value'))</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Upcoming Tasks</h2><a class="btn btn-sm" href="{{ route('tasks.index') }}">All</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Task</th><th>Contact</th><th>Due</th><th>Priority</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->contact->name ?? "—" }}</td>
                    <td>{{ $r->due_date }}</td>
                    <td><span class="badge">{{ $r->priority }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">All caught up</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
