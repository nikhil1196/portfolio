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
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">@include("partials.icon", ["i" => "home"])Dashboard</a>
            <a href="{{ route('units.index') }}" class="{{ request()->routeIs('units.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "building"])Units</a>
            <a href="{{ route('residents.index') }}" class="{{ request()->routeIs('residents.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Residents</a>
            <a href="{{ route('maintenance.index') }}" class="{{ request()->routeIs('maintenance.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "money"])Maintenance</a>
            <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "alert"])Complaints</a>
            <a href="{{ route('notices.index') }}" class="{{ request()->routeIs('notices.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "flag"])Notices</a>
            <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "clipboard"])Bookings</a>
            <a href="{{ route('reports') }}" class="{{ request()->routeIs('reports') ? 'active' : '' }}">@include("partials.icon", ["i" => "chart"])Reports</a>
            <a href="{{ route('team.index') }}" class="{{ request()->routeIs('team.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Team</a>
            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "shield"])Roles</a>
            <a href="{{ route('receipts.index') }}" class="{{ request()->routeIs('receipts.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "receipt"])Receipts</a>
            <a href="{{ route('visitors.index') }}" class="{{ request()->routeIs('visitors.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "user"])Visitors</a>
            <a href="{{ route('staff.index') }}" class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "briefcase"])Staff & Vendors</a>
            <a href="{{ route('parking.index') }}" class="{{ request()->routeIs('parking.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "grid"])Parking</a>
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
