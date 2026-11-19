@extends('layouts.app')
@section('title', 'Timetable Entrys')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Timetable Entry' : 'Add Timetable Entry' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('timetable.update', $edit) : route('timetable.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Class</label>
                    <select name="class_id"><option value="">— Select —</option>
                        @foreach($school_classs as $id => $n)<option value="{{ $id }}" @selected(old('class_id', $edit->class_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Day</label>
                    <select name="day" required>@foreach(array (
  0 => 'Monday',
  1 => 'Tuesday',
  2 => 'Wednesday',
  3 => 'Thursday',
  4 => 'Friday',
  5 => 'Saturday',
) as $s)<option @selected(old('day', $edit->day ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Period #</label><input type="number" name="period" value="{{ old('period', $edit->period ?? '') }}" required></div>
                <div class="form-row"><label>Subject</label>
                    <select name="subject_id"><option value="">— Select —</option>
                        @foreach($subjects as $id => $n)<option value="{{ $id }}" @selected(old('subject_id', $edit->subject_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Teacher</label>
                    <select name="teacher_id"><option value="">— Select —</option>
                        @foreach($teachers as $id => $n)<option value="{{ $id }}" @selected(old('teacher_id', $edit->teacher_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Start</label><input type="time" name="start_time" value="{{ old('start_time', $edit->start_time ?? '') }}" required></div>
                <div class="form-row"><label>End</label><input type="time" name="end_time" value="{{ old('end_time', $edit->end_time ?? '') }}" required></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Timetable Entry</button>
            @if($edit)<a class="btn" href="{{ route('timetable.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Timetable Entrys ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Class</th><th>Day</th><th>Period</th><th>Subject</th><th>Teacher</th><th>Time</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->schoolClass->name }}</strong></td>
                    <td>{{ $r->day }}</td>
                    <td>P{{ $r->period }}</td>
                    <td>{{ $r->subject->name }}</td>
                    <td>{{ $r->teacher->name }}</td>
                    <td>{{ substr($r->start_time,0,5) }}–{{ substr($r->end_time,0,5) }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('timetable.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('timetable.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
