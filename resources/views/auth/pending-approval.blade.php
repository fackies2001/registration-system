@extends('layouts.guest')

@section('title', 'Pending Approval')

@section('content')
<div style="text-align: center;">
    <div class="icon-large" style="color: var(--warning); animation: pulse 2s infinite;">⏳</div>
    
    <h1 style="color: var(--primary); margin-bottom: 1rem; font-size: 1.75rem;">Awaiting Admin Approval</h1>
    
    <div class="alert alert-success" style="justify-content: center; margin-bottom: 2rem;">
        <span>✅</span> Your email has been verified successfully!
    </div>

    <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.6;">
        Your account is now being reviewed by our administrators. <br>
        You will receive an email containing a <strong>Certificate of Authorization</strong> and your <strong>Magic Login Link</strong> once your account has been approved.
    </p>

    <div style="background-color: var(--background); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border);">
        <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">
            No further action is required from you at this time. You may close this window.
        </p>
    </div>
</div>
@endsection
