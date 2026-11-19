@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="card">
  <div class="page-head"><h2>{{ $title }}</h2><a class="btn" href="{{ url('/' . $module) }}">← Back</a></div>
  <table class="tbl">@foreach($r->getAttributes() as $k => $v)
    <tr><th style="width:200px">{{ str_replace('_',' ',$k) }}</th><td>{{ $v }}</td></tr>@endforeach
  </table>
</div>
@if($r instanceof \App\Models\Member)
<div class="grid" style="grid-template-columns:1fr 1fr;margin-top:16px">
  <div class="card"><h3>Attendance history</h3>
    <table class="tbl"><tr><th>Check-in</th><th>Check-out</th></tr>
    @forelse(\App\Models\Attendance::where('member_id',$r->id)->latest()->limit(10)->get() as $a)
      <tr><td>{{ $a->check_in }}</td><td>{{ $a->check_out ?? '—' }}</td></tr>
    @empty<tr><td colspan="2" class="empty">No visits yet.</td></tr>@endforelse</table></div>
  <div class="card"><h3>Payment history</h3>
    <table class="tbl"><tr><th>Invoice</th><th>Amount</th><th>Status</th></tr>
    @forelse(\App\Models\Payment::where('member_id',$r->id)->latest()->limit(10)->get() as $p)
      <tr><td>{{ $p->invoice_no }}</td><td>₹{{ number_format($p->amount) }}</td><td><span class="badge">{{ $p->status }}</span></td></tr>
    @empty<tr><td colspan="3" class="empty">No payments yet.</td></tr>@endforelse</table></div>
</div>
@endif
<div class="card" style="margin-top:16px"><h3>Activity</h3>
  <table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div>
@endsection