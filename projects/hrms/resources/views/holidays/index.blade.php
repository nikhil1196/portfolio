@extends('layouts.app')
@section('title', 'Holidays')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Holiday' : 'Add Holiday' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('holidays.update', $edit) : route('holidays.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Holiday</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Date</label><input type="date" name="hdate" value="{{ old('hdate', $edit->hdate ?? '') }}" required></div>
                <div class="form-row"><label>Type</label>
                    <select name="type" required>@foreach(array (
  0 => 'Public',
  1 => 'Festival',
  2 => 'Company',
  3 => 'Optional',
) as $s)<option @selected(old('type', $edit->type ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Holiday</button>
            @if($edit)<a class="btn" href="{{ route('holidays.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Holidays ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'holidays') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Name</th><th>Date</th><th>Type</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->hdate }}</td>
                    <td><span class="badge">{{ $r->type }}</span></td>
                    <td>{{ $r->status }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'holidays', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('holidays.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('holidays.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
