@extends('layouts.guest')

@section('title', 'Registration Rejected')

@section('content')
    <div class="guest-card">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="guest-logo">
            <span class="guest-logo-icon">RS</span>
            <span class="guest-logo-text">{{ config('app.name', 'Registration System') }}</span>
        </a>

        {{-- Warning Icon --}}
        <div class="state-icon state-icon-danger">
            ⚠️
        </div>

        {{-- Header --}}
        <h1 class="guest-title" style="color: var(--color-danger);">Account Registration Rejected</h1>

        {{-- Message --}}
        <p class="state-message">
            We're sorry, but your registration has been reviewed and was not approved by our administrators.
        </p>

        {{-- Rejection Reason --}}
        @if(session('rejection_reason'))
            <div class="card card-flat p-6 mb-6" style="background: rgba(var(--color-danger-rgb), 0.03); border-color: rgba(var(--color-danger-rgb), 0.12);">
                <div class="text-xs font-semi text-danger mb-2" style="text-transform: uppercase; letter-spacing: 0.04em;">
                    Reason for Rejection
                </div>
                <p class="text-sm" style="color: var(--color-text); line-height: 1.6;">
                    {{ session('rejection_reason') }}
                </p>
            </div>
        @endif

        {{-- Help Notice --}}
        <div class="card card-flat text-center p-6 mb-6" style="background: var(--color-background);">
            <p class="text-sm" style="color: var(--color-text); line-height: 1.6;">
                If you believe this is an error or would like to provide additional information,
                please contact our support team for further assistance.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col gap-3">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-block">
                Register Again
            </a>
            <a href="mailto:{{ config('mail.from.address', 'support@example.com') }}" class="btn btn-outline btn-lg btn-block">
                Contact Support
            </a>
        </div>

        {{-- Link --}}
        <div class="guest-links">
            <a href="{{ route('login') }}">← Back to Login</a>
        </div>
    </div>
@endsection
