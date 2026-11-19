<!DOCTYPE html><html><head><meta charset="utf-8"><title>Invoice {{ $f->receipt_no }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}@media print{.noprint{display:none}}</style></head>
<body>
<h1>School — Fee Invoice</h1>
<div class="row"><span>Receipt No.</span><strong>{{ $f->receipt_no }}</strong></div>
<div class="row"><span>Student</span><strong>{{ $f->student->name ?? '—' }}</strong></div>
<div class="row"><span>Class</span><span>{{ $f->student->schoolClass->name ?? '—' }}</span></div>
<div class="row"><span>Term</span><span>{{ $f->term }}</span></div>
<div class="row"><span>Status</span><span>{{ $f->status }}</span></div>
<div class="row"><span>Paid At</span><span>{{ $f->paid_at ?? '—' }}</span></div>
<div class="row total"><span>Amount</span><span>₹{{ number_format($f->amount) }}</span></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('fees.index') }}">← Back</a></p>
</body></html>