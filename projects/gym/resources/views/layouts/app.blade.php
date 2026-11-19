<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') — Gym Management SaaS</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>:root{--acc:#6c5ce7}</style>
</head>
<body class="admin">
<div class="shell">
    <aside class="sidebar">
        <a class="side-brand" href="{{ route('dashboard') }}">
            <span class="side-icon" style="background:#6c5ce7">⬢</span>
            <span>Gym SaaS</span>
        </a>
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}"        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">@include("partials.icon", ["i" => "home"])Dashboard</a>
            <a href="{{ route('members.index') }}"    class="{{ request()->routeIs('members.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Members</a>
            <a href="{{ route('plans.index') }}"      class="{{ request()->routeIs('plans.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "layers"])Plans</a>
            <a href="{{ route('trainers.index') }}"   class="{{ request()->routeIs('trainers.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "activity"])Trainers</a>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "check"])Attendance</a>
            <a href="{{ route('payments.index') }}"   class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "money"])Payments</a>
            <a href="{{ route('reports') }}" class="{{ request()->routeIs('reports') ? 'active' : '' }}">@include("partials.icon", ["i" => "chart"])Reports</a>
            <a href="{{ route('team.index') }}" class="{{ request()->routeIs('team.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Team</a>
            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "shield"])Roles</a>
            <a href="{{ route('exercises.index') }}" class="{{ request()->routeIs('exercises.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "activity"])Exercises</a>
            <a href="{{ route('workout-plans.index') }}" class="{{ request()->routeIs('workout-plans.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "clipboard"])Workout Plans</a>
            <a href="{{ route('member-workouts.index') }}" class="{{ request()->routeIs('member-workouts.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "target"])Member Plans</a>
            <a href="{{ route('measurements.index') }}" class="{{ request()->routeIs('measurements.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "ruler"])Measurements</a>
            <a href="{{ route('pt-sessions.index') }}" class="{{ request()->routeIs('pt-sessions.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "clock"])PT Sessions</a>
            <a href="{{ route('gym-classes.index') }}" class="{{ request()->routeIs('gym-classes.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "grid"])Classes</a>
            <a href="{{ route('class-bookings.index') }}" class="{{ request()->routeIs('class-bookings.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "calendar"])Bookings</a>
            <a href="{{ route('audit.index') }}" class="{{ request()->routeIs('audit.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "clipboard"])Audit Log</a>
        </nav>
        <div class="side-foot"><a href="{{ env('PORTFOLIO_URL', 'http://localhost/portfolio/') }}" class="side-back">← Back to Portfolio</a></div>
    </aside>
    <div class="main">
        <header class="topbar">
            <h1>@yield('title')</h1>
            <div class="topbar-right">
                <span class="topbar-user">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button class="btn btn-sm" type="submit">Logout</button></form>
            </div>
        </header>
        <main class="content">
            @if(session('ok'))<div class="alert alert-ok">{{ session('ok') }}</div>@endif
            @if($errors->any())<div class="alert alert-err">{{ $errors->first() }}</div>@endif
            @yield('content')
        </main>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
