@extends('layouts.app')
@section('title', 'Leases')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Lease' : 'Add Lease' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('leases.update', $edit) : route('leases.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Property</label>
                    <select name="property_id"><option value="">— Select —</option>
                        @foreach($properties as $id => $n)<option value="{{ $id }}" @selected(old('property_id', $edit->property_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Tenant</label>
                    <select name="tenant_id"><option value="">— Select —</option>
                        @foreach($tenants as $id => $n)<option value="{{ $id }}" @selected(old('tenant_id', $edit->tenant_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Start Date</label><input type="date" name="start_date" value="{{ old('start_date', $edit->start_date ?? '') }}" required></div>
                <div class="form-row"><label>End Date</label><input type="date" name="end_date" value="{{ old('end_date', $edit->end_date ?? '') }}" required></div>
                <div class="form-row"><label>Monthly Rent (₹)</label><input type="number" name="rent" value="{{ old('rent', $edit->rent ?? '') }}" required></div>
                <div class="form-row"><label>Deposit (₹)</label><input type="number" name="deposit" value="{{ old('deposit', $edit->deposit ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Expired',
  2 => 'Terminated',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Lease</button>
            @if($edit)<a class="btn" href="{{ route('leases.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Leases ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'leases') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Property</th><th>Tenant</th><th>Period</th><th>Rent</th><th>Deposit</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->property->title ?? "—" }}</strong></td>
                    <td>{{ $r->tenant->name ?? "—" }}</td>
                    <td>{{ $r->start_date }} → {{ $r->end_date }}</td>
                    <td>₹{{ number_format($r->rent) }}</td>
                    <td>₹{{ number_format($r->deposit) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'leases', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('leases.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('leases.renew', $r) }}" style="display:inline">@csrf<button class="btn btn-sm">↻ Renew</button></form>
                        <form method="POST" action="{{ route('leases.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
