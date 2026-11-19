@extends('layouts.app')
@section('title', 'Check-in')
@section('content')
<div class="card" style="max-width:520px">
    <div class="card-head"><h2>🎫 Attendee Check-in</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('checkin.scan') }}">
            @csrf
            <div class="form-row"><label>Check-in Code</label>
                <input type="text" name="code" autofocus required placeholder="e.g. AB12CD34" style="font-family:monospace;text-transform:uppercase"></div>
            <button class="btn btn-primary">Check In</button>
        </form>
        @if($result)
            @if($result['ok'])
            <div class="alert alert-ok" style="margin-top:14px">✓ <strong>{{ $result['name'] }}</strong> checked in{{ $result['event'] ? ' — ' . $result['event'] : '' }}</div>
            @else
            <div class="alert alert-err" style="margin-top:14px">✗ {{ $result['msg'] }}</div>
            @endif
        @endif
    </div>
</div>
@endsection