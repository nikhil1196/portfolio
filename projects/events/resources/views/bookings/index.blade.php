@extends('layouts.app')
@section('title', 'Bookings')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Booking' : 'Add Booking' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('bookings.update', $edit) : route('bookings.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Event</label>
                    <select name="event_id"><option value="">— Select —</option>
                        @foreach($events as $id => $n)<option value="{{ $id }}" @selected(old('event_id', $edit->event_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Booked By</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Email</label><input type="email" name="email" value="{{ old('email', $edit->email ?? '') }}"></div>
                <div class="form-row"><label>Seats</label><input type="number" name="seats" value="{{ old('seats', $edit->seats ?? '') }}" required></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Confirmed',
  1 => 'Cancelled',
  2 => 'Refunded',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
                <div class="form-row"><label>Ticket Tier</label>
                    <select name="ticket_id"><option value="">— Any / general —</option>
                        @foreach($tickets ?? [] as $id => $n)<option value="{{ $id }}" @selected(old('ticket_id', $edit->ticket_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Payment</label>
                    <select name="payment"><option @selected(old('payment', $edit->payment ?? 'Unpaid') == 'Unpaid')>Unpaid</option><option @selected(old('payment', $edit->payment ?? '') == 'Paid')>Paid</option><option @selected(old('payment', $edit->payment ?? '') == 'Refunded')>Refunded</option></select></div>
                <div class="form-row"><label>Txn Ref</label><input type="text" name="txn_ref" value="{{ old('txn_ref', $edit->txn_ref ?? '') }}"></div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Booking</button>
            @if($edit)<a class="btn" href="{{ route('bookings.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Bookings ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
            <select name="status"><option value="">All</option><option @selected(request('status')==='Confirmed')>Confirmed</option><option @selected(request('status')==='Cancelled')>Cancelled</option></select>
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'bookings') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Booking</th><th>Event</th><th>By</th><th>Seats</th><th>Amount</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->booking_no }}</code></td>
                    <td>{{ $r->event->title ?? "—" }}</td>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->seats }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'bookings', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('bookings.index', ['edit' => $r->id]) }}">Edit</a>
                        <a class="btn btn-sm" href="{{ route('bookings.ticket', $r) }}" target="_blank">🎫 Ticket</a>
                        @if($r->payment !== 'Paid')<form method="POST" action="{{ route('bookings.paid', $r) }}" style="display:inline">@csrf<button class="btn btn-sm">Mark Paid</button></form>@endif
                        <form method="POST" action="{{ route('bookings.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
