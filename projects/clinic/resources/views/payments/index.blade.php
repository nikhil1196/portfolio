@extends('layouts.app')
@section('title', 'Payments')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Payment' : 'Add Payment' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('payments.update', $edit) : route('payments.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Appointment</label>
                    <select name="appointment_id"><option value="">— Select —</option>
                        @foreach($appointments as $id => $n)<option value="{{ $id }}" @selected(old('appointment_id', $edit->appointment_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
                <div class="form-row"><label>Method</label>
                    <select name="method">@foreach(array (
  0 => 'Cash',
  1 => 'Card',
  2 => 'UPI',
  3 => 'Stripe',
) as $s)<option @selected(old('method', $edit->method ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Transaction Ref</label><input type="text" name="txn_ref" value="{{ old('txn_ref', $edit->txn_ref ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Paid',
  1 => 'Pending',
  2 => 'Refunded',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Payment</button>
            @if($edit)<a class="btn" href="{{ route('payments.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Payments ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Receipt</th><th>Patient</th><th>Doctor</th><th>Amount</th><th>Method</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->receipt_no }}</code></td>
                    <td><strong>{{ $r->appointment->patient->name ?? "—" }}</strong></td>
                    <td>{{ $r->appointment->doctor->name ?? "—" }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->method }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('payments.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('payments.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
