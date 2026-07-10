<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Registration System</title>
    @vite(['resources/css/app.css'])
    
    @yield('head')
</head>
<body>
    <div class="auth-page" style="background: url('{{ asset('storage/asean-bg.png') }}') no-repeat center center fixed; background-size: cover;">
        <div class="auth-card">
            @yield('content')
        </div>
        
        <div class="auth-footer" style="color: rgba(255,255,255,0.7); margin-top: 2rem; position: relative; z-index: 1;">
            &copy; {{ date('Y') }} {{ config('app.name', 'Registration System') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
