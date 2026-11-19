@extends('layouts.app')
@section('title', 'Session / Speakers')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Session / Speaker' : 'Add Session / Speaker' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('sessions.update', $edit) : route('sessions.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Event</label>
                    <select name="event_id"><option value="">— Select —</option>
                        @foreach($events as $id => $n)<option value="{{ $id }}" @selected(old('event_id', $edit->event_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Session Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Speaker</label><input type="text" name="speaker" value="{{ old('speaker', $edit->speaker ?? '') }}"></div>
                <div class="form-row"><label>Starts</label><input type="datetime-local" name="starts_at" value="{{ old('starts_at', $edit->starts_at ?? '') }}" required></div>
                <div class="form-row"><label>Ends</label><input type="datetime-local" name="ends_at" value="{{ old('ends_at', $edit->ends_at ?? '') }}"></div>
                <div class="form-row"><label>Room / Track</label><input type="text" name="room" value="{{ old('room', $edit->room ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Scheduled',
  1 => 'Live',
  2 => 'Done',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Session / Speaker</button>
            @if($edit)<a class="btn" href="{{ route('sessions.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Session / Speakers ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'sessions') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Session</th><th>Event</th><th>Speaker</th><th>Starts</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->event->title }}</td>
                    <td>{{ $r->speaker }}</td>
                    <td>{{ $r->starts_at }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'sessions', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('sessions.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('sessions.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
