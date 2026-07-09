@extends('layouts.guest')

@section('title', 'Registration Rejected')

@section('content')
<div style="text-align: center;">
    <div class="icon-large" style="color: var(--danger);">⚠️</div>
    
    <h1 style="color: var(--danger); margin-bottom: 1rem; font-size: 1.75rem;">Registration Rejected</h1>
    
    <p style="color: var(--text); margin-bottom: 1.5rem; font-size: 1.1rem; line-height: 1.6;">
        We regret to inform you that your registration could not be approved at this time.
    </p>

    @if(auth()->check() && auth()->user()->rejection_reason)
    <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: var(--radius-md); border: 1px solid #fecaca; text-align: left; margin-bottom: 2rem;">
        <div style="font-weight: 600; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Reason for rejection:</div>
        <div style="font-size: 1rem;">
            @php
                $reasonEnum = App\Enums\RejectionReason::tryFrom(auth()->user()->rejection_reason);
                echo $reasonEnum ? $reasonEnum->label() : htmlspecialchars(auth()->user()->rejection_reason);
            @endphp
        </div>
    </div>
    @endif

    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 2rem;">
        If you believe this is an error, please contact our support team.
    </p>

    <div style="display: flex; gap: 1rem; justify-content: center;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline">Back to Home</button>
        </form>
    </div>
</div>
@endsection
