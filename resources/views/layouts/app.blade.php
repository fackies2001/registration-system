<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Registration System</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <span>🛡️</span> {{ config('app.name', 'Registration System') }}
            </a>
            
            <div class="navbar-nav">
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
                @endif
                
                <span class="nav-link" style="color: #94a3b8; cursor: default;">Welcome, {{ auth()->user()->full_name }}</span>
                
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.2); padding: 0.4rem 1rem;">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-error">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
