@extends('layouts.app')
@section('title', 'Fee Structure')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Fee Structure' : 'Add Fee Structure' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? url('/fee-structures/' . $edit->id) : route('fee-structures.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Class</label>
                    <select name="class_id" required><option value="">— Select —</option>
                        @foreach($school_classes as $id => $n)<option value="{{ $id }}" @selected(old('class_id', $edit->class_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Term</label><input type="text" name="term" value="{{ old('term', $edit->term ?? '') }}" placeholder="e.g. Term 1 / Annual" required></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" step="0.01" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
            </div>
            <button class="btn btn-primary">{{ $edit ? 'Update' : 'Add' }}</button>
            @if($edit)<a class="btn" href="{{ route('fee-structures.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>
<div class="card" style="margin-top:16px">
    <div class="card-head"><h2>All Fee Structures ({{ $rows->total() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search term…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'fee-structures') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Class</th><th>Term</th><th>Amount</th><th></th></tr>
            @forelse($rows as $r)
            <tr>
                <td>{{ $r->schoolClass->name ?? '—' }}</td><td>{{ $r->term }}</td><td>₹{{ number_format($r->amount) }}</td>
                <td>
                    <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'fee-structures', 'id' => $r->id]) }}">View</a>
                    <a class="btn btn-sm" href="{{ route('fee-structures.index', ['edit' => $r->id]) }}">Edit</a>
                    <form method="POST" action="{{ url('/fee-structures/' . $r->id) }}" style="display:inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Del</button></form>
                </td>
            </tr>
            @empty<tr><td colspan="4" class="empty">No fee structures yet.</td></tr>@endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection