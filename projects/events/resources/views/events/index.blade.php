@extends('layouts.app')
@section('title', 'Events')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Event' : 'Add Event' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('events.update', $edit) : route('events.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Event Title</label><input type="text" name="title" value="{{ old('title', $edit->title ?? '') }}" required></div>
                <div class="form-row"><label>Category</label>
                    <select name="category">@foreach(array (
  0 => 'Tech',
  1 => 'Concert',
  2 => 'Business',
  3 => 'Workshop',
  4 => 'Sports',
  5 => 'Other',
) as $s)<option @selected(old('category', $edit->category ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Venue</label><input type="text" name="venue" value="{{ old('venue', $edit->venue ?? '') }}"></div>
                <div class="form-row"><label>Date & Time</label><input type="datetime-local" name="event_date" value="{{ old('event_date', $edit->event_date ?? '') }}" required></div>
                <div class="form-row"><label>Base Price (₹)</label><input type="number" name="price" value="{{ old('price', $edit->price ?? '') }}"></div>
                <div class="form-row"><label>Capacity</label><input type="number" name="capacity" value="{{ old('capacity', $edit->capacity ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Published',
  1 => 'Draft',
  2 => 'Cancelled',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
                <div class="form-row"><label>Organizer</label><input type="text" name="organizer" value="{{ old('organizer', $edit->organizer ?? '') }}"></div>
                <div class="form-row"><label>Organizer Contact</label><input type="text" name="organizer_contact" value="{{ old('organizer_contact', $edit->organizer_contact ?? '') }}"></div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Event</button>
            @if($edit)<a class="btn" href="{{ route('events.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Events ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
            <select name="status"><option value="">All</option><option @selected(request('status')==='Draft')>Draft</option><option @selected(request('status')==='Published')>Published</option><option @selected(request('status')==='Cancelled')>Cancelled</option></select>
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'events') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Event</th><th>Venue</th><th>Date</th><th>Price</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong><br><span class="note">{{ $r->category }}</span></td>
                    <td>{{ $r->venue }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->event_date)->format('d M Y, h:i A') }}</td>
                    <td>{{ $r->price ? "₹".number_format($r->price) : "Free" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'events', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('events.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('events.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
