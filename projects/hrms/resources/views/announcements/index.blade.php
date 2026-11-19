@extends('layouts.app')
@section('title', 'Announcements')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Announcement' : 'Add Announcement' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('announcements.update', $edit) : route('announcements.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Audience</label>
                    <select name="audience" required>@foreach(array (
  0 => 'All',
  1 => 'Management',
  2 => 'Staff',
) as $s)<option @selected(old('audience', $edit->audience ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Publish Date</label><input type="date" name="publish_date" value="{{ old('publish_date', $edit->publish_date ?? '') }}" required></div>
                <div class="form-row"><label>Message</label><textarea name="body">{{ old('body', $edit->body ?? '') }}</textarea></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Announcement</button>
            @if($edit)<a class="btn" href="{{ route('announcements.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Announcements ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'announcements') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Title</th><th>Audience</th><th>Published</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->audience }}</td>
                    <td>{{ $r->publish_date }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'announcements', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('announcements.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('announcements.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
