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
@if($r instanceof \App\Models\Order)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Order Items</h3>
  <a class="btn btn-sm" href="{{ route('orders.bill', $r) }}" target="_blank">Print Bill</a></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Item</th><th>Qty</th><th>Price</th></tr>
  @foreach(\App\Models\OrderItem::where('order_id',$r->id)->get() as $i)
    <tr><td>{{ $i->item_name }}</td><td>{{ $i->qty }}</td><td>₹{{ number_format($i->price) }}</td></tr>
  @endforeach</table></div></div>
@endif
@if($r instanceof \App\Models\InventoryItem)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Stock Movements</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Dir</th><th>Qty</th><th>Reason</th></tr>
  @forelse(\App\Models\StockMovement::where('inventory_id',$r->id)->latest()->limit(15)->get() as $mv)
    <tr><td>{{ $mv->created_at->diffForHumans() }}</td><td>{{ strtoupper($mv->direction) }}</td><td>{{ $mv->qty }}</td><td>{{ $mv->reason }}</td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection