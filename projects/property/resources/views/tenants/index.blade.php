@extends('layouts.app')
@section('title', 'Tenants')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Tenant' : 'Add Tenant' }}</h2></div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="{{ $edit ? route('tenants.update', $edit) : route('tenants.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Tenant Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Email</label><input type="email" name="email" value="{{ old('email', $edit->email ?? '') }}"></div>
                <div class="form-row"><label>ID Proof</label><input type="text" name="id_proof" value="{{ old('id_proof', $edit->id_proof ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Moved Out',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
                <div class="form-row"><label>Document</label><input type="file" name="document"></div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Tenant</button>
            @if($edit)<a class="btn" href="{{ route('tenants.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Tenants ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'tenants') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Name</th><th>Phone</th><th>Email</th><th>ID Proof</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->phone }}</td>
                    <td>{{ $r->email }}</td>
                    <td>{{ $r->id_proof }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'tenants', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('tenants.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" enctype="multipart/form-data" action="{{ route('tenants.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
