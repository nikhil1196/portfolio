@extends('layouts.app')
@section('title', 'Study Materials')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Study Material' : 'Add Study Material' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('materials.update', $edit) : route('materials.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Subject</label>
                    <select name="subject_id"><option value="">— Select —</option>
                        @foreach($subjects as $id => $n)<option value="{{ $id }}" @selected(old('subject_id', $edit->subject_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Class</label>
                    <select name="class_id"><option value="">— Select —</option>
                        @foreach($school_classs as $id => $n)<option value="{{ $id }}" @selected(old('class_id', $edit->class_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Type</label>
                    <select name="type" required>@foreach(array (
  0 => 'Notes',
  1 => 'PDF',
  2 => 'Link',
  3 => 'Video',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Link / File URL</label><input type="text" name="url" value="{{ old('url', $edit->url ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Study Material</button>
            @if($edit)<a class="btn" href="{{ route('materials.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Study Materials ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'materials') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Title</th><th>Subject</th><th>Class</th><th>Type</th><th>Link</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->subject->name }}</td>
                    <td>{{ $r->schoolClass->name }}</td>
                    <td><span class="badge">{{ $r->type }}</span></td>
                    <td>{{ $r->url ? "View" : "—" }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'materials', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('materials.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('materials.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
