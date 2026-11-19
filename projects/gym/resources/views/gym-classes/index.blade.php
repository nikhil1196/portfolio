@extends('layouts.app')
@section('title', 'Classs')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Class' : 'Add Class' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'gym-classes') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('gym-classes.update', $edit) : route('gym-classes.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Class Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Trainer</label>
                    <select name="trainer_id"><option value="">— Select —</option>
                        @foreach($trainers as $id => $n)<option value="{{ $id }}" @selected(old('trainer_id', $edit->trainer_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Day</label>
                    <select name="day">@foreach(array (
  0 => 'Monday',
  1 => 'Tuesday',
  2 => 'Wednesday',
  3 => 'Thursday',
  4 => 'Friday',
  5 => 'Saturday',
  6 => 'Sunday',
) as $s)<option @selected(old('day', $edit->day ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Start Time</label><input type="time" name="start_time" value="{{ old('start_time', $edit->start_time ?? '') }}"></div>
                <div class="form-row"><label>Duration (min)</label><input type="number" name="duration_min" value="{{ old('duration_min', $edit->duration_min ?? '') }}"></div>
                <div class="form-row"><label>Capacity</label><input type="number" name="capacity" value="{{ old('capacity', $edit->capacity ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Inactive',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Class</button>
            @if($edit)<a class="btn" href="{{ route('gym-classes.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Classs ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Class</th><th>Trainer</th><th>Schedule</th><th>Duration</th><th>Capacity</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->trainer->name ?? "—" }}</td>
                    <td>{{ $r->day }} {{ $r->start_time }}</td>
                    <td>{{ $r->duration_min }} min</td>
                    <td>{{ $r->capacity }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'gym-classes', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('gym-classes.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('gym-classes.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
        {{ $rows->links() }}
    </div>
</div>
@endsection
