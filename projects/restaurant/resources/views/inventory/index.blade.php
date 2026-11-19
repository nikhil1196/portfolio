@extends('layouts.app')
@section('title', 'Inventory Items')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Inventory Item' : 'Add Inventory Item' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('inventory.update', $edit) : route('inventory.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Ingredient / Item</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Unit</label>
                    <select name="unit" required>@foreach(array (
  0 => 'kg',
  1 => 'g',
  2 => 'ltr',
  3 => 'ml',
  4 => 'pcs',
  5 => 'box',
) as $s)<option @selected(old('unit', $edit->unit ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Qty in Stock</label><input type="number" name="qty" value="{{ old('qty', $edit->qty ?? '') }}" required></div>
                <div class="form-row"><label>Reorder Level</label><input type="number" name="reorder_level" value="{{ old('reorder_level', $edit->reorder_level ?? '') }}"></div>
                <div class="form-row"><label>Supplier</label><input type="text" name="supplier" value="{{ old('supplier', $edit->supplier ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Inventory Item</button>
            @if($edit)<a class="btn" href="{{ route('inventory.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Inventory Items ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
            <label style="display:flex;align-items:center;gap:4px"><input type="checkbox" name="low" value="1" @checked(request('low'))> Low stock only</label>
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'inventory') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Item</th><th>Stock</th><th>Reorder @</th><th>Supplier</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->qty }} {{ $r->unit }} @if($r->qty <= $r->reorder_level)<span class="badge b-overdue">Low</span>@endif</td>
                    <td>{{ $r->reorder_level }}</td>
                    <td>{{ $r->supplier }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'inventory', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('inventory.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('inventory.adjust', $r) }}" style="display:inline-flex;gap:4px">@csrf
                            <input type="number" step="0.01" name="qty" placeholder="Qty" style="width:70px" required>
                            <select name="direction"><option value="in">+In</option><option value="out">−Out</option></select>
                            <button class="btn btn-sm">Adjust</button></form>
                        <form method="POST" action="{{ route('inventory.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
