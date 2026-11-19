@extends('layouts.app')
@section('title', 'Measurements')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Measurement' : 'Add Measurement' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('measurements.update', $edit) : route('measurements.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Member</label>
                    <select name="member_id"><option value="">— Select —</option>
                        @foreach($members as $id => $n)<option value="{{ $id }}" @selected(old('member_id', $edit->member_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="measured_on" value="{{ old('measured_on', $edit->measured_on ?? '') }}" required></div>
                <div class="form-row"><label>Weight (kg)</label><input type="number" name="weight_kg" value="{{ old('weight_kg', $edit->weight_kg ?? '') }}"></div>
                <div class="form-row"><label>Height (cm)</label><input type="number" name="height_cm" value="{{ old('height_cm', $edit->height_cm ?? '') }}"></div>
                <div class="form-row"><label>Chest (cm)</label><input type="number" name="chest_cm" value="{{ old('chest_cm', $edit->chest_cm ?? '') }}"></div>
                <div class="form-row"><label>Waist (cm)</label><input type="number" name="waist_cm" value="{{ old('waist_cm', $edit->waist_cm ?? '') }}"></div>
                <div class="form-row"><label>Arms (cm)</label><input type="number" name="arms_cm" value="{{ old('arms_cm', $edit->arms_cm ?? '') }}"></div>
                <div class="form-row"><label>Body Fat %</label><input type="number" name="body_fat" value="{{ old('body_fat', $edit->body_fat ?? '') }}"></div>
                <div class="form-row"><label>Notes</label><textarea name="notes">{{ old('notes', $edit->notes ?? '') }}</textarea></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Measurement</button>
            @if($edit)<a class="btn" href="{{ route('measurements.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Measurements ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Member</th><th>Date</th><th>Weight</th><th>BMI</th><th>Chest / Waist</th><th>Body Fat</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->member->name ?? "—" }}</strong></td>
                    <td>{{ $r->measured_on ? \Carbon\Carbon::parse($r->measured_on)->format("d M Y") : "—" }}</td>
                    <td>{{ $r->weight_kg }} kg</td>
                    <td>{{ $r->height_cm ? round($r->weight_kg / pow($r->height_cm / 100, 2), 1) : "—" }}</td>
                    <td>{{ $r->chest_cm }} / {{ $r->waist_cm }} cm</td>
                    <td>{{ $r->body_fat }}%</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('measurements.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('measurements.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
