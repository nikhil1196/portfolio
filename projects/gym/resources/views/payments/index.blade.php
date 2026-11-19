@extends('layouts.app')
@section('title', 'Payments')
@section('content')
<div class="card">
    <div class="card-head"><h2>Record Payment</h2><span class="note">Total collected: <strong>₹{{ number_format($totalPaid) }}</strong></span></div>
    <div class="card-body">
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-row"><label>Member *</label>
                    <select name="member_id" required><option value="">— Member —</option>
                        @foreach($members as $id => $name)<option value="{{ $id }}" @selected(old('member_id') == $id)>{{ $name }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Plan</label>
                    <select name="plan_id"><option value="">— Plan —</option>
                        @foreach($plans as $id => $name)<option value="{{ $id }}" @selected(old('plan_id') == $id)>{{ $name }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Amount (₹) *</label><input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required></div>
                <div class="form-row"><label>Method</label>
                    <select name="method">@foreach(['Cash','UPI','Card','Bank Transfer'] as $m)<option @selected(old('method') === $m)>{{ $m }}</option>@endforeach</select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(['Paid','Pending','Due'] as $s)<option @selected(old('status', 'Paid') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">Record Payment</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Payment History ({{ $payments->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Invoice</th><th>Member</th><th>Plan</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th><th></th></tr>
            @forelse($payments as $p)
                <tr>
                    <td><code>{{ $p->invoice_no }}</code></td>
                    <td><strong>{{ $p->member->name ?? '—' }}</strong></td>
                    <td>{{ $p->plan->name ?? '—' }}</td>
                    <td>₹{{ number_format($p->amount) }}</td>
                    <td>{{ $p->method }}</td>
                    <td>{{ $p->paid_at?->format('d M Y') }}</td>
                    <td><span class="badge">{{ $p->status }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('payments.destroy', $p) }}" class="inline" onsubmit="return confirm('Delete this payment?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">No payments yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
