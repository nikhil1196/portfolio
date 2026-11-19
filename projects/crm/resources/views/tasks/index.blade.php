@extends('layouts.app')
@section('title', 'Tasks')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Task' : 'Add Task' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('tasks.update', $edit) : route('tasks.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Contact</label>
                    <select name="contact_id"><option value="">— Select —</option>
                        @foreach($contacts as $id => $n)<option value="{{ $id }}" @selected(old('contact_id', $edit->contact_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Task</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Due Date</label><input type="date" name="due_date" value="{{ old('due_date', $edit->due_date ?? '') }}" required></div>
                <div class="form-row"><label>Priority</label>
                    <select name="priority">@foreach(array (
  0 => 'High',
  1 => 'Medium',
  2 => 'Low',
) as $s)<option @selected(old('priority', $edit->priority ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Open',
  1 => 'Done',
  2 => 'Cancelled',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Task</button>
            @if($edit)<a class="btn" href="{{ route('tasks.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Tasks ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'tasks') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Task</th><th>Contact</th><th>Due</th><th>Priority</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->contact->name ?? "—" }}</td>
                    <td>{{ $r->due_date }}</td>
                    <td><span class="badge">{{ $r->priority }}</span></td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'tasks', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('tasks.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
