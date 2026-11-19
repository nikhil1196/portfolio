@extends('layouts.app')
@section('title', 'Venues')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Venue' : 'Add Venue' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('venues.update', $edit) : route('venues.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Venue</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Address</label><input type="text" name="address" value="{{ old('address', $edit->address ?? '') }}"></div>
                <div class="form-row"><label>Capacity</label><input type="number" name="capacity" value="{{ old('capacity', $edit->capacity ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Venue</button>
            @if($edit)<a class="btn" href="{{ route('venues.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Venues ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
            <select name="status"><option value="">All</option><option @selected(request('status')==='Active')>Active</option><option @selected(request('status')==='Inactive')>Inactive</option></select>
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'venues') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Venue</th><th>Address</th><th>Capacity</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->address }}</td>
                    <td>{{ $r->capacity }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'venues', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('venues.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('venues.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
