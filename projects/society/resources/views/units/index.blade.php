@extends('layouts.app')
@section('title', 'Units')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Unit' : 'Add Unit' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('units.update', $edit) : route('units.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Block</label><input type="text" name="block" value="{{ old('block', $edit->block ?? '') }}"></div>
                <div class="form-row"><label>Flat No</label><input type="text" name="flat_no" value="{{ old('flat_no', $edit->flat_no ?? '') }}" required></div>
                <div class="form-row"><label>Floor</label><input type="number" name="floor" value="{{ old('floor', $edit->floor ?? '') }}"></div>
                <div class="form-row"><label>Type</label>
                    <select name="type">@foreach(array (
  0 => '1 BHK',
  1 => '2 BHK',
  2 => '3 BHK',
  3 => 'Shop',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Area (sq.ft)</label><input type="number" name="area_sqft" value="{{ old('area_sqft', $edit->area_sqft ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Occupied',
  1 => 'Vacant',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Unit</button>
            @if($edit)<a class="btn" href="{{ route('units.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Units ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Flat</th><th>Block</th><th>Type</th><th>Area</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->flat_no }}</strong></td>
                    <td>{{ $r->block }}</td>
                    <td>{{ $r->type }}</td>
                    <td>{{ $r->area_sqft }} sq.ft</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('units.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('units.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
