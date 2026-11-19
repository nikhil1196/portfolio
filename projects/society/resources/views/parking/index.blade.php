@extends('layouts.app')
@section('title', 'Parking Slots')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Parking Slot' : 'Add Parking Slot' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('parking.update', $edit) : route('parking.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Slot No.</label><input type="text" name="slot_no" value="{{ old('slot_no', $edit->slot_no ?? '') }}" required></div>
                <div class="form-row"><label>Unit</label>
                    <select name="unit_id"><option value="">— Select —</option>
                        @foreach($units as $id => $n)<option value="{{ $id }}" @selected(old('unit_id', $edit->unit_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Vehicle No.</label><input type="text" name="vehicle_no" value="{{ old('vehicle_no', $edit->vehicle_no ?? '') }}"></div>
                <div class="form-row"><label>Type</label>
                    <select name="vehicle_type" required>@foreach(array (
  0 => 'Car',
  1 => 'Bike',
  2 => 'Scooter',
  3 => 'Other',
) as $s)<option @selected(old('vehicle_type', $edit->vehicle_type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Assigned',
  1 => 'Free',
  2 => 'Blocked',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Parking Slot</button>
            @if($edit)<a class="btn" href="{{ route('parking.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Parking Slots ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'parking') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Slot</th><th>Unit</th><th>Vehicle</th><th>Type</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->slot_no }}</strong></td>
                    <td>{{ $r->unit->flat_no ?? "—" }}</td>
                    <td>{{ $r->vehicle_no }}</td>
                    <td>{{ $r->vehicle_type }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'parking', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('parking.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('parking.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
