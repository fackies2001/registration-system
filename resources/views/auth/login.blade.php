@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="auth-header">
    <h1>Welcome Back</h1>
    <p>Enter your email to receive a secure login link</p>
</div>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('magic-login.send') }}">
    @csrf

    <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input type="email" name="email" id="email" class="form-input @error('email') input-error @enderror" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group" style="margin-top: 2rem;">
        <button type="submit" class="btn btn-primary btn-block">Send Login Link</button>
    </div>
</form>

<div class="auth-footer">
    Don't have an account? <a href="{{ route('register') }}">Register</a>
</div>
@endsection
