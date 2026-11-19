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
@if($r instanceof \App\Models\SupportTicket)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Conversation</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Author</th><th>Reply</th><th></th></tr>
  @forelse(\App\Models\Reply::where('ticket_id',$r->id)->oldest()->get() as $rep)
    <tr><td>{{ $rep->created_at->diffForHumans() }}</td><td>{{ $rep->author }} {{ $rep->is_ai ? '<span class="badge">AI</span>' : '' }}</td>
    <td>{{ $rep->body }}</td>
    <td>@if($rep->is_ai && !$rep->approved_at)<form method="POST" action="{{ route('replies.approve', $rep) }}">@csrf<button class="btn btn-sm">✓ Approve</button></form>
        @elseif($rep->approved_at)<span class="note">✓ approved</span>@endif</td></tr>
  @empty<tr><td colspan="4" class="empty">No replies yet.</td></tr>@endforelse</table></div></div>
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Rating</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Score</th><th>Feedback</th><th>Rated at</th></tr>
  @forelse(\App\Models\Rating::where('ticket_id',$r->id)->get() as $rt)
    <tr><td>{{ str_repeat('★', $rt->score ?? 0) }}</td><td>{{ $rt->feedback }}</td><td>{{ $rt->rated_at }}</td></tr>
  @empty<tr><td colspan="3" class="empty">Not rated.</td></tr>@endforelse</table></div></div>
@endif
@if($r instanceof \App\Models\Customer)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Tickets</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Ticket</th><th>Subject</th><th>Status</th><th></th></tr>
  @forelse(\App\Models\SupportTicket::where('customer_id',$r->id)->orWhere('customer',$r->name)->latest()->limit(10)->get() as $t)
    <tr><td>{{ $t->ticket_no }}</td><td>{{ $t->subject }}</td><td><span class="badge">{{ $t->status }}</span></td>
    <td><a class="btn btn-sm" href="{{ route('record.show', ['module'=>'tickets','id'=>$t->id]) }}">View</a></td></tr>
  @empty<tr><td colspan="4" class="empty">No tickets.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection