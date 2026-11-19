@extends('layouts.app')
@section('title', 'Audit Log')
@section('content')
<div class="card"><h2>Audit Log</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'audit') }}" style="margin-left:auto">⬇ CSV</a>
        </form>

<table><thead><tr><th>When</th><th>User</th><th>Action</th><th>Model</th><th>Summary</th></tr></thead>
<tbody>@forelse($rows as $r)
<tr><td>{{ $r->created_at->diffForHumans() }}</td><td>{{ $r->user->name ?? 'system' }}</td>
<td><span class="badge">{{ $r->action }}</span></td><td>{{ $r->model_type }} #{{ $r->model_id }}</td><td>{{ $r->summary }}</td></tr>
@empty<tr><td colspan="5">No activity yet.</td></tr>@endforelse</tbody></table>
{{ $rows->links() }}</div>
@endsection