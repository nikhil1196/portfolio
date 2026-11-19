<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') — Society Management</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>:root{--acc:#e17055}</style>
</head>
<body class="admin">
<div class="shell">
    <aside class="sidebar">
        <a class="side-brand" href="{{ route('dashboard') }}">
            <span class="side-icon" style="background:#e17055">⌂</span>
            <span>Society Management</span>
        </a>
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="ni">⌂</span>Dashboard</a>
            <a href="{{ route('units.index') }}" class="{{ request()->routeIs('units.*') ? 'active' : '' }}"><span class="ni">▦</span>Units</a>
            <a href="{{ route('residents.index') }}" class="{{ request()->routeIs('residents.*') ? 'active' : '' }}"><span class="ni">◉</span>Residents</a>
            <a href="{{ route('maintenance.index') }}" class="{{ request()->routeIs('maintenance.*') ? 'active' : '' }}"><span class="ni">₹</span>Maintenance</a>
            <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}"><span class="ni">✉</span>Complaints</a>
            <a href="{{ route('notices.index') }}" class="{{ request()->routeIs('notices.*') ? 'active' : '' }}"><span class="ni">⚑</span>Notices</a>
            <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}"><span class="ni">▤</span>Bookings</a>
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
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
