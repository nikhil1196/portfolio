<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') — Restaurant POS + KDS</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>:root{--acc:#d63031}</style>
</head>
<body class="admin">
<div class="shell">
    <aside class="sidebar">
        <a class="side-brand" href="{{ route('dashboard') }}">
            <span class="side-icon" style="background:#d63031">♨</span>
            <span>Restaurant POS + KDS</span>
        </a>
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">@include("partials.icon", ["i" => "home"])Dashboard</a>
            <a href="{{ route('pos') }}" class="{{ request()->routeIs('pos') ? 'active' : '' }}">@include("partials.icon", ["i" => "grid"])New Order</a>
            <a href="{{ route('kitchen') }}" class="{{ request()->routeIs('kitchen') ? 'active' : '' }}">@include("partials.icon", ["i" => "flame"])Kitchen</a>
            <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "receipt"])Orders</a>
            <a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "book"])Menu</a>
            <a href="{{ route('tables.index') }}" class="{{ request()->routeIs('tables.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "grid"])Tables</a>
            <a href="{{ route('reports') }}" class="{{ request()->routeIs('reports') ? 'active' : '' }}">@include("partials.icon", ["i" => "chart"])Reports</a>
            <a href="{{ route('team.index') }}" class="{{ request()->routeIs('team.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Team</a>
            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "shield"])Roles</a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "grid"])Categories</a>
            <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "calendar"])Reservations</a>
            <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "clipboard"])Inventory</a>
            <a href="{{ route('movements.index') }}" class="{{ request()->routeIs('movements.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "refresh"])Stock Log</a>
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
