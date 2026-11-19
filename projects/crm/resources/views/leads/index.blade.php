@extends('layouts.app')
@section('title', 'Leads')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Lead' : 'Add Lead' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('leads.update', $edit) : route('leads.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Contact</label>
                    <select name="contact_id"><option value="">— Select —</option>
                        @foreach($contacts as $id => $n)<option value="{{ $id }}" @selected(old('contact_id', $edit->contact_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Lead Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Est. Value (₹)</label><input type="number" name="value" value="{{ old('value', $edit->value ?? '') }}"></div>
                <div class="form-row"><label>Stage</label>
                    <select name="stage">@foreach(array (
  0 => 'New',
  1 => 'Contacted',
  2 => 'Qualified',
  3 => 'Proposal',
  4 => 'Negotiation',
  5 => 'Won',
  6 => 'Lost',
) as $s)<option @selected(old('stage', $edit->stage ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Owner</label><input type="text" name="owner" value="{{ old('owner', $edit->owner ?? '') }}"></div>
                <div class="form-row"><label>Notes</label><textarea name="notes">{{ old('notes', $edit->notes ?? '') }}</textarea></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Lead</button>
            @if($edit)<a class="btn" href="{{ route('leads.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Leads ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Lead</th><th>Contact</th><th>Value</th><th>Stage</th><th>Owner</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->contact->name ?? "—" }}<br><span class="note">{{ $r->contact->company ?? "" }}</span></td>
                    <td>₹{{ number_format($r->value) }}</td>
                    <td><span class="badge">{{ $r->stage }}</span></td>
                    <td>{{ $r->owner }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('leads.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('leads.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
