@extends('layouts.app')
@section('title', 'Quotes')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Quote' : 'Add Quote' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('quotes.update', $edit) : route('quotes.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Deal</label>
                    <select name="deal_id"><option value="">— Select —</option>
                        @foreach($deals as $id => $n)<option value="{{ $id }}" @selected(old('deal_id', $edit->deal_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Quote Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Amount (₹)</label><input type="number" name="amount" value="{{ old('amount', $edit->amount ?? '') }}" required></div>
                <div class="form-row"><label>Valid Until</label><input type="date" name="valid_until" value="{{ old('valid_until', $edit->valid_until ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Draft',
  1 => 'Sent',
  2 => 'Accepted',
  3 => 'Rejected',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Quote</button>
            @if($edit)<a class="btn" href="{{ route('quotes.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Quotes ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Quote</th><th>Deal</th><th>Amount</th><th>Valid</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->quote_no }} — {{ $r->title }}</strong></td>
                    <td>{{ $r->deal->title ?? "—" }}</td>
                    <td>₹{{ number_format($r->amount) }}</td>
                    <td>{{ $r->valid_until }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('quotes.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('quotes.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
