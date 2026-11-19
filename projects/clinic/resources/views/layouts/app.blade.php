<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') — Clinic Management System</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>:root{--acc:#00b894}</style>
</head>
<body class="admin">
<div class="shell">
    <aside class="sidebar">
        <a class="side-brand" href="{{ route('dashboard') }}">
            <span class="side-icon" style="background:#00b894">✚</span>
            <span>Clinic Management System</span>
        </a>
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="ni">⌂</span>Dashboard</a>
            <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.*') ? 'active' : '' }}"><span class="ni">◉</span>Patients</a>
            <a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.*') ? 'active' : '' }}"><span class="ni">✚</span>Doctors</a>
            <a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}"><span class="ni">▤</span>Appointments</a>
            <a href="{{ route('prescriptions.index') }}" class="{{ request()->routeIs('prescriptions.*') ? 'active' : '' }}"><span class="ni">℞</span>Prescriptions</a>
            <a href="{{ route('bills.index') }}" class="{{ request()->routeIs('bills.*') ? 'active' : '' }}"><span class="ni">₹</span>Bills</a>
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
