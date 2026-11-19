@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="stats-row">
    <div class="stat-card"><div class="stat-label">Events</div><div class="stat-value">{{ $stats['Events'] }}</div><div class="stat-sub">Event::where('status','Published')->count()</div></div>
    <div class="stat-card"><div class="stat-label">Bookings</div><div class="stat-value">{{ $stats['Bookings'] }}</div><div class="stat-sub">Booking::where('status','Confirmed')->count()</div></div>
    <div class="stat-card"><div class="stat-label">Seats Sold</div><div class="stat-value">{{ $stats['Seats Sold'] }}</div><div class="stat-sub">Booking::where('status','Confirmed')->sum('seats')</div></div>
    <div class="stat-card"><div class="stat-label">Revenue</div><div class="stat-value">{{ $stats['Revenue'] }}</div><div class="stat-sub">'₹'.number_format(Booking::where('status','Confirmed')->sum('amount'))</div></div>
</div>
<div class="card">
    <div class="card-head"><h2>Upcoming Events</h2><a class="btn btn-sm" href="{{ route('events.index') }}">All</a></div>
    <div class="card-body" style="padding:0">
        <table class="tbl">
            <tr><th>Event</th><th>Venue</th><th>Date</th><th>Price</th><th>Capacity</th></tr>
            @forelse($rows as $r)
                <tr>
                    <td><strong>{{ $r->title }}</strong></td>
                    <td>{{ $r->venue }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->event_date)->format('d M Y') }}</td>
                    <td>{{ $r->price ? "₹".number_format($r->price) : "Free" }}</td>
                    <td>{{ $r->capacity }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No upcoming events</td></tr>
            @endforelse
        </table>
    </div>
</div>
@endsection
