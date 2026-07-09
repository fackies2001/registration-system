@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    {{-- Welcome Card --}}
    <div class="profile-header animate-slide-up">
        <div class="profile-header-content">
            <div class="flex items-center gap-4" style="flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <h1 class="profile-name" style="color: #fff;">Welcome back, {{ $user->full_name }}!</h1>
                    <p class="profile-org">{{ $user->designation }} at {{ $user->organization }}</p>
                </div>
                <span class="status-badge status-badge-{{ $user->status }}" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.2);">
                    {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Profile Information --}}
    <div class="card animate-slide-up delay-100">
        <div class="card-header">
            <h2 class="card-title">Profile Information</h2>
            <p class="card-subtitle">Your registered account details</p>
        </div>

        <div class="profile-detail-grid">
            <div class="profile-detail-item">
                <span class="profile-detail-label">👤 Full Name</span>
                <span class="profile-detail-value">{{ $user->full_name }}</span>
            </div>

            <div class="profile-detail-item">
                <span class="profile-detail-label">📧 Email Address</span>
                <span class="profile-detail-value">{{ $user->email }}</span>
            </div>

            <div class="profile-detail-item">
                <span class="profile-detail-label">🏢 Organization</span>
                <span class="profile-detail-value">{{ $user->organization }}</span>
            </div>

            <div class="profile-detail-item">
                <span class="profile-detail-label">💼 Designation</span>
                <span class="profile-detail-value">{{ $user->designation }}</span>
            </div>

            <div class="profile-detail-item">
                <span class="profile-detail-label">🌍 Country</span>
                <span class="profile-detail-value">{{ $user->country }}</span>
            </div>

            <div class="profile-detail-item">
                <span class="profile-detail-label">📞 Contact Number</span>
                <span class="profile-detail-value">{{ $user->contact_number }}</span>
            </div>

            <div class="profile-detail-item" style="grid-column: 1 / -1;">
                <span class="profile-detail-label">📍 Address</span>
                <span class="profile-detail-value">{{ $user->address }}</span>
            </div>
        </div>
    </div>

    {{-- Account Dates --}}
    <div class="card animate-slide-up delay-200 mt-6">
        <div class="card-header">
            <h2 class="card-title">Account Timeline</h2>
        </div>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot timeline-dot-completed"></div>
                <div class="timeline-title">Account Registered</div>
                <div class="timeline-date">{{ $user->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>

            @if($user->email_verified_at)
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-completed"></div>
                    <div class="timeline-title">Email Verified</div>
                    <div class="timeline-date">{{ $user->email_verified_at->format('F j, Y \a\t g:i A') }}</div>
                </div>
            @endif

            @if($user->approved_at)
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-completed"></div>
                    <div class="timeline-title">Account Approved</div>
                    <div class="timeline-date">{{ $user->approved_at->format('F j, Y \a\t g:i A') }}</div>
                </div>
            @elseif($user->status === 'rejected')
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-rejected"></div>
                    <div class="timeline-title">Account Rejected</div>
                    <div class="timeline-date">{{ $user->rejected_at ? $user->rejected_at->format('F j, Y \a\t g:i A') : 'Date not available' }}</div>
                </div>
            @elseif($user->status === 'pending_approval')
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-active"></div>
                    <div class="timeline-title">Awaiting Admin Approval</div>
                    <div class="timeline-date">In progress…</div>
                </div>
            @endif
        </div>
    </div>
@endsection
