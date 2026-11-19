<!DOCTYPE html><html><head><meta charset="utf-8"><title>Receipt {{ $r->receipt_no }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}@media print{.noprint{display:none}}</style></head>
<body>
<h1>Society — Maintenance Receipt</h1>
<div class="row"><span>Receipt No.</span><strong>{{ $r->receipt_no }}</strong></div>
<div class="row"><span>Unit</span><strong>{{ $r->unit->flat_no ?? '—' }}</strong></div>
<div class="row"><span>Maintenance Bill</span><span>#{{ $r->maintenance_id }}</span></div>
<div class="row"><span>Method</span><span>{{ $r->method }}</span></div>
<div class="row"><span>Txn Ref</span><span>{{ $r->txn_ref ?? '—' }}</span></div>
<div class="row"><span>Status</span><span>{{ $r->status }}</span></div>
<div class="row total"><span>Amount</span><span>₹{{ number_format($r->amount) }}</span></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('receipts.index') }}">← Back</a></p>
</body></html>