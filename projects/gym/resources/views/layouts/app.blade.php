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
            <a href="{{ route('dashboard') }}"        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="ni">⌂</span>Dashboard</a>
            <a href="{{ route('members.index') }}"    class="{{ request()->routeIs('members.*') ? 'active' : '' }}"><span class="ni">◉</span>Members</a>
            <a href="{{ route('plans.index') }}"      class="{{ request()->routeIs('plans.*') ? 'active' : '' }}"><span class="ni">▤</span>Plans</a>
            <a href="{{ route('trainers.index') }}"   class="{{ request()->routeIs('trainers.*') ? 'active' : '' }}"><span class="ni">✦</span>Trainers</a>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}"><span class="ni">✓</span>Attendance</a>
            <a href="{{ route('payments.index') }}"   class="{{ request()->routeIs('payments.*') ? 'active' : '' }}"><span class="ni">₹</span>Payments</a>
        </nav>
        <div class="side-foot"><a href="{{ url('/../') }}" class="side-back">← Back to Portfolio</a></div>
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
</body>
</html>
