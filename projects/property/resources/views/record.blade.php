@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="card">
  <div class="card-head"><h2>{{ $title }}</h2><a class="btn" href="{{ url('/' . $module) }}">← Back</a></div>
  @if($r instanceof \App\Models\Property && $r->image)
  <div class="card-body"><img src="{{ asset('storage/' . $r->image) }}" style="max-width:320px;border-radius:8px" alt=""></div>
  @endif
  <div class="card-body" style="padding:0">
  <table class="tbl">@foreach($r->getAttributes() as $k => $v)
    <tr><th style="width:200px;text-align:left">{{ str_replace('_',' ',$k) }}</th><td>{{ $v }}</td></tr>@endforeach
  </table></div>
</div>
@if($r instanceof \App\Models\Property)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Leases</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Tenant</th><th>Period</th><th>Rent</th><th>Status</th></tr>
  @forelse(\App\Models\Lease::with('tenant')->where('property_id',$r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->tenant->name ?? '—' }}</td><td>{{ $l->start_date }} → {{ $l->end_date }}</td><td>₹{{ number_format($l->rent) }}</td><td><span class="badge">{{ $l->status }}</span></td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Tenant)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Lease History</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Property</th><th>Period</th><th>Status</th></tr>
  @forelse(\App\Models\Lease::with('property')->where('tenant_id',$r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->property->title ?? '—' }}</td><td>{{ $l->start_date }} → {{ $l->end_date }}</td><td><span class="badge">{{ $l->status }}</span></td></tr>
  @empty<tr><td colspan="3" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Lease)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Rent Schedule</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Month</th><th>Amount</th><th>Status</th><th></th></tr>
  @forelse(\App\Models\Rent::where('lease_id',$r->id)->latest()->limit(15)->get() as $rn)
    <tr><td>{{ $rn->month }}</td><td>₹{{ number_format($rn->amount) }}</td><td><span class="badge">{{ $rn->status }}</span></td>
    <td><a class="btn btn-sm" href="{{ route('rents.receipt', $rn) }}" target="_blank">Receipt</a></td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection