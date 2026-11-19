<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') — Property Management</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>:root{--acc:#6c5ce7}</style>
</head>
<body class="admin">
<div class="shell">
    <aside class="sidebar">
        <a class="side-brand" href="{{ route('dashboard') }}">
            <span class="side-icon" style="background:#6c5ce7">▣</span>
            <span>Property Management</span>
        </a>
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">@include("partials.icon", ["i" => "home"])Dashboard</a>
            <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "building"])Properties</a>
            <a href="{{ route('tenants.index') }}" class="{{ request()->routeIs('tenants.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Tenants</a>
            <a href="{{ route('leases.index') }}" class="{{ request()->routeIs('leases.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "file"])Leases</a>
            <a href="{{ route('rents.index') }}" class="{{ request()->routeIs('rents.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "grid"])Rent</a>
            <a href="{{ route('requests.index') }}" class="{{ request()->routeIs('requests.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "alert"])Requests</a>
            <a href="{{ route('reports') }}" class="{{ request()->routeIs('reports') ? 'active' : '' }}">@include("partials.icon", ["i" => "chart"])Reports</a>
            <a href="{{ route('team.index') }}" class="{{ request()->routeIs('team.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Team</a>
            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "shield"])Roles</a>
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
