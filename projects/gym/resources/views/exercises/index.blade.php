@extends('layouts.app')
@section('title', 'Exercises')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Exercise' : 'Add Exercise' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'exercises') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('exercises.update', $edit) : route('exercises.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Exercise Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Muscle Group</label>
                    <select name="muscle_group">@foreach(array (
  0 => 'Chest',
  1 => 'Back',
  2 => 'Legs',
  3 => 'Shoulders',
  4 => 'Arms',
  5 => 'Core',
  6 => 'Cardio',
  7 => 'Full Body',
) as $s)<option @selected(old('muscle_group', $edit->muscle_group ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Equipment</label>
                    <select name="equipment">@foreach(array (
  0 => 'Bodyweight',
  1 => 'Dumbbells',
  2 => 'Barbell',
  3 => 'Machines',
  4 => 'Cables',
  5 => 'Bands',
  6 => 'Kettlebell',
) as $s)<option @selected(old('equipment', $edit->equipment ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Difficulty</label>
                    <select name="difficulty">@foreach(array (
  0 => 'Beginner',
  1 => 'Intermediate',
  2 => 'Advanced',
) as $s)<option @selected(old('difficulty', $edit->difficulty ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Demo Video URL</label><input type="url" name="video_url" value="{{ old('video_url', $edit->video_url ?? '') }}"></div>
                <div class="form-row"><label>Instructions</label><textarea name="description">{{ old('description', $edit->description ?? '') }}</textarea></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Exercise</button>
            @if($edit)<a class="btn" href="{{ route('exercises.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Exercises ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Exercise</th><th>Muscle</th><th>Equipment</th><th>Level</th><th>Demo</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->muscle_group }}</td>
                    <td>{{ $r->equipment }}</td>
                    <td><span class="badge">{{ $r->difficulty }}</span></td>
                    <td>@if($r->video_url)<a href="{{ $r->video_url }}" target="_blank">▶ Watch</a>@else—@endif</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'exercises', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('exercises.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('exercises.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
