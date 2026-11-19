@extends('layouts.app')
@section('title', 'Ticket Tiers')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Ticket Tier' : 'Add Ticket Tier' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('tickets.update', $edit) : route('tickets.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Event</label>
                    <select name="event_id"><option value="">— Select —</option>
                        @foreach($events as $id => $n)<option value="{{ $id }}" @selected(old('event_id', $edit->event_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Tier Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Price (₹)</label><input type="number" name="price" value="{{ old('price', $edit->price ?? '') }}" required></div>
                <div class="form-row"><label>Quantity</label><input type="number" name="qty" value="{{ old('qty', $edit->qty ?? '') }}" required></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Ticket Tier</button>
            @if($edit)<a class="btn" href="{{ route('tickets.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Ticket Tiers ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Event</th><th>Tier</th><th>Price</th><th>Qty</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->event->title ?? "—" }}</td>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>₹{{ number_format($r->price) }}</td>
                    <td>{{ $r->qty }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('tickets.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('tickets.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
