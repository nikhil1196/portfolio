@extends('layouts.app')
@section('title', 'Appointments')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Appointment' : 'Add Appointment' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('appointments.update', $edit) : route('appointments.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Patient</label>
                    <select name="patient_id"><option value="">— Select —</option>
                        @foreach($patients as $id => $n)<option value="{{ $id }}" @selected(old('patient_id', $edit->patient_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Doctor</label>
                    <select name="doctor_id"><option value="">— Select —</option>
                        @foreach($doctors as $id => $n)<option value="{{ $id }}" @selected(old('doctor_id', $edit->doctor_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Clinic</label>
                    <select name="clinic_id"><option value="">— Select —</option>
                        @foreach($clinics as $id => $n)<option value="{{ $id }}" @selected(old('clinic_id', $edit->clinic_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="appt_date" value="{{ old('appt_date', $edit->appt_date ?? '') }}" required></div>
                <div class="form-row"><label>Time</label><input type="time" name="appt_time" value="{{ old('appt_time', $edit->appt_time ?? '') }}"></div>
                <div class="form-row"><label>Reason / Symptoms</label><input type="text" name="reason" value="{{ old('reason', $edit->reason ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Scheduled',
  1 => 'Completed',
  2 => 'Cancelled',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Appointment</button>
            @if($edit)<a class="btn" href="{{ route('appointments.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Appointments ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th><th>Clinic</th><th>Reason</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->appt_date }}</td>
                    <td>{{ $r->appt_time }}</td>
                    <td><strong>{{ $r->patient->name }}</strong></td>
                    <td>{{ $r->doctor->name }}</td>
                    <td>{{ $r->clinic->name ?? "—" }}</td>
                    <td>{{ $r->reason }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('appointments.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('appointments.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
