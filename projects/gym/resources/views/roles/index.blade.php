@extends('layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Role' : 'Add Role' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'roles') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('roles.update', $edit) : route('roles.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-row"><label>Role Name</label><input name="name" value="{{ old('name', $edit->name ?? '') }}" required style="max-width:300px"></div>
            <div class="form-row mt"><label>Module Permissions (write access — everyone can view)</label>
                <div style="display:flex;flex-wrap:wrap;gap:10px 18px">
                @php $cur = $edit ? $edit->permsList() : []; @endphp
                @foreach(array_merge(['*'], $modules) as $pm)
                    <label style="font-weight:400;display:flex;gap:6px;align-items:center">
                        <input type="checkbox" name="perms[]" value="{{ $pm }}" @checked(in_array($pm, $cur))> {{ $pm }}
                    </label>
                @endforeach
                </div>
            </div>
            <button class="btn btn-acc mt" type="submit">{{ $edit ? 'Update' : 'Add' }} Role</button>
            @if($edit)<a class="btn" href="{{ route('roles.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>
<div class="card">
    <div class="card-head"><h2>All Roles ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Role</th><th>Permissions</th><th>Users</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>@foreach($r->permsList() as $p)<span class="badge">{{ $p }}</span> @endforeach</td>
                    <td>{{ $r->users_count }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'roles', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('roles.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('roles.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">No roles yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
