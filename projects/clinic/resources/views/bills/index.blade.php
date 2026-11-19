@extends('layouts.app')
@section('title', 'Bills')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Bill' : 'Add Bill' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('bills.update', $edit) : route('bills.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Patient</label>
                    <select name="patient_id"><option value="">— Select —</option>
                        @foreach($patients as $id => $n)<option value="{{ $id }}" @selected(old('patient_id', $edit->patient_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Description</label><input type="text" name="description" value="{{ old('description', $edit->description ?? '') }}"></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Paid',
  1 => 'Pending',
  2 => 'Cancelled',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Bill Date</label><input type="date" name="paid_at" value="{{ old('paid_at', $edit->paid_at ?? '') }}"></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Bill</button>
            @if($edit)<a class="btn" href="{{ route('bills.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Bills ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Invoice</th><th>Patient</th><th>For</th><th>Amount</th><th>Date</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->invoice_no }}</code></td>
                    <td><strong>{{ $r->patient->name }}</strong></td>
                    <td>{{ $r->description }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->paid_at }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('bills.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('bills.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
