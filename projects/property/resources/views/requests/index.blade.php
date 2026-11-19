@extends('layouts.app')
@section('title', 'Maintenance Requests')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Maintenance Request' : 'Add Maintenance Request' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('requests.update', $edit) : route('requests.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Property</label>
                    <select name="property_id"><option value="">— Select —</option>
                        @foreach($properties as $id => $n)<option value="{{ $id }}" @selected(old('property_id', $edit->property_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Raised By</label>
                    <select name="tenant_id"><option value="">— Select —</option>
                        @foreach($tenants as $id => $n)<option value="{{ $id }}" @selected(old('tenant_id', $edit->tenant_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Category</label>
                    <select name="category">@foreach(array (
  0 => 'Plumbing',
  1 => 'Electrical',
  2 => 'Carpentry',
  3 => 'General',
  4 => 'Pest Control',
) as $s)<option @selected(old('category', $edit->category ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Issue</label><input type="text" name="subject" value="{{ old('subject', $edit->subject ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Open',
  1 => 'In Progress',
  2 => 'Resolved',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Maintenance Request</button>
            @if($edit)<a class="btn" href="{{ route('requests.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Maintenance Requests ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Issue</th><th>Property</th><th>Raised By</th><th>Category</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->subject }}</strong></td>
                    <td>{{ $r->property->title ?? "—" }}</td>
                    <td>{{ $r->tenant->name ?? "—" }}</td>
                    <td>{{ $r->category }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('requests.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('requests.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
