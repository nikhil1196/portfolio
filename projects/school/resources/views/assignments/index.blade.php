@extends('layouts.app')
@section('title', 'Assignments')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Assignment' : 'Add Assignment' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('assignments.update', $edit) : route('assignments.store') }}">
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
                <div class="form-row"><label>Teacher</label>
                    <select name="teacher_id"><option value="">— Select —</option>
                        @foreach($teachers as $id => $n)<option value="{{ $id }}" @selected(old('teacher_id', $edit->teacher_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Due Date</label><input type="date" name="due_date" value="{{ old('due_date', $edit->due_date ?? '') }}" required></div>
                <div class="form-row"><label>Description</label><textarea name="description">{{ old('description', $edit->description ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Open',
  1 => 'Closed',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Assignment</button>
            @if($edit)<a class="btn" href="{{ route('assignments.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Assignments ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Title</th><th>Subject</th><th>Class</th><th>Due</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->subject->name }}</td>
                    <td>{{ $r->schoolClass->name }}</td>
                    <td>{{ $r->due_date }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('assignments.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('assignments.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
