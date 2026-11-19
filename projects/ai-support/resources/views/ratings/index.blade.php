@extends('layouts.app')
@section('title', 'Satisfaction Ratings')
@section('content')
@php $edit = request('edit') ? $rows->firstWhere('id', request('edit')) : null; @endphp
<div class="card">
    <div class="card-head"><h2>{{ $edit ? 'Edit Satisfaction Rating' : 'Add Satisfaction Rating' }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('ratings.update', $edit) : route('ratings.store') }}">
            @csrf @if($edit) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-row"><label>Ticket</label>
                    <select name="ticket_id"><option value="">— Select —</option>
                        @foreach($support_tickets as $id => $n)<option value="{{ $id }}" @selected(old('ticket_id', $edit->ticket_id ?? '') == $id)>{{ $n }}</option>@endforeach
                    </select></div>
                <div class="form-row"><label>Score (1–5)</label>
                    <select name="score" required>@foreach(array (
  1 => '1 ★',
  2 => '2 ★',
  3 => '3 ★',
  4 => '4 ★',
  5 => '5 ★',
) as $k => $s)<option value="{{ $k }}" @selected((string)old('score', $edit->score ?? '') === (string)$k)>{{ $s }}</option>@endforeach</select></div>
                <div class="form-row"><label>Rated At</label><input type="datetime-local" name="rated_at" value="{{ old('rated_at', $edit->rated_at ?? '') }}" required></div>
                <div class="form-row"><label>Feedback</label><textarea name="feedback">{{ old('feedback', $edit->feedback ?? '') }}</textarea></div>
            </div>
            <button class="btn btn-acc" type="submit">{{ $edit ? 'Update' : 'Add' }} Satisfaction Rating</button>
            @if($edit)<a class="btn" href="{{ route('ratings.index') }}">Cancel</a>@endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>All Satisfaction Ratings ({{ $rows->count() }})</h2></div>
    <div class="card-body" style="padding:0">
        <div class="toolbar">
            <form method="GET">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search…">
                <button class="btn" type="submit">Search</button>
                <a class="btn" href="{{ url()->current() }}">Reset</a>
                <a class="btn" href="{{ route('export.csv', 'ratings') }}" style="margin-left:auto">⬇ CSV</a>
            </form>
        </div>
        <table class="tbl">
            <tr><th>Ticket</th><th>Score</th><th>Feedback</th><th>Rated</th><th></th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->ticket->subject }}</strong></td>
                    <td>{{ str_repeat("★", $r->score) }}</td>
                    <td>{{ Str::limit($r->feedback, 60) }}</td>
                    <td>{{ $r->rated_at }}</td>
                    <td>
                        <a class="btn btn-sm" href="{{ route('record.show', ['module' => 'ratings', 'id' => $r->id]) }}">View</a>
                        <a class="btn btn-sm" href="{{ route('ratings.index', ['edit' => $r->id]) }}">Edit</a>
                        <form method="POST" action="{{ route('ratings.destroy', $r) }}" class="inline" onsubmit="return confirm('Delete?')">
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
