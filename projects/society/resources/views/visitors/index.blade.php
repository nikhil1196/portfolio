@extends('layouts.app')
@section('title', 'Visitors')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Visitor' : 'Add Visitor' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('visitors.update', $edit) : route('visitors.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Visiting Unit</label>
                    <select name="unit_id"><option value="">— Select —</option>
                        @foreach($units as $id => $n)<option value="{{ $id }}" @selected(old('unit_id', $edit->unit_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Visitor Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Phone</label><input type="tel" name="phone" value="{{ old('phone', $edit->phone ?? '') }}"></div>
                <div class="form-row"><label>Purpose</label><input type="text" name="purpose" value="{{ old('purpose', $edit->purpose ?? '') }}"></div>
                <div class="form-row"><label>Check-in</label><input type="datetime-local" name="check_in" value="{{ old('check_in', $edit->check_in ?? '') }}" required></div>
                <div class="form-row"><label>Check-out</label><input type="datetime-local" name="check_out" value="{{ old('check_out', $edit->check_out ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Inside',
  1 => 'Left',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Visitor</button>
            @if($edit)<a class="btn" href="{{ route('visitors.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Visitors ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Visitor</th><th>Unit</th><th>Purpose</th><th>In</th><th>Out</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->unit->flat_no }}</td>
                    <td>{{ $r->purpose }}</td>
                    <td>{{ $r->check_in }}</td>
                    <td>{{ $r->check_out ?? "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('visitors.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('visitors.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
