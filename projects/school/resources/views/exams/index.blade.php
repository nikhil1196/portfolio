@extends('layouts.app')
@section('title', 'Exams')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Exam' : 'Add Exam' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('exams.update', $edit) : route('exams.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Exam Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Class</label>
                    <select name="class_id"><option value="">— Select —</option>
                        @foreach($school_classs as $id => $n)<option value="{{ $id }}" @selected(old('class_id', $edit->class_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Subject</label>
                    <select name="subject_id"><option value="">— Select —</option>
                        @foreach($subjects as $id => $n)<option value="{{ $id }}" @selected(old('subject_id', $edit->subject_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="exam_date" value="{{ old('exam_date', $edit->exam_date ?? '') }}" required></div>
                <div class="form-row"><label>Max Marks</label><input type="number" name="max_marks" value="{{ old('max_marks', $edit->max_marks ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Scheduled',
  1 => 'Ongoing',
  2 => 'Completed',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Exam</button>
            @if($edit)<a class="btn" href="{{ route('exams.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Exams ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'exams') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Exam</th><th>Class</th><th>Subject</th><th>Date</th><th>Max</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->schoolClass->name }}</td>
                    <td>{{ $r->subject->name }}</td>
                    <td>{{ $r->exam_date }}</td>
                    <td>{{ $r->max_marks }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'exams', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('exams.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('exams.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
