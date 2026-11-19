<!DOCTYPE html><html><head><meta charset="utf-8"><title>Prescription #{{ $r->id }}</title>
<style>body{font-family:system-ui;max-width:680px;margin:40px auto;padding:28px;border:1px solid #ddd;border-radius:8px}
h1{font-size:20px;margin:0 0 4px}.sub{color:#666;margin-bottom:18px}.sec{margin:14px 0;padding-top:12px;border-top:1px solid #eee}
label{color:#888;font-size:12px;text-transform:uppercase}@media print{.noprint{display:none}}</style></head>
<body>
<h1>℞ Prescription</h1>
<div class="sub">{{ $r->doctor->clinic->name ?? 'Clinic' }} — Dr. {{ $r->doctor->name }}</div>
<div class="sec"><label>Patient</label><div><strong>{{ $r->patient->name }}</strong> · {{ $r->patient->phone }}</div></div>
<div class="sec"><label>Diagnosis / Notes</label><div>{{ $r->notes ?? '—' }}</div></div>
<div class="sec"><label>Medicines & Dosage</label><div style="white-space:pre-line">{{ $r->medicines }}</div></div>
<div class="sec"><label>Date</label><div>{{ $r->created_at->format('d M Y') }}</div></div>
<p class="noprint" style="margin-top:24px"><button onclick="window.print()">Print / Save PDF</button>
<a href="{{ route('prescriptions.index') }}">← Back</a></p>
</body></html>