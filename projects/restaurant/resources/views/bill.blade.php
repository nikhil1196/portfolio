<!DOCTYPE html><html><head><meta charset="utf-8"><title>Bill {{ $o->order_no }}</title>
<style>body{font-family:system-ui;max-width:560px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}@media print{.noprint{display:none}}</style></head>
<body>
<h1>Restaurant — Bill</h1>
<div class="row"><span>Order</span><strong>{{ $o->order_no }}</strong></div>
<div class="row"><span>Table</span><span>{{ $o->diningTable->name ?? 'Takeaway' }}</span></div>
<div class="row"><span>Status</span><span>{{ $o->status }} · {{ $o->payment }}</span></div>
<div style="margin:14px 0">
@foreach($o->items as $i)
<div class="row"><span>{{ $i->item_name }} × {{ $i->qty }}</span><span>₹{{ number_format($i->price * $i->qty) }}</span></div>
@endforeach
</div>
<div class="row total"><span>Total</span><span>₹{{ number_format($o->total) }}</span></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('orders.index') }}">← Back</a></p>
</body></html>