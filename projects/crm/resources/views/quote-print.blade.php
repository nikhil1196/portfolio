<!DOCTYPE html><html><head><meta charset="utf-8"><title>Quote {{ $q->quote_no }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}.terms{margin-top:18px;font-size:13px;color:#555;white-space:pre-line}
@media print{.noprint{display:none}}</style></head>
<body>
<h1>Quotation</h1>
<div class="row"><span>Quote No.</span><strong>{{ $q->quote_no }}</strong></div>
<div class="row"><span>Customer</span><span>{{ $q->deal->contact->name ?? '—' }}{{ $q->deal->contact->company ? ' · ' . $q->deal->contact->company : '' }}</span></div>
<div class="row"><span>Deal</span><span>{{ $q->deal->title ?? '—' }}</span></div>
<div class="row"><span>Title</span><span>{{ $q->title }}</span></div>
<div class="row"><span>Valid Until</span><span>{{ $q->valid_until }}</span></div>
<div class="row"><span>Status</span><span>{{ $q->status }}</span></div>
<div class="row total"><span>Amount</span><span>₹{{ number_format($q->amount) }}</span></div>
@if($q->terms)<div class="terms"><strong>Terms:</strong>
{{ $q->terms }}</div>@endif
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('quotes.index') }}">← Back</a></p>
</body></html>