@extends('layouts.app')
@section('title', 'Rent Records')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Rent Record' : 'Add Rent Record' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('rents.update', $edit) : route('rents.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Lease</label>
                    <select name="lease_id"><option value="">— Select —</option>
                        @foreach($leases as $id => $n)<option value="{{ $id }}" @selected(old('lease_id', $edit->lease_id ?? '') == $id)>{{ $n }}</option>@endforeach
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
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Rent Record</button>
            @if($edit)<a class="btn" href="{{ route('rents.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Rent Records ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Property</th><th>Tenant</th><th>Month</th><th>Amount</th><th>Paid On</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->lease->property->title ?? "—" }}</strong></td>
                    <td>{{ $r->lease->tenant->name ?? "—" }}</td>
                    <td>{{ $r->month }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->paid_at ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('rents.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('rents.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
