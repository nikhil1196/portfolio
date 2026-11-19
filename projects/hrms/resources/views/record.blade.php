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
@if($r instanceof \App\Models\Employee)
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Recent Attendance</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Date</th><th>In</th><th>Out</th><th>Status</th></tr>
  @forelse(\App\Models\HrAttendance::where('emp_id',$r->id)->latest('work_date')->limit(10)->get() as $a)
    <tr><td>{{ $a->work_date }}</td><td>{{ $a->check_in }}{{ $a->late ? ' ⏰' : '' }}</td><td>{{ $a->check_out }}</td><td><span class="badge">{{ $a->status }}</span></td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Payroll History</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>Month</th><th>Net</th><th>Status</th><th></th></tr>
  @forelse(\App\Models\Payroll::where('emp_id',$r->id)->latest()->limit(10)->get() as $py)
    <tr><td>{{ $py->month }}</td><td>₹{{ number_format($py->net) }}</td><td><span class="badge">{{ $py->status }}</span></td>
    <td><a class="btn btn-sm" href="{{ route('payroll.payslip', $py) }}" target="_blank">Payslip</a></td></tr>
  @empty<tr><td colspan="4" class="empty">None yet.</td></tr>@endforelse</table></div></div>
@endif
<div class="card" style="margin-top:16px"><div class="card-head"><h3>Activity</h3></div>
  <div class="card-body" style="padding:0"><table class="tbl"><tr><th>When</th><th>Action</th><th>By</th></tr>
  @forelse(\App\Models\AuditLog::where('model_type', class_basename($r))->where('model_id', $r->id)->latest()->limit(10)->get() as $l)
    <tr><td>{{ $l->created_at->diffForHumans() }}</td><td><span class="badge">{{ $l->action }}</span></td><td>{{ $l->user->name ?? 'system' }}</td></tr>
  @empty<tr><td colspan="3" class="empty">No logged activity.</td></tr>@endforelse</table></div></div>
@endsection