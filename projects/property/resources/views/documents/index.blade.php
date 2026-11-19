@extends('layouts.app')
@section('title', 'Documents')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Document' : 'Add Document' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('documents.update', $edit) : route('documents.store') }}">
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
                <div class="form-row"><label>Document</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Type</label>
                    <select name="type" required>@foreach(array (
  0 => 'Agreement',
  1 => 'ID Proof',
  2 => 'Invoice',
  3 => 'Notice',
  4 => 'Other',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>File / Link</label><input type="text" name="file_path" value="{{ old('file_path', $edit->file_path ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Archived',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Document</button>
            @if($edit)<a class="btn" href="{{ route('documents.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Documents ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Document</th><th>Property</th><th>Tenant</th><th>Type</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->property->title }}</td>
                    <td>{{ $r->tenant->name ?? "—" }}</td>
                    <td><span class="badge">{{ $r->type }}</span></td>
                    <td>{{ $r->status }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('documents.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('documents.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
