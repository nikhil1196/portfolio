@extends('layouts.app')
@section('title', 'Plan Exercises')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Plan Exercise' : 'Add Plan Exercise' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('workout-items.update', $edit) : route('workout-items.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Workout Plan</label>
                    <select name="workout_plan_id"><option value="">— Select —</option>
                        @foreach($workout_plans as $id => $n)<option value="{{ $id }}" @selected(old('workout_plan_id', $edit->workout_plan_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Exercise</label>
                    <select name="exercise_id"><option value="">— Select —</option>
                        @foreach($exercises as $id => $n)<option value="{{ $id }}" @selected(old('exercise_id', $edit->exercise_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Day</label>
                    <select name="day">@foreach(array (
  0 => 'Day 1',
  1 => 'Day 2',
  2 => 'Day 3',
  3 => 'Day 4',
  4 => 'Day 5',
  5 => 'Day 6',
  6 => 'Day 7',
) as $s)<option @selected(old('day', $edit->day ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Sets</label><input type="number" name="sets" value="{{ old('sets', $edit->sets ?? '') }}"></div>
                <div class="form-row"><label>Reps</label><input type="number" name="reps" value="{{ old('reps', $edit->reps ?? '') }}"></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Plan Exercise</button>
            @if($edit)<a class="btn" href="{{ route('workout-items.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Plan Exercises ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Plan</th><th>Day</th><th>Exercise</th><th>Sets × Reps</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->workoutPlan->name ?? "—" }}</strong></td>
                    <td>{{ $r->day }}</td>
                    <td>{{ $r->exercise->name ?? "—" }}</td>
                    <td>{{ $r->sets }} × {{ $r->reps }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('workout-items.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('workout-items.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
