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
@if($r instanceof \App\Models\Contact)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Deals</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Title</th><th>Value</th><th>Stage</th><th>Prob.</th></tr>
  @forelse(\App\Models\Deal::where('contact_id',$r->id)->latest()->limit(10)->get() as $d)
    <tr><td>{{ $d->title }}</td><td>₹{{ number_format($d->value) }}</td><td><span class="badge">{{ $d->stage }}</span></td><td>{{ $d->probability }}%</td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Leads</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Title</th><th>Stage</th><th>Owner</th></tr>
  @forelse(\App\Models\Lead::where('contact_id',$r->id)->latest()->limit(10)->get() as $ld)
    <tr><td>{{ $ld->title }}</td><td><span class="badge">{{ $ld->stage }}</span></td><td>{{ $ld->owner ?? '—' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Lead)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity Timeline</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Type</th><th>Summary</th><th>Due</th><th>Done</th></tr>
  @forelse(\App\Models\Activity::where('lead_id',$r->id)->latest()->limit(15)->get() as $a)
    <tr><td>{{ $a->type }}</td><td>{{ $a->summary }}</td><td>{{ $a->due_at }}</td><td>{{ $a->done ? '✓' : '—' }}</td></tr>
  @empty<tr><td colspan="4" class="empty">No activities.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Deal)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Quotes</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Quote</th><th>Amount</th><th>Status</th><th></th></tr>
  @forelse(\App\Models\Quote::where('deal_id',$r->id)->latest()->limit(10)->get() as $qt)
    <tr><td>{{ $qt->quote_no }}</td><td>₹{{ number_format($qt->amount) }}</td><td><span class="badge">{{ $qt->status }}</span></td>
    <td><a class="btn btn-sm" href="{{ route('quotes.print', $qt) }}" target="_blank">Print</a></td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection