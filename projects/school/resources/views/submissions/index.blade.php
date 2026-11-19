@extends('layouts.app')
@section('title', 'Submissions')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Submission' : 'Add Submission' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('submissions.update', $edit) : route('submissions.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Assignment</label>
                    <select name="assignment_id"><option value="">— Select —</option>
                        @foreach($assignments as $id => $n)<option value="{{ $id }}" @selected(old('assignment_id', $edit->assignment_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Student</label>
                    <select name="student_id"><option value="">— Select —</option>
                        @foreach($students as $id => $n)<option value="{{ $id }}" @selected(old('student_id', $edit->student_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Submitted At</label><input type="datetime-local" name="submitted_at" value="{{ old('submitted_at', $edit->submitted_at ?? '') }}" required></div>
                <div class="form-row"><label>Marks</label><input type="number" name="marks" value="{{ old('marks', $edit->marks ?? '') }}"></div>
                <div class="form-row"><label>Notes</label><textarea name="notes">{{ old('notes', $edit->notes ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Submitted',
  1 => 'Late',
  2 => 'Graded',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Submission</button>
            @if($edit)<a class="btn" href="{{ route('submissions.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Submissions ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Assignment</th><th>Student</th><th>Submitted</th><th>Marks</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->assignment->title }}</strong></td>
                    <td>{{ $r->student->name }}</td>
                    <td>{{ $r->submitted_at }}</td>
                    <td>{{ $r->marks ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('submissions.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('submissions.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
