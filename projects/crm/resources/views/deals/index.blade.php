@extends('layouts.app')
@section('title', 'Deals')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Deal' : 'Add Deal' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('deals.update', $edit) : route('deals.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Contact</label>
                    <select name="contact_id"><option value="">— Select —</option>
                        @foreach($contacts as $id => $n)<option value="{{ $id }}" @selected(old('contact_id', $edit->contact_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Deal Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Deal Value (₹)</label><input type="number" name="value" value="{{ old('value', $edit->value ?? '') }}" required></div>
                <div class="form-row"><label>Stage</label>
                    <select name="stage">@foreach(array (
  0 => 'Qualification',
  1 => 'Proposal',
  2 => 'Negotiation',
  3 => 'Won',
  4 => 'Lost',
) as $s)<option @selected(old('stage', $edit->stage ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Expected Close</label><input type="date" name="close_date" value="{{ old('close_date', $edit->close_date ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Open',
  1 => 'Closed',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Deal</button>
            @if($edit)<a class="btn" href="{{ route('deals.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Deals ({{ $rows->count() }})</h2><a class="btn btn-sm" href="{{ route('pipeline') }}">◈ Pipeline Board</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Deal</th><th>Contact</th><th>Value</th><th>Stage</th><th>Close</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->contact->name ?? "—" }}</td>
                    <td>₹{{ number_format($r->value) }}</td>
                    <td><span class="badge">{{ $r->stage }}</span></td>
                    <td>{{ $r->close_date }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('deals.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('deals.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
