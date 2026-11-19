@extends('layouts.app')
@section('title', 'Menu Items')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Menu Item' : 'Add Menu Item' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('menu.update', $edit) : route('menu.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Item Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Category</label>
                    <select name="category">@foreach(array (
  0 => 'Starters',
  1 => 'Breads',
  2 => 'Mains',
  3 => 'South Indian',
  4 => 'Beverages',
  5 => 'Desserts',
) as $s)<option @selected(old('category', $edit->category ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Price (₹)</label><input type="number" name="price" value="{{ old('price', $edit->price ?? '') }}" required></div>
                <div class="form-row"><label>Available</label>
                    <select name="available">@foreach(array (
  1 => 'Yes',
  0 => 'No',
) as $k => $s)<option value="{{ $k }}" @selected((string)old('available', $edit->available ?? '') === (string)$k)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Menu Item</button>
            @if($edit)<a class="btn" href="{{ route('menu.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Menu Items ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'menu') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Item</th><th>Category</th><th>Price</th><th>Available</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->category }}</td>
                    <td>₹{{ number_format($r->price) }}</td>
                    <td><span class="badge">{{ $r->available ? "Yes" : "Sold Out" }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'menu', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('menu.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('menu.toggle', $r) }}" style="display:inline">@csrf<button class="btn btn-sm">{{ $r->available ? '86' : 'Enable' }}</button></form>
                        <form method="POST" action="{{ route('menu.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
