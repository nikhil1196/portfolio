@extends('layouts.app')
@section('title', 'Table Reservations')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Table Reservation' : 'Add Table Reservation' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('reservations.update', $edit) : route('reservations.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Table</label>
                    <select name="table_id"><option value="">— Select —</option>
                        @foreach($dining_tables as $id => $n)<option value="{{ $id }}" @selected(old('table_id', $edit->table_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Guest Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Guests</label><input type="number" name="guests" value="{{ old('guests', $edit->guests ?? '') }}" required></div>
                <div class="form-row"><label>Date</label><input type="date" name="res_date" value="{{ old('res_date', $edit->res_date ?? '') }}" required></div>
                <div class="form-row"><label>Time</label><input type="time" name="res_time" value="{{ old('res_time', $edit->res_time ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Booked',
  1 => 'Seated',
  2 => 'Cancelled',
  3 => 'No-show',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Table Reservation</button>
            @if($edit)<a class="btn" href="{{ route('reservations.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Table Reservations ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'reservations') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Guest</th><th>Table</th><th>Date</th><th>Time</th><th>Guests</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->table->name ?? "—" }}</td>
                    <td>{{ $r->res_date }}</td>
                    <td>{{ substr($r->res_time,0,5) }}</td>
                    <td>{{ $r->guests }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'reservations', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('reservations.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('reservations.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
