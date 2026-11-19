@extends('layouts.app')
@section('title', 'Attendance')
@section('content')
<div class="card">
    <div class="card-head"><h2>Member Check-in</h2>
        </div>
    <div class="card-body">
        <form method="POST" action="{{ route('attendance.checkin') }}" class="toolbar">
            @csrf
            <select name="member_id" required>
                <option value="">— Select member —</option>
                @foreach($members as $id => $name)<option value="{{ $id }}">{{ $name }}</option>@endforeach
            </select>
            <button class="btn btn-acc" type="submit">Check In</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Attendance Log</h2></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Member</th><th>Check In</th><th>Check Out</th><th>Status</th><th></th></tr>
            @forelse($log as $a)
                <tr>
                    <td><strong>{{ $a->member->name }}</strong></td>
                    <td>{{ $a->check_in->format('d M, h:i A') }}</td>
                    <td>{{ $a->check_out ? $a->check_out->format('d M, h:i A') : '—' }}</td>
                    <td><span class="badge">{{ $a->check_out ? 'Completed' : 'Present' }}</span></td>
                    <td>
                        @unless($a->check_out)
                            <form method="POST" action="{{ route('attendance.checkout', $a) }}" class="inline">
                                @csrf<button class="btn btn-sm" type="submit">Check Out</button>
                            </form>
                        @endunless
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No attendance records</td></tr>
            @endforelse
        </table>
        {{ $log->links() }}
    </div>
</div>
@endsection
