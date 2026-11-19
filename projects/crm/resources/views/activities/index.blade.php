@extends('layouts.app')
@section('title', 'Activitys')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Activity' : 'Add Activity' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('activities.update', $edit) : route('activities.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Lead</label>
                    <select name="lead_id"><option value="">— Select —</option>
                        @foreach($leads as $id => $n)<option value="{{ $id }}" @selected(old('lead_id', $edit->lead_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Type</label>
                    <select name="type" required>@foreach(array (
  0 => 'Call',
  1 => 'Meeting',
  2 => 'Email',
  3 => 'Note',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Summary</label><input type="text" name="summary" value="{{ old('summary', $edit->summary ?? '') }}" required></div>
                <div class="form-row"><label>Due At</label><input type="datetime-local" name="due_at" value="{{ old('due_at', $edit->due_at ?? '') }}" required></div>
                <div class="form-row"><label>Done?</label>
                    <select name="done">@foreach(array (
  0 => 'No',
  1 => 'Yes',
) as $s)<option @selected(old('done', $edit->done ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Activity</button>
            @if($edit)<a class="btn" href="{{ route('activities.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Activitys ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'activities') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Lead</th><th>Type</th><th>Summary</th><th>Due</th><th>Done</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->lead->title }}</strong></td>
                    <td><span class="badge">{{ $r->type }}</span></td>
                    <td>{{ $r->summary }}</td>
                    <td>{{ $r->due_at }}</td>
                    <td>{{ $r->done ? "✓" : "—" }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'activities', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('activities.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('activities.done', $r) }}" style="display:inline">@csrf<button class="btn btn-sm">{{ $r->done ? '↺' : '✓' }}</button></form>
                        <form method="POST" action="{{ route('activities.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
