@extends('layouts.app')
@section('title', 'Maintenance Bills')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Maintenance Bill' : 'Add Maintenance Bill' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('maintenance.update', $edit) : route('maintenance.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Unit</label>
                    <select name="unit_id"><option value="">— Select —</option>
                        @foreach($units as $id => $n)<option value="{{ $id }}" @selected(old('unit_id', $edit->unit_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Month</label><input type="month" name="month" value="{{ old('month', $edit->month ?? '') }}" required></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Paid',
  1 => 'Due',
  2 => 'Overdue',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Paid On</label><input type="date" name="paid_at" value="{{ old('paid_at', $edit->paid_at ?? '') }}"></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Maintenance Bill</button>
            @if($edit)<a class="btn" href="{{ route('maintenance.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Maintenance Bills ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Flat</th><th>Month</th><th>Amount</th><th>Paid On</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->unit->flat_no ?? "—" }}</strong></td>
                    <td>{{ $r->month }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->paid_at ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        @if($r->status === 'Due')
                            <form method="POST" action="{{ route('maintenance.pay', $r) }}" class="inline">@csrf @method('PATCH')
                                <button class="btn btn-sm" type="submit">Mark Paid</button>
                            </form>
                        @endif
                        <a class="btn btn-sm" href="{{ route('maintenance.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('maintenance.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
