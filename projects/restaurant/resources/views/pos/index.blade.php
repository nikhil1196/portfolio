@extends('layouts.app')
@section('title', 'New Order')
@section('content')
<div class="card">
    <div class="card-head"><h2>Place Order</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('pos.store') }}">
            @csrf
            <div class="form-row" style="max-width:280px;">
                <label>Table</label>
                <select name="table_id" required>
                    <option value="">— Free tables —</option>
                    @foreach($tables as $t)<option value="{{ $t->id }}">{{ $t->name }} ({{ $t->seats }} seats)</option>@endforeach
                </select>
            </div>
            @foreach($items as $cat => $list)
                <h3 style="margin:1rem 0 .5rem;">{{ $cat }}</h3>
                <div class="menu-grid">
                    @foreach($list as $it)
                        <div class="menu-item">
                            <span>{{ $it->name }}<br><b>₹{{ number_format($it->price) }}</b></span>
                            <input type="number" name="qty[{{ $it->id }}]" min="0" max="20" value="0" aria-label="Qty">
                        </div>
                    @endforeach
                </div>
            @endforeach
            <button class="btn btn-acc" type="submit" style="margin-top:1rem;">Send to Kitchen</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Recent Orders</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Order</th><th>Table</th><th>Items</th><th>Total</th><th>Status</th><th>Payment</th><th></th></tr>
            @foreach($orders as $o)
                <tr>
                    <td><code>{{ $o->order_no }}</code></td>
                    <td>{{ $o->diningTable->name ?? '—' }}</td>
                    <td>{{ $o->items->sum('qty') }}</td>
                    <td>₹{{ number_format($o->total) }}</td>
                    <td><span class="badge">{{ $o->status }}</span></td>
                    <td><span class="badge">{{ $o->payment }}</span></td>
                    <td>
                        @if($o->payment === 'Unpaid')
                            <form method="POST" action="{{ route('pos.settle', $o) }}" class="inline">
                                @csrf<button class="btn btn-sm" type="submit">Settle</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
