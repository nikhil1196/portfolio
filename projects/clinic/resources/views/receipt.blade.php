<!DOCTYPE html><html><head><meta charset="utf-8"><title>Receipt {{ $p->receipt_no }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}@media print{.noprint{display:none}}</style></head>
<body>
<h1>Clinic — Payment Receipt</h1>
<div class="row"><span>Receipt No.</span><strong>{{ $p->receipt_no }}</strong></div>
<div class="row"><span>Patient</span><strong>{{ $p->appointment->patient->name ?? '—' }}</strong></div>
<div class="row"><span>Doctor</span><span>{{ $p->appointment->doctor->name ?? '—' }}</span></div>
<div class="row"><span>Appointment</span><span>{{ $p->appointment->appt_date ?? '—' }} {{ $p->appointment->appt_time ?? '' }}</span></div>
<div class="row"><span>Method</span><span>{{ $p->method }}</span></div>
<div class="row"><span>Txn Ref</span><span>{{ $p->txn_ref ?? '—' }}</span></div>
<div class="row"><span>Status</span><span>{{ $p->status }}</span></div>
<div class="row total"><span>Amount</span><span>₹{{ number_format($p->amount) }}</span></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('payments.index') }}">← Back</a></p>
</body></html>