@extends('layouts.app')
@section('title', 'Expenses')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Expense' : 'Add Expense' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('expenses.update', $edit) : route('expenses.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Property</label>
                    <select name="property_id"><option value="">— Select —</option>
                        @foreach($properties as $id => $n)<option value="{{ $id }}" @selected(old('property_id', $edit->property_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Category</label>
                    <select name="category" required>@foreach(array (
  0 => 'Repair',
  1 => 'Utilities',
  2 => 'Tax',
  3 => 'Insurance',
  4 => 'Cleaning',
  5 => 'Other',
) as $s)<option @selected(old('category', $edit->category ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
                <div class="form-row"><label>Date</label><input type="date" name="exp_date" value="{{ old('exp_date', $edit->exp_date ?? '') }}" required></div>
                <div class="form-row"><label>Notes</label><textarea name="notes">{{ old('notes', $edit->notes ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Paid',
  1 => 'Pending',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Expense</button>
            @if($edit)<a class="btn" href="{{ route('expenses.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Expenses ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'expenses') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Property</th><th>Category</th><th>Amount</th><th>Date</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->property->title }}</strong></td>
                    <td><span class="badge">{{ $r->category }}</span></td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->exp_date }}</td>
                    <td>{{ $r->status }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'expenses', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('expenses.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('expenses.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
