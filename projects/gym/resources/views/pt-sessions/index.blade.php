@extends('layouts.app')
@section('title', 'PT Sessions')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit PT Session' : 'Add PT Session' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('pt-sessions.update', $edit) : route('pt-sessions.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Member</label>
                    <select name="member_id"><option value="">— Select —</option>
                        @foreach($members as $id => $n)<option value="{{ $id }}" @selected(old('member_id', $edit->member_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Coach</label>
                    <select name="trainer_id"><option value="">— Select —</option>
                        @foreach($trainers as $id => $n)<option value="{{ $id }}" @selected(old('trainer_id', $edit->trainer_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Date</label><input type="date" name="session_date" value="{{ old('session_date', $edit->session_date ?? '') }}" required></div>
                <div class="form-row"><label>Time</label><input type="time" name="start_time" value="{{ old('start_time', $edit->start_time ?? '') }}"></div>
                <div class="form-row"><label>Duration (min)</label><input type="number" name="duration_min" value="{{ old('duration_min', $edit->duration_min ?? '') }}"></div>
                <div class="form-row"><label>Focus Area</label><input type="text" name="focus" value="{{ old('focus', $edit->focus ?? '') }}"></div>
                <div class="form-row"><label>Status</label>
                    <select name="status">@foreach(array (
  0 => 'Scheduled',
  1 => 'Completed',
  2 => 'Cancelled',
) as $s)<option @selected(old('status', $edit->status ?? '') === $s)>{{ $s }}</option>@endforeach</select></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} PT Session</button>
            @if($edit)<a class="btn" href="{{ route('pt-sessions.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All PT Sessions ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Member</th><th>Coach</th><th>When</th><th>Duration</th><th>Focus</th><th>Status</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->member->name ?? "—" }}</strong></td>
                    <td>{{ $r->trainer->name ?? "—" }}</td>
                    <td>{{ $r->session_date }} {{ $r->start_time }}</td>
                    <td>{{ $r->duration_min }} min</td>
                    <td>{{ $r->focus }}</td>
                    <td><span class="badge">{{ $r->status }}</span></td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('pt-sessions.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('pt-sessions.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-danger" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No records yet</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
