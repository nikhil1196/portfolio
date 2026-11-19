@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="card">
  <div class="card-head"><h2>{{ $title }}</h2><a class="btn" href="{{ url('/' . $module) }}">← Back</a></div>
  <div class="card-body" style="padding:0">
  <table class="tbl">@foreach($r->getAttributes() as $k => $v)
    <tr><th style="width:200px;text-align:left">{{ str_replace('_',' ',$k) }}</th><td>{{ $v }}</td></tr>@endforeach
  </table></div>
</div>
@if($r instanceof \App\Models\Event)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Ticket Tiers</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Tier</th><th>Price</th><th>Capacity</th><th>Sold</th><th>Left</th></tr>
  @forelse(\App\Models\Ticket::where('event_id',$r->id)->get() as $t)
    <tr><td>{{ $t->name }}</td><td>₹{{ number_format($t->price) }}</td><td>{{ $t->qty }}</td><td>{{ $t->sold }}</td><td>{{ max(0, $t->qty - $t->sold) }}</td></tr>
  @empty<tr><td colspan="5" class="empty">No tiers.</td></tr>@endforelse</table></div></div>
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Bookings</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Booking</th><th>Name</th><th>Seats</th><th>Payment</th><th></th></tr>
  @forelse(\App\Models\Booking::where('event_id',$r->id)->latest()->limit(10)->get() as $bk)
    <tr><td>{{ $bk->booking_no }}</td><td>{{ $bk->name }}</td><td>{{ $bk->seats }}</td><td><span class="badge">{{ $bk->payment }}</span></td>
    <td><a class="btn btn-sm" href="{{ route('bookings.ticket', $bk) }}" target="_blank">🎫</a></td></tr>
  @empty<tr><td colspan="5" class="empty">None yet.</td></tr>@endforelse</table></div></div>
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Sessions</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Session</th><th>Speaker</th></tr>
  @forelse(\App\Models\Session::where('event_id',$r->id)->get() as $s)
    <tr><td>{{ $s->title }}</td><td>{{ $s->speaker }}</td></tr>
  @empty<tr><td colspan="2" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Venue)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Events at this venue</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Event</th><th>Date</th><th>Status</th></tr>
  @forelse(\App\Models\Event::where('venue',$r->name)->latest()->limit(10)->get() as $ev)
    <tr><td>{{ $ev->title }}</td><td>{{ $ev->event_date }}</td><td><span class="badge">{{ $ev->status }}</span></td></tr>
  @empty<tr><td colspan="3" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Booking)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Attendees</h3>
  <a class="btn btn-sm" href="{{ route('bookings.ticket', $r) }}" target="_blank">🎫 E-Ticket</a></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Name</th><th>Code</th><th>Checked in</th></tr>
  @forelse(\App\Models\Attendee::where('booking_id',$r->id)->get() as $a)
    <tr><td>{{ $a->name }}</td><td><code>{{ $a->checkin_code }}</code></td><td>{{ $a->checked_in ? '✓' : '—' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection