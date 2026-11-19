<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login — Event Booking Platform</title>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="login-page">
<div class="login-card">
    <div class="login-ico" style="background:#fd79a8">★</div>
    <h1>Event Booking Platform</h1>
    <p class="login-sub">Sign in to the admin panel</p>
    @if($errors->any())<div class="alert alert-err">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div class="form-row"><label>Email</label>
            <input type="email" name="email" value="{{ old('email', 'admin@demo.local') }}" required autofocus>
        </div>
        <div class="form-row"><label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button class="btn btn-acc btn-block" type="submit">Login</button>
    </form>
    <p class="note" style="margin-top:1rem;text-align:center">Demo: admin@demo.local / admin123</p>
</div>
</body>
</html>
