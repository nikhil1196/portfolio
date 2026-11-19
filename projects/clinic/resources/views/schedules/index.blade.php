@extends('layouts.app')
@section('title', 'Doctor Schedules')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Doctor Schedule' : 'Add Doctor Schedule' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('schedules.update', $edit) : route('schedules.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Doctor</label>
                    <select name="doctor_id"><option value="">— Select —</option>
                        @foreach($doctors as $id => $n)<option value="{{ $id }}" @selected(old('doctor_id', $edit->doctor_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Clinic</label>
                    <select name="clinic_id"><option value="">— Select —</option>
                        @foreach($clinics as $id => $n)<option value="{{ $id }}" @selected(old('clinic_id', $edit->clinic_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Day</label>
                    <select name="day" required>@foreach(array (
  0 => 'Monday',
  1 => 'Tuesday',
  2 => 'Wednesday',
  3 => 'Thursday',
  4 => 'Friday',
  5 => 'Saturday',
  6 => 'Sunday',
) as $s)<option @selected(old('day', $edit->day ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>From</label><input type="time" name="start_time" value="{{ old('start_time', $edit->start_time ?? '') }}" required></div>
                <div class="form-row"><label>To</label><input type="time" name="end_time" value="{{ old('end_time', $edit->end_time ?? '') }}" required></div>
                <div class="form-row"><label>Slot (min)</label><input type="number" name="slot_min" value="{{ old('slot_min', $edit->slot_min ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Doctor Schedule</button>
            @if($edit)<a class="btn" href="{{ route('schedules.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Doctor Schedules ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Doctor</th><th>Clinic</th><th>Day</th><th>Hours</th><th>Slot</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->doctor->name ?? "—" }}</strong></td>
                    <td>{{ $r->clinic->name ?? "—" }}</td>
                    <td>{{ $r->day }}</td>
                    <td>{{ $r->start_time }} – {{ $r->end_time }}</td>
                    <td>{{ $r->slot_min }} min</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('schedules.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('schedules.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
