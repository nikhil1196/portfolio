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
@if($r instanceof \App\Models\Student)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Fees</h3>
  <a class="btn btn-sm" href="{{ route('students.report-card', $r) }}" target="_blank">Report Card</a></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Receipt</th><th>Term</th><th>Amount</th><th>Status</th></tr>
  @forelse(\App\Models\Fee::where('student_id',$r->id)->latest()->limit(10)->get() as $f)
    <tr><td>{{ $f->receipt_no }}</td><td>{{ $f->term }}</td><td>₹{{ number_format($f->amount) }}</td><td><span class="badge">{{ $f->status }}</span></td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Recent Results</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Exam</th><th>Subject</th><th>Marks</th><th>Grade</th></tr>
  @forelse(\App\Models\Result::where('student_id',$r->id)->latest()->limit(10)->get() as $x)
    <tr><td>{{ $x->exam }}</td><td>{{ $x->subject }}</td><td>{{ $x->marks }}/{{ $x->max_marks }}</td><td><strong>{{ $x->grade }}</strong></td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection