@extends('layouts.app')
@section('title', 'Propertys')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Property' : 'Add Property' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('properties.update', $edit) : route('properties.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Property Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Type</label>
                    <select name="type">@foreach(array (
  0 => 'Apartment',
  1 => 'Villa',
  2 => 'Studio',
  3 => 'Commercial',
  4 => 'Shop',
  5 => 'Plot',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Address</label><input type="text" name="address" value="{{ old('address', $edit->address ?? '') }}"></div>
                <div class="form-row"><label>City</label><input type="text" name="city" value="{{ old('city', $edit->city ?? '') }}"></div>
                <div class="form-row"><label>Rent (₹/mo)</label><input type="number" name="rent" value="{{ old('rent', $edit->rent ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Available',
  1 => 'Occupied',
  2 => 'Maintenance',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Property</button>
            @if($edit)<a class="btn" href="{{ route('properties.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Propertys ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Property</th><th>Type</th><th>Location</th><th>Rent</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->type }}</td>
                    <td>{{ $r->address }}, {{ $r->city }}</td>
                    <td>₹{{ number_format($r->rent) }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('properties.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('properties.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
