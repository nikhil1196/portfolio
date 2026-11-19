@extends('layouts.app')
@section('title', 'Attendances')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Attendance' : 'Add Attendance' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('attendance.update', $edit) : route('attendance.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Student</label>
                    <select name="student_id"><option value="">— Select —</option>
                        @foreach($students as $id => $n)<option value="{{ $id }}" @selected(old('student_id', $edit->student_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="att_date" value="{{ old('att_date', $edit->att_date ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Present',
  1 => 'Absent',
  2 => 'Late',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Remark</label><input type="text" name="remark" value="{{ old('remark', $edit->remark ?? '') }}"></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Attendance</button>
            @if($edit)<a class="btn" href="{{ route('attendance.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Attendances ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Student</th><th>Class</th><th>Date</th><th>Status</th><th>Remark</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->student->name ?? "—" }}</strong><br><span class="note">{{ $r->student->roll_no ?? "" }}</span></td>
                    <td>{{ $r->student->schoolClass->name ?? "—" }}</td>
                    <td>{{ $r->att_date ? \Carbon\Carbon::parse($r->att_date)->format("d M Y") : "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>{{ $r->remark }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('attendance.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('attendance.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
