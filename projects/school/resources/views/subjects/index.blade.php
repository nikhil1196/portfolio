@extends('layouts.app')
@section('title', 'Subjects')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Subject' : 'Add Subject' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('subjects.update', $edit) : route('subjects.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Subject Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Code</label><input type="text" name="code" value="{{ old('code', $edit->code ?? '') }}"></div>
                <div class="form-row"><label>Class</label>
                    <select name="class_id"><option value="">— Select —</option>
                        @foreach($school_classs as $id => $n)<option value="{{ $id }}" @selected(old('class_id', $edit->class_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Teacher</label>
                    <select name="teacher_id"><option value="">— Select —</option>
                        @foreach($teachers as $id => $n)<option value="{{ $id }}" @selected(old('teacher_id', $edit->teacher_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Subject</button>
            @if($edit)<a class="btn" href="{{ route('subjects.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Subjects ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Name</th><th>Code</th><th>Class</th><th>Teacher</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->code }}</td>
                    <td>{{ $r->schoolClass->name ?? "—" }}</td>
                    <td>{{ $r->teacher->name ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('subjects.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('subjects.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
