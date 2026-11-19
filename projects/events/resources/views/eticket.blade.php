<!DOCTYPE html><html><head><meta charset="utf-8"><title>E-Ticket {{ $b->booking_no }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.tix{margin-top:14px;border:1px dashed #bbb;border-radius:8px;padding:12px;display:flex;justify-content:space-between;align-items:center}
.tix img{width:100px;height:100px}.code{font-family:monospace;font-size:16px;letter-spacing:2px}
@media print{.noprint{display:none}}</style></head>
<body>
<h1>🎫 E-Ticket</h1>
<div class="row"><span>Booking</span><strong>{{ $b->booking_no }}</strong></div>
<div class="row"><span>Event</span><strong>{{ $b->event->title ?? '—' }}</strong></div>
<div class="row"><span>Date</span><span>{{ $b->event->event_date ?? '—' }}</span></div>
<div class="row"><span>Venue</span><span>{{ $b->event->venue ?? '—' }}</span></div>
<div class="row"><span>Name</span><span>{{ $b->name }}</span></div>
<div class="row"><span>Seats</span><span>{{ $b->seats }}{{ $b->ticket ? ' · ' . $b->ticket->name : '' }}</span></div>
<div class="row"><span>Payment</span><span>{{ $b->payment }} · ₹{{ number_format($b->amount) }}</span></div>
@foreach($b->attendees as $a)
<div class="tix"><div><strong>{{ $a->name }}</strong><br>
<span class="code">{{ $a->checkin_code }}</span><br>
<small>{{ $a->checked_in ? '✓ Checked in' : 'Not checked in' }}</small></div>
<img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($a->checkin_code) }}" alt="QR"></div>
@endforeach
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('bookings.index') }}">← Back</a></p>
</body></html>