@extends('layouts.app')
@section('title', 'Amenity Bookings')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Amenity Booking' : 'Add Amenity Booking' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('bookings.update', $edit) : route('bookings.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Amenity</label>
                    <select name="amenity" required>@foreach(array (
  0 => 'Clubhouse',
  1 => 'Community Hall',
  2 => 'Swimming Pool',
  3 => 'Tennis Court',
  4 => 'Party Lawn',
) as $s)<option @selected(old('amenity', $edit->amenity ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Unit</label>
                    <select name="unit_id"><option value="">— Select —</option>
                        @foreach($units as $id => $n)<option value="{{ $id }}" @selected(old('unit_id', $edit->unit_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="booking_date" value="{{ old('booking_date', $edit->booking_date ?? '') }}" required></div>
                <div class="form-row"><label>Time Slot</label>
                    <select name="slot">@foreach(array (
  0 => 'Morning (6-12)',
  1 => 'Afternoon (12-5)',
  2 => 'Evening (5-10)',
  3 => 'Full Day',
) as $s)<option @selected(old('slot', $edit->slot ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Confirmed',
  1 => 'Cancelled',
  2 => 'Completed',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Amenity Booking</button>
            @if($edit)<a class="btn" href="{{ route('bookings.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Amenity Bookings ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'bookings') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Amenity</th><th>Flat</th><th>Date</th><th>Slot</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->amenity }}</strong></td>
                    <td>{{ $r->unit->flat_no ?? "—" }}</td>
                    <td>{{ $r->booking_date ? \Carbon\Carbon::parse($r->booking_date)->format("d M Y") : "—" }}</td>
                    <td>{{ $r->slot }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'bookings', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('bookings.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('bookings.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
