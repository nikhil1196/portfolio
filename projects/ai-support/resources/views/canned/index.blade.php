@extends('layouts.app')
@section('title', 'Canned Replys')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Canned Reply' : 'Add Canned Reply' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('canned.update', $edit) : route('canned.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Reply Text</label><textarea name="body" required>{{ old('body', $edit->body ?? '') }}</textarea></div>
                <div class="form-row"><label>Category</label>
                    <select name="category">@foreach(array (
  0 => 'Billing',
  1 => 'General',
  2 => 'API',
  3 => 'Account',
) as $s)<option @selected(old('category', $edit->category ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Canned Reply</button>
            @if($edit)<a class="btn" href="{{ route('canned.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Canned Replys ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'canned') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Title</th><th>Text</th><th>Category</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ Str::limit($r->body, 80) }}</td>
                    <td>{{ $r->category }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'canned', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('canned.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('canned.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
