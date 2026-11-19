@extends('layouts.app')
@section('title', 'Attendees')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Attendee' : 'Add Attendee' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('attendees.update', $edit) : route('attendees.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Booking</label>
                    <select name="booking_id"><option value="">— Select —</option>
                        @foreach($bookings as $id => $n)<option value="{{ $id }}" @selected(old('booking_id', $edit->booking_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Attendee Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Checked In</label>
                    <select name="checked_in">@foreach(array (
  0 => 'No',
  1 => 'Yes',
) as $s)<option @selected(old('checked_in', $edit->checked_in ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Attendee</button>
            @if($edit)<a class="btn" href="{{ route('attendees.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Attendees ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Name</th><th>Booking</th><th>Event</th><th>Check-in</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td><code>{{ $r->booking->booking_no ?? "—" }}</code></td>
                    <td>{{ $r->booking->event->title ?? "—" }}</td>
                    <td><span class="badge">{{ $r->checked_in ? "Checked In" : "Not Yet" }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('attendees.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('attendees.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
