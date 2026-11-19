@extends('layouts.app')
@section('title', 'Class Bookings')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Class Booking' : 'Add Class Booking' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'class-bookings') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('class-bookings.update', $edit) : route('class-bookings.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Class</label>
                    <select name="gym_class_id"><option value="">— Select —</option>
                        @foreach($gym_classs as $id => $n)<option value="{{ $id }}" @selected(old('gym_class_id', $edit->gym_class_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Member</label>
                    <select name="member_id"><option value="">— Select —</option>
                        @foreach($members as $id => $n)<option value="{{ $id }}" @selected(old('member_id', $edit->member_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="booking_date" value="{{ old('booking_date', $edit->booking_date ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Booked',
  1 => 'Attended',
  2 => 'Cancelled',
  3 => 'No Show',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Class Booking</button>
            @if($edit)<a class="btn" href="{{ route('class-bookings.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Class Bookings ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Class</th><th>Member</th><th>Date</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->gymClass->name ?? "—" }}</strong><br><span class="note">{{ $r->gymClass->day ?? "" }} {{ $r->gymClass->start_time ?? "" }}</span></td>
                    <td>{{ $r->member->name ?? "—" }}</td>
                    <td>{{ $r->booking_date ? \Carbon\Carbon::parse($r->booking_date)->format("d M Y") : "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'class-bookings', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('class-bookings.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('class-bookings.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
