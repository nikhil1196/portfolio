@extends('layouts.app')
@section('title', 'Workout Plans')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Workout Plan' : 'Add Workout Plan' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'workout-plans') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('workout-plans.update', $edit) : route('workout-plans.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Plan Name</label><input type="text" name="name" value="{{ old('name', $edit->name ?? '') }}" required></div>
                <div class="form-row"><label>Goal</label>
                    <select name="goal">@foreach(array (
  0 => 'Weight Loss',
  1 => 'Muscle Gain',
  2 => 'Strength',
  3 => 'Endurance',
  4 => 'Flexibility',
  5 => 'General Fitness',
) as $s)<option @selected(old('goal', $edit->goal ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Level</label>
                    <select name="level">@foreach(array (
  0 => 'Beginner',
  1 => 'Intermediate',
  2 => 'Advanced',
) as $s)<option @selected(old('level', $edit->level ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Duration (weeks)</label><input type="number" name="duration_weeks" value="{{ old('duration_weeks', $edit->duration_weeks ?? '') }}"></div>
                <div class="form-row"><label>Description</label><textarea name="description">{{ old('description', $edit->description ?? '') }}</textarea></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Workout Plan</button>
            @if($edit)<a class="btn" href="{{ route('workout-plans.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Workout Plans ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Plan</th><th>Goal</th><th>Level</th><th>Weeks</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->name }}</strong></td>
                    <td>{{ $r->goal }}</td>
                    <td><span class="badge">{{ $r->level }}</span></td>
                    <td>{{ $r->duration_weeks }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'workout-plans', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('workout-plans.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('workout-plans.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
