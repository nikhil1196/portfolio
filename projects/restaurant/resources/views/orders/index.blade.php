@extends('layouts.app')
@section('title', 'Orders')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Order' : 'Add Order' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('orders.update', $edit) : route('orders.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Table</label>
                    <select name="table_id"><option value="">— Select —</option>
                        @foreach($dining_tables as $id => $n)<option value="{{ $id }}" @selected(old('table_id', $edit->table_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Pending',
  1 => 'Preparing',
  2 => 'Ready',
  3 => 'Served',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Total (₹)</label><input type="number" name="total" value="{{ old('total', $edit->total ?? '') }}"></div>
                <div class="form-row"><label>Payment</label>
                    <select name="payment">@foreach(array (
  0 => 'Unpaid',
  1 => 'Paid',
) as $s)<option @selected(old('payment', $edit->payment ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Order</button>
            @if($edit)<a class="btn" href="{{ route('orders.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Orders ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Order</th><th>Table</th><th>Items</th><th>Total</th><th>Status</th><th>Payment</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><code>{{ $r->order_no }}</code></td>
                    <td>{{ $r->diningTable->name ?? "—" }}</td>
                    <td>{{ $r->items->sum("qty") }}</td>
                    <td>₹{{ number_format($r->total) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td><span class="badge">{{ $r->payment }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('orders.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('orders.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
