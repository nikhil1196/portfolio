<!DOCTYPE html><html><head><meta charset="utf-8"><title>Receipt {{ $p->invoice_no }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}@media print{.noprint{display:none}}</style></head>
<body>
<h1>Gym Management SaaS — Payment Receipt</h1>
<div class="row"><span>Invoice No.</span><strong>{{ $p->invoice_no }}</strong></div>
<div class="row"><span>Member</span><strong>{{ $p->member->name ?? '—' }}</strong></div>
<div class="row"><span>Plan</span><span>{{ $p->plan->name ?? '—' }}</span></div>
<div class="row"><span>Method</span><span>{{ $p->method }}</span></div>
<div class="row"><span>Status</span><span>{{ $p->status }}</span></div>
<div class="row"><span>Paid At</span><span>{{ $p->paid_at ?? '—' }}</span></div>
<div class="row total"><span>Amount</span><span>₹{{ number_format($p->amount) }}</span></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('payments.index') }}">← Back</a></p>
</body></html>