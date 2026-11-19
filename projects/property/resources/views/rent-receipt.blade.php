<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rent Receipt #{{ $r->id }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}@media print{.noprint{display:none}}</style></head>
<body>
<h1>Rent Receipt</h1>
<div class="row"><span>Receipt #</span><strong>RR-{{ str_pad($r->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
<div class="row"><span>Tenant</span><strong>{{ $r->lease->tenant->name ?? '—' }}</strong></div>
<div class="row"><span>Property</span><span>{{ $r->lease->property->title ?? '—' }}</span></div>
<div class="row"><span>Period</span><span>{{ $r->month }}</span></div>
<div class="row"><span>Status</span><span>{{ $r->status }}{{ $r->paid_at ? ' · ' . $r->paid_at : '' }}</span></div>
<div class="row total"><span>Amount</span><span>₹{{ number_format($r->amount) }}</span></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('rents.index') }}">← Back</a></p>
</body></html>