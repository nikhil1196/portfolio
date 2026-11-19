@extends('layouts.app')
@section('title', 'Staff / Vendors')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Staff / Vendor' : 'Add Staff / Vendor' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('staff.update', $edit) : route('staff.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Role</label>
                    <select name="role" required>@foreach(array (
  0 => 'Security',
  1 => 'Gardener',
  2 => 'Cleaner',
  3 => 'Electrician',
  4 => 'Plumber',
  5 => 'Vendor',
  6 => 'Other',
) as $s)<option @selected(old('role', $edit->role ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Shift</label>
                    <select name="shift">@foreach(array (
  0 => 'Morning',
  1 => 'Evening',
  2 => 'Night',
  3 => 'On-call',
) as $s)<option @selected(old('shift', $edit->shift ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Staff / Vendor</button>
            @if($edit)<a class="btn" href="{{ route('staff.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Staff / Vendors ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'staff') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Name</th><th>Role</th><th>Phone</th><th>Shift</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->role }}</td>
                    <td>{{ $r->phone }}</td>
                    <td>{{ $r->shift }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'staff', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('staff.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('staff.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
