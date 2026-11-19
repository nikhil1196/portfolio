@extends('layouts.app')
@section('title', 'Prescriptions')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Prescription' : 'Add Prescription' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('prescriptions.update', $edit) : route('prescriptions.store') }}">
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
                <div class="form-row"><label>Diagnosis / Notes</label><textarea name="notes">{{ old('notes', $edit->notes ?? '') }}</textarea></div>
                <div class="form-row"><label>Medicines</label><textarea name="medicines">{{ old('medicines', $edit->medicines ?? '') }}</textarea></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Prescription</button>
            @if($edit)<a class="btn" href="{{ route('prescriptions.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Prescriptions ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'prescriptions') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Date</th><th>Patient</th><th>Doctor</th><th>Medicines</th><th>Notes</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->created_at->format('d M Y') }}</td>
                    <td><strong>{{ $r->patient->name }}</strong></td>
                    <td>{{ $r->doctor->name }}</td>
                    <td>{{ Str::limit($r->medicines, 60) }}</td>
                    <td>{{ Str::limit($r->notes, 50) }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'prescriptions', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('prescriptions.index', ['edit' => $r->id]) }}">Edit</a>
                        <a class="btn btn-sm" href="{{ route('prescriptions.print', $r) }}" target="_blank">Print</a>
                        <form method="POST" action="{{ route('prescriptions.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
