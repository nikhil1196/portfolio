@extends('layouts.app')
@section('title', 'Maintenance Receipts')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Maintenance Receipt' : 'Add Maintenance Receipt' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('receipts.update', $edit) : route('receipts.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Maintenance Bill</label>
                    <select name="maintenance_id"><option value="">— Select —</option>
                        @foreach($maintenances as $id => $n)<option value="{{ $id }}" @selected(old('maintenance_id', $edit->maintenance_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Unit</label>
                    <select name="unit_id"><option value="">— Select —</option>
                        @foreach($units as $id => $n)<option value="{{ $id }}" @selected(old('unit_id', $edit->unit_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
                <div class="form-row"><label>Method</label>
                    <select name="method" required>@foreach(array (
  0 => 'Online',
  1 => 'UPI',
  2 => 'Card',
  3 => 'Cash',
  4 => 'Cheque',
) as $s)<option @selected(old('method', $edit->method ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Transaction Ref</label><input type="text" name="txn_ref" value="{{ old('txn_ref', $edit->txn_ref ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Paid',
  1 => 'Pending',
  2 => 'Failed',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Maintenance Receipt</button>
            @if($edit)<a class="btn" href="{{ route('receipts.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Maintenance Receipts ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'receipts') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Receipt</th><th>Unit</th><th>Bill #</th><th>Amount</th><th>Method</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->receipt_no }}</strong></td>
                    <td>{{ $r->unit->flat_no }}</td>
                    <td>#{{ $r->maintenance_id }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->method }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'receipts', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('receipts.index', ['edit' => $r->id]) }}">Edit</a>
                        <a class="btn btn-sm" href="{{ route('receipts.print', $r) }}" target="_blank">Print</a>
                        <form method="POST" action="{{ route('receipts.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
