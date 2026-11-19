@extends('layouts.app')
@section('title', 'Member Plan Assignments')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Member Plan Assignment' : 'Add Member Plan Assignment' }}</h2>
        <form method="GET" style="display:flex;gap:8px;margin:12px 0">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…" style="max-width:240px">
            @if(str_contains('attendance',$module ?? ''))<input type="date" name="from" value="{{ request('from') }}"><input type="date" name="to" value="{{ request('to') }}">@endif
            <button class="btn">Search</button><a class="btn" href="{{ url()->current() }}">Reset</a>
            <a class="btn" href="{{ route('export.csv', 'member-workouts') }}" style="margin-left:auto">⬇ CSV</a>
        </form>
</div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('member-workouts.update', $edit) : route('member-workouts.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Member</label>
                    <select name="member_id"><option value="">— Select —</option>
                        @foreach($members as $id => $n)<option value="{{ $id }}" @selected(old('member_id', $edit->member_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Workout Plan</label>
                    <select name="workout_plan_id"><option value="">— Select —</option>
                        @foreach($workout_plans as $id => $n)<option value="{{ $id }}" @selected(old('workout_plan_id', $edit->workout_plan_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Start Date</label><input type="date" name="start_date" value="{{ old('start_date', $edit->start_date ?? '') }}" required></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Active',
  1 => 'Completed',
  2 => 'Paused',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Member Plan Assignment</button>
            @if($edit)<a class="btn" href="{{ route('member-workouts.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Member Plan Assignments ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Member</th><th>Plan</th><th>Started</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->member->name ?? "—" }}</strong></td>
                    <td>{{ $r->workoutPlan->name ?? "—" }}</td>
                    <td>{{ $r->start_date ? \Carbon\Carbon::parse($r->start_date)->format("d M Y") : "—" }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'member-workouts', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('member-workouts.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('member-workouts.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
