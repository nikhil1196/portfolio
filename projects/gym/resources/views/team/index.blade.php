@extends('layouts.app')
@section('title', 'Team Users')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit User' : 'Add User' }}</h2>
        </div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('team.update', $edit) : route('team.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Name</label><input name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Email</label><input type="email" name="email" value="{{ old('email', $edit->email ?? '') }}" required></div>
                <div class="form-row"><label>Password{{ $edit ? ' (blank = keep)' : '' }}</label><input type="password" name="password" {{ $edit ? '' : 'required' }}></div>
                <div class="form-row"><label>Role</label>
                    <select name="role_id"><option value="">— No role —</option>
                        @foreach($roles as $id => $n)<option value="{{ $id }}" @selected(old('role_id', $edit->role_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} User</button>
            @if($edit)<a class="btn" href="{{ route('team.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>
<div class="card">
    <div class="card-head"><h2>All Users ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'team') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->email }}</td>
                    <td><span class="badge">{{ $r->role->name ?? '—' }}</span></td>
                    <td>{{ $r->created_at->format('d M Y') }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'team', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('team.index', ['edit' => $r->id]) }}">Edit</a>
                        @if($r->id !== auth()->id())
                        <form method="POST" action="{{ route('team.destroy', $r) }}" class="inline" onsubmit="return confirm('Remove this user?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No users</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
