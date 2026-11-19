@extends('layouts.app')
@section('title', 'Measurements')
@section('content')
<div class="card" style="margin-bottom:16px"><h3>Weight Progress</h3>
@php $pts = \App\Models\Measurement::orderBy('measured_on')->limit(20)->get(); $max = max(1, $pts->max('weight_kg')); $min = max(0, $pts->min('weight_kg') - 5); @endphp
@if($pts->count() > 1)
<svg class="progress-chart" viewBox="0 0 600 140" style="width:100%;height:140px">
<polyline fill="none" stroke="#4f8ef7" stroke-width="2" points="
@foreach($pts as $i => $p){{ $i * (560/max(1,$pts->count()-1)) + 20 }},{{ 120 - (($p->weight_kg - $min) / max(1,$max - $min)) * 100 }} @endforeach"/>
@foreach($pts as $i => $p)<circle cx="{{ $i * (560/max(1,$pts->count()-1)) + 20 }}" cy="{{ 120 - (($p->weight_kg - $min) / max(1,$max - $min)) * 100 }}" r="3" fill="#4f8ef7"><title>{{ $p->measured_on }}: {{ $p->weight_kg }}kg</title></circle>@endforeach
</svg>
@else<p>Not enough data yet.</p>@endif</div>
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Measurement' : 'Add Measurement' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'measurements') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
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
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'measurements', 'id' => $r->id]) }}">View</a>
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
        {{ $rows->links() }}
    </div>
</div>
@endsection
