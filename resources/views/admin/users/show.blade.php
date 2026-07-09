@extends('layouts.app')

@section('title', 'User Details: ' . $user->full_name)

@section('content')
<div class="container" style="padding-top: 2rem;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.users.index') }}" style="color: var(--text-muted); text-decoration: none;">&larr; Back to Users List</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 1.5rem;">
        <!-- Main Details Column -->
        <div>
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem;">
                    <div>
                        <h1 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $user->full_name }}</h1>
                        <p style="color: var(--text-muted);">ID: {{ $user->id }} &bull; Registered: {{ $user->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <span class="badge badge-{{ $user->account_status->color() }}" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                        {{ $user->account_status->label() }}
                    </span>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Email Address</div>
                        <div class="detail-value">
                            <a href="mailto:{{ $user->email }}" style="color: var(--accent); text-decoration: none;">{{ $user->email }}</a>
                            @if($user->email_verified_at)
                                <span class="badge badge-green" style="margin-left: 0.5rem; font-size: 0.65rem;">Verified</span>
                            @else
                                <span class="badge badge-yellow" style="margin-left: 0.5rem; font-size: 0.65rem;">Unverified</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Contact Number</div>
                        <div class="detail-value">{{ $user->contact_number }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Organization</div>
                        <div class="detail-value">{{ $user->organization }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Designation / Position</div>
                        <div class="detail-value">{{ $user->designation }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Country</div>
                        <div class="detail-value">{{ $user->country }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $user->address }}</div>
                    </div>
                </div>
            </div>

            @if($user->isRejected() && $user->rejection_reason)
            <div class="card" style="background-color: #fee2e2; border-color: #fecaca;">
                <h3 style="color: #991b1b; font-size: 1rem; margin-bottom: 0.5rem;">Rejection Details</h3>
                <p style="color: #7f1d1d; font-weight: 500;">
                    @php
                        $reasonEnum = App\Enums\RejectionReason::tryFrom($user->rejection_reason);
                        echo $reasonEnum ? $reasonEnum->label() : htmlspecialchars($user->rejection_reason);
                    @endphp
                </p>
            </div>
            @endif
        </div>

        <!-- Sidebar / Actions Column -->
        <div>
            @if(auth()->user()->hasRole('super_admin') && $user->isPendingApproval())
                <div class="card" style="border-top: 4px solid var(--accent);">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--primary);">Super Admin Actions</h3>
                    
                    <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.5rem;">
                        This user has verified their email and is waiting for your approval to access the system.
                    </p>

                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="margin-bottom: 1rem;" onsubmit="return confirm('Are you sure you want to approve this user? They will receive an email with their certificate and login link.');">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block" style="background-color: var(--success);">
                            ✅ Approve User Access
                        </button>
                    </form>

                    <hr style="border: 0; border-top: 1px solid var(--border); margin: 1.5rem 0;">

                    <form method="POST" action="{{ route('admin.users.reject', $user) }}" onsubmit="return confirm('Are you sure you want to reject this registration?');">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Reject Registration</label>
                            <select name="rejection_reason" class="form-select" required onchange="document.getElementById('custom_reason').style.display = this.value === 'other' ? 'block' : 'none'">
                                <option value="">Select Rejection Reason...</option>
                                @foreach(App\Enums\RejectionReason::cases() as $reason)
                                    <option value="{{ $reason->value }}">{{ $reason->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group" id="custom_reason" style="display: none;">
                            <textarea name="custom_rejection_reason" class="form-textarea" placeholder="Please specify the reason..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger btn-block">
                            ❌ Reject User
                        </button>
                    </form>
                </div>
            @endif

            <div class="card">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--primary);">Timeline</h3>
                
                <div style="position: relative; padding-left: 1.5rem; border-left: 2px solid var(--border);">
                    <div style="margin-bottom: 1.5rem; position: relative;">
                        <div style="position: absolute; left: -1.8rem; top: 0; width: 0.75rem; height: 0.75rem; border-radius: 50%; background: var(--border);"></div>
                        <div style="font-size: 0.875rem; font-weight: 500;">Registered</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $user->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem; position: relative;">
                        <div style="position: absolute; left: -1.8rem; top: 0; width: 0.75rem; height: 0.75rem; border-radius: 50%; background: {{ $user->email_verified_at ? 'var(--success)' : 'var(--border)' }};"></div>
                        <div style="font-size: 0.875rem; font-weight: 500;">Email Verified</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                            {{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y h:i A') : 'Pending' }}
                        </div>
                    </div>
                    
                    @if($user->isActive() || $user->isRejected())
                    <div style="position: relative;">
                        <div style="position: absolute; left: -1.8rem; top: 0; width: 0.75rem; height: 0.75rem; border-radius: 50%; background: {{ $user->isActive() ? 'var(--success)' : 'var(--danger)' }};"></div>
                        <div style="font-size: 0.875rem; font-weight: 500;">{{ $user->isActive() ? 'Approved' : 'Rejected' }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                            {{ $user->isActive() ? $user->approved_at->format('M d, Y h:i A') : 'Processed' }}
                            @if($user->approvedBy)
                                by {{ $user->approvedBy->full_name }}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
