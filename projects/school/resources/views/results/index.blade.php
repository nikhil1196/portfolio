@extends('layouts.app')
@section('title', 'Results')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Result' : 'Add Result' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('results.update', $edit) : route('results.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Student</label>
                    <select name="student_id"><option value="">— Select —</option>
                        @foreach($students as $id => $n)<option value="{{ $id }}" @selected(old('student_id', $edit->student_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Exam</label><input type="text" name="exam" value="{{ old('exam', $edit->exam ?? '') }}"></div>
                <div class="form-row"><label>Subject</label><input type="text" name="subject" value="{{ old('subject', $edit->subject ?? '') }}" required></div>
                <div class="form-row"><label>Marks</label><input type="number" name="marks" value="{{ old('marks', $edit->marks ?? '') }}" required></div>
                <div class="form-row"><label>Max Marks</label><input type="number" name="max_marks" value="{{ old('max_marks', $edit->max_marks ?? '') }}"></div>
                <div class="form-row"><label>Grade</label><input type="text" name="grade" value="{{ old('grade', $edit->grade ?? '') }}"></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Result</button>
            @if($edit)<a class="btn" href="{{ route('results.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Results ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'results') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Student</th><th>Exam</th><th>Subject</th><th>Marks</th><th>Grade</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->student->name }}</strong><br><span class="note">{{ $r->student->roll_no }}</span></td>
                    <td>{{ $r->exam }}</td>
                    <td>{{ $r->subject }}</td>
                    <td>{{ $r->marks }} / {{ $r->max_marks }}</td>
                    <td><span class="badge">{{ $r->grade }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'results', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('results.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('results.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
