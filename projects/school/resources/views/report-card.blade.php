<!DOCTYPE html><html><head><meta charset="utf-8"><title>Report Card — {{ $student->name }}</title>
<style>body{font-family:system-ui;max-width:680px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0 0 4px}.sub{color:#666;margin-bottom:16px}
table{width:100%;border-collapse:collapse;margin:10px 0 20px}th,td{padding:8px;border:1px solid #ddd;text-align:left;font-size:14px}
th{background:#f6f7fb}.tot{font-weight:700}@media print{.noprint{display:none}}</style></head>
<body>
<h1>Report Card</h1>
<div class="sub">{{ $student->name }} · Roll {{ $student->roll_no }} · Class {{ $student->schoolClass->name ?? '—' }}
@if($attPct !== null) · Attendance {{ $attPct }}%@endif</div>
@forelse($results as $exam => $rows)
<h3>{{ $exam }}</h3>
<table><tr><th>Subject</th><th>Marks</th><th>Out of</th><th>Grade</th></tr>
@php $tot=0; $max=0; @endphp
@foreach($rows as $r)@php $tot+=$r->marks; $max+=$r->max_marks; @endphp
<tr><td>{{ $r->subject }}</td><td>{{ $r->marks }}</td><td>{{ $r->max_marks }}</td><td><strong>{{ $r->grade }}</strong></td></tr>
@endforeach
<tr class="tot"><td>Total</td><td>{{ $tot }}</td><td>{{ $max }}</td><td>{{ $max ? round($tot/$max*100,1) : 0 }}%</td></tr>
</table>
@empty<p>No results recorded yet.</p>@endforelse
<p class="noprint"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('students.index') }}">← Back</a></p>
</body></html>