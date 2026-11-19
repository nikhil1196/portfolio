<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') — School ERP</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>:root{--acc:#0984e3}</style>
</head>
<body class="admin">
<div class="shell">
    <aside class="sidebar">
        <a class="side-brand" href="{{ route('dashboard') }}">
            <span class="side-icon" style="background:#0984e3">✎</span>
            <span>School ERP</span>
        </a>
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">@include("partials.icon", ["i" => "home"])Dashboard</a>
            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Students</a>
            <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "user"])Teachers</a>
            <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "grid"])Classes</a>
            <a href="{{ route('fees.index') }}" class="{{ request()->routeIs('fees.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "money"])Fees</a>
            <a href="{{ route('results.index') }}" class="{{ request()->routeIs('results.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "star"])Results</a>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "check"])Attendance</a>
            <a href="{{ route('notices.index') }}" class="{{ request()->routeIs('notices.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "flag"])Notices</a>
            <a href="{{ route('reports') }}" class="{{ request()->routeIs('reports') ? 'active' : '' }}">@include("partials.icon", ["i" => "chart"])Reports</a>
            <a href="{{ route('team.index') }}" class="{{ request()->routeIs('team.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "users"])Team</a>
            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "shield"])Roles</a>
            <a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "book"])Subjects</a>
            <a href="{{ route('staff.index') }}" class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "briefcase"])Staff</a>
            <a href="{{ route('timetable.index') }}" class="{{ request()->routeIs('timetable.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "calendar"])Timetable</a>
            <a href="{{ route('materials.index') }}" class="{{ request()->routeIs('materials.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "clipboard"])Materials</a>
            <a href="{{ route('assignments.index') }}" class="{{ request()->routeIs('assignments.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "clipboard"])Assignments</a>
            <a href="{{ route('submissions.index') }}" class="{{ request()->routeIs('submissions.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "check"])Submissions</a>
            <a href="{{ route('exams.index') }}" class="{{ request()->routeIs('exams.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "star"])Exams</a>
            <a href="{{ route('fee-structures.index') }}" class="{{ request()->routeIs('fee-structures.*') ? 'active' : '' }}">@include("partials.icon", ["i" => "money"])Fee Structure</a>
            <a href="{{ route('reports.attendance') }}" class="{{ request()->routeIs('reports.attendance') ? 'active' : '' }}">@include("partials.icon", ["i" => "chart"])Att. Report</a>
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
