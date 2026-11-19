<!DOCTYPE html><html><head><meta charset="utf-8"><title>Payslip — {{ $p->employee->name }}</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:24px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}
.total{font-weight:700;font-size:18px}@media print{.noprint{display:none}}</style></head>
<body>
<h1>Payslip — {{ $p->month }}</h1>
<div class="row"><span>Employee</span><strong>{{ $p->employee->name }} ({{ $p->employee->emp_code }})</strong></div>
<div class="row"><span>Department</span><span>{{ $p->employee->department->name ?? '—' }}</span></div>
<div class="row"><span>Designation</span><span>{{ $p->employee->designation ?? '—' }}</span></div>
<div class="row"><span>Basic</span><span>₹{{ number_format($p->basic) }}</span></div>
<div class="row"><span>Allowances</span><span>+ ₹{{ number_format($p->allowances) }}</span></div>
<div class="row"><span>Deductions</span><span>− ₹{{ number_format($p->deductions) }}</span></div>
<div class="row total"><span>Net Pay</span><span>₹{{ number_format($p->net) }}</span></div>
<div class="row"><span>Status</span><span>{{ $p->status }}{{ $p->paid_at ? ' · ' . $p->paid_at : '' }}</span></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('payroll.index') }}">← Back</a></p>
</body></html>