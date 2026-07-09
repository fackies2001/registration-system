@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<div style="text-align: center;">
    <div class="icon-large" style="color: var(--accent);">📧</div>
    
    <h1 style="color: var(--primary); margin-bottom: 1rem; font-size: 1.75rem;">Check Your Email</h1>
    
    <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.6;">
        We've sent a verification link to your email address.<br>
        Please click the link to verify your account.
    </p>

    @if (session('message'))
        <div class="alert alert-success" style="justify-content: center; margin-bottom: 2rem;">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
    
    <p style="color: var(--text-muted); font-size: 0.875rem; margin-top: 1rem;">
        Please check your spam folder if you don't see it.
    </p>
</div>
@endsection
