@extends('layouts.app')
@section('title', 'Notices')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Notice' : 'Add Notice' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('notices.update', $edit) : route('notices.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Audience</label>
                    <select name="audience">@foreach(array (
  0 => 'All',
  1 => 'Students',
  2 => 'Teachers',
  3 => 'Parents',
) as $s)<option @selected(old('audience', $edit->audience ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Publish Date</label><input type="date" name="publish_on" value="{{ old('publish_on', $edit->publish_on ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Published',
  1 => 'Draft',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Notice Text</label><textarea name="body" required>{{ old('body', $edit->body ?? '') }}</textarea></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Notice</button>
            @if($edit)<a class="btn" href="{{ route('notices.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Notices ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'notices') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Title</th><th>Notice</th><th>Audience</th><th>Published</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ Str::limit($r->body, 80) }}</td>
                    <td>{{ $r->audience }}</td>
                    <td>{{ $r->publish_on }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'notices', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('notices.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('notices.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
