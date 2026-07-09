@extends('layouts.guest')

@section('title', 'Login Link Sent')

@section('content')
<div style="text-align: center;">
    <div class="icon-large" style="color: var(--success);">✅</div>
    
    <h1 style="color: var(--primary); margin-bottom: 1rem; font-size: 1.75rem;">Login Link Sent!</h1>
    
    <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.6;">
        We've sent a secure magic login link to your email address.<br>
        Click the link to securely access your dashboard.
    </p>

    <div style="background-color: #fef3c7; color: #92400e; padding: 1rem; border-radius: var(--radius-md); border: 1px solid #fde68a; font-size: 0.875rem; margin-bottom: 2rem;">
        <strong>Note:</strong> This link will expire in 15 minutes for security reasons.
    </div>

    <div class="auth-footer">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>
</div>
@endsection
