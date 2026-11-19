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
@if($r instanceof \App\Models\Unit)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Residents & Family</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Name</th><th>Role</th><th>Phone</th></tr>
  @forelse(\App\Models\Resident::where('unit_id',$r->id)->get() as $m)
    <tr><td>{{ $m->name }}</td><td><span class="badge">{{ $m->role }}</span></td><td>{{ $m->phone }}</td></tr>
  @empty<tr><td colspan="3" class="empty">None yet.</td></tr>@endforelse
  @foreach(\App\Models\FamilyMember::where('unit_id',$r->id)->get() as $fm)
    <tr><td>{{ $fm->name }}</td><td><span class="badge">{{ $fm->relation ?? 'Family' }}</span></td><td>{{ $fm->phone }}</td></tr>
  @endforeach</table></div></div>
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Maintenance</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Period</th><th>Amount</th><th>Status</th></tr>
  @forelse(\App\Models\Maintenance::where('unit_id',$r->id)->latest()->limit(10)->get() as $b)
    <tr><td>{{ $b->month ?? $b->title }}</td><td>₹{{ number_format($b->amount) }}</td><td><span class="badge">{{ $b->status }}</span></td></tr>
  @empty<tr><td colspan="3" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Resident)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Complaints</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Subject</th><th>Status</th><th>Assigned</th></tr>
  @forelse(\App\Models\Complaint::where('resident_id',$r->id)->latest()->limit(10)->get() as $cp)
    <tr><td>{{ $cp->subject }}</td><td><span class="badge">{{ $cp->status }}</span></td><td>{{ $cp->assigned_to ?? '—' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection