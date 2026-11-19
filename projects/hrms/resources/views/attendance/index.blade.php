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
                <div class="form-row"><label>Employee</label>
                    <select name="emp_id"><option value="">— Select —</option>
                        @foreach($employees as $id => $n)<option value="{{ $id }}" @selected(old('emp_id', $edit->emp_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="work_date" value="{{ old('work_date', $edit->work_date ?? '') }}" required></div>
                <div class="form-row"><label>Check-in Time</label><input type="time" name="check_in" value="{{ old('check_in', $edit->check_in ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Present',
  1 => 'Absent',
  2 => 'Leave',
  3 => 'Half Day',
  4 => 'WFH',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
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
            <tr><th>Date</th><th>Employee</th><th>Check-in</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->work_date }}</td>
                    <td><strong>{{ $r->employee->name ?? "—" }}</strong><br><span class="note">{{ $r->employee->emp_code ?? "" }}</span></td>
                    <td>{{ $r->check_in ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('attendance.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('attendance.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
