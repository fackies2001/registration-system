@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="container" style="padding-top: 2rem;">
    <div style="background: var(--gradient); color: white; border-radius: var(--radius-lg); padding: 2.5rem; margin-bottom: 2rem; box-shadow: var(--shadow-md);">
        <h1 style="margin-bottom: 0.5rem; font-size: 2rem;">Welcome back, {{ auth()->user()->full_name }}!</h1>
        <p style="opacity: 0.9;">Your account is fully active and you have access to the system.</p>
    </div>

    <div class="card">
        <div class="form-section-title" style="margin-top: 0;">
            <span>👤</span> Profile Information
        </div>
        
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="badge badge-green">Active</span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Email Address</div>
                <div class="detail-value">{{ auth()->user()->email }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Organization</div>
                <div class="detail-value">{{ auth()->user()->organization }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Designation</div>
                <div class="detail-value">{{ auth()->user()->designation }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Country</div>
                <div class="detail-value">{{ auth()->user()->country }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Contact Number</div>
                <div class="detail-value">{{ auth()->user()->contact_number }}</div>
            </div>
        </div>
        
        <div class="detail-item" style="margin-top: 1rem;">
            <div class="detail-label">Address</div>
            <div class="detail-value">{{ auth()->user()->address }}</div>
        </div>
        
        <hr style="border: 0; border-top: 1px solid var(--border); margin: 1.5rem 0;">
        
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Registered Date</div>
                <div class="detail-value">{{ auth()->user()->created_at->format('M d, Y h:i A') }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Approved Date</div>
                <div class="detail-value">{{ auth()->user()->approved_at ? auth()->user()->approved_at->format('M d, Y h:i A') : 'N/A' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
