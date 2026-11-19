@extends('layouts.app')
@section('title', 'Tickets')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Ticket' : 'Add Ticket' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('tickets.update', $edit) : route('tickets.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                                <div class="form-row"><label>Link Customer</label>
                    <select name="customer_id"><option value="">— Select —</option>
                        @foreach($customers ?? [] as $id => $n)<option value="{{ $id }}" @selected(old('customer_id', $edit->customer_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
<div class="form-row"><label>Customer Name</label><input type="text" name="customer" value="{{ old('customer', $edit->customer ?? '') }}" required></div>
                <div class="form-row"><label>Customer Email</label><input type="email" name="email" value="{{ old('email', $edit->email ?? '') }}"></div>
                <div class="form-row"><label>Subject</label><input type="text" name="subject" value="{{ old('subject', $edit->subject ?? '') }}" required></div>
                <div class="form-row"><label>Channel</label>
                    <select name="channel">@foreach(array (
  0 => 'Email',
  1 => 'Chat',
  2 => 'WhatsApp',
  3 => 'Phone',
  4 => 'API',
) as $s)<option @selected(old('channel', $edit->channel ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Priority</label>
                    <select name="priority">@foreach(array (
  0 => 'High',
  1 => 'Medium',
  2 => 'Low',
) as $s)<option @selected(old('priority', $edit->priority ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Assigned To</label>
                    <select name="agent_id"><option value="">— Select —</option>
                        @foreach($agents as $id => $n)<option value="{{ $id }}" @selected(old('agent_id', $edit->agent_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>AI Summary</label><textarea name="ai_summary">{{ old('ai_summary', $edit->ai_summary ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Open',
  1 => 'In Progress',
  2 => 'Resolved',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Ticket</button>
            @if($edit)<a class="btn" href="{{ route('tickets.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Tickets ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
            <select name="status"><option value="">All</option><option @selected(request('status')==='Open')>Open</option><option @selected(request('status')==='In Progress')>In Progress</option><option @selected(request('status')==='Resolved')>Resolved</option><option @selected(request('status')==='Closed')>Closed</option></select>
            <select name="priority"><option value="">All priorities</option><option @selected(request('priority')==='Low')>Low</option><option @selected(request('priority')==='Medium')>Medium</option><option @selected(request('priority')==='High')>High</option><option @selected(request('priority')==='Urgent')>Urgent</option></select>
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'tickets') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Ticket</th><th>Customer</th><th>Subject</th><th>Priority</th><th>Agent</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->ticket_no }}</code></td>
                    <td><strong>{{ $r->customer }}</strong><br><span class="note">{{ $r->channel }}</span></td>
                    <td>{{ $r->subject }}</td>
                    <td><span class="badge">{{ $r->priority }}</span></td>
                    <td>{{ $r->agent->name ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('tickets.suggest', $r) }}" class="inline">
                            @csrf<button class="btn btn-sm" type="submit">✦ AI Suggest</button>
                        </form>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'tickets', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('tickets.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('tickets.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
