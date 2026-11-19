@extends('layouts.app')
@section('title', 'Family Members')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Family Member' : 'Add Family Member' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('members.update', $edit) : route('members.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Unit</label>
                    <select name="unit_id"><option value="">— Select —</option>
                        @foreach($units as $id => $n)<option value="{{ $id }}" @selected(old('unit_id', $edit->unit_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Head / Resident</label>
                    <select name="resident_id"><option value="">— Select —</option>
                        @foreach($residents as $id => $n)<option value="{{ $id }}" @selected(old('resident_id', $edit->resident_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Member Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Relation</label>
                    <select name="relation">@foreach(array (
  0 => 'Spouse',
  1 => 'Child',
  2 => 'Parent',
  3 => 'Sibling',
  4 => 'Other',
) as $s)<option @selected(old('relation', $edit->relation ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Occupation</label><input type="text" name="occupation" value="{{ old('occupation', $edit->occupation ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Family Member</button>
            @if($edit)<a class="btn" href="{{ route('members.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Family Members ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'members') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Unit</th><th>Head</th><th>Member</th><th>Relation</th><th>Phone</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->unit->flat_no }}</td>
                    <td>{{ $r->resident->name ?? "—" }}</td>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->relation }}</td>
                    <td>{{ $r->phone }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'members', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('members.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('members.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
