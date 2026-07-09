@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container" style="padding-top: 2rem;">
    <h1 style="margin-bottom: 1.5rem; color: var(--primary);">Admin Dashboard</h1>

    <div class="stats-grid">
        <div class="stats-card" style="border-top: 4px solid var(--accent);">
            <div class="stats-label">Total Users</div>
            <div class="stats-number">{{ $stats['total'] }}</div>
        </div>
        <div class="stats-card" style="border-top: 4px solid var(--warning);">
            <div class="stats-label">Pending Approval</div>
            <div class="stats-number">{{ $stats['pending'] }}</div>
        </div>
        <div class="stats-card" style="border-top: 4px solid var(--success);">
            <div class="stats-label">Approved Users</div>
            <div class="stats-number">{{ $stats['approved'] }}</div>
        </div>
        <div class="stats-card" style="border-top: 4px solid var(--danger);">
            <div class="stats-label">Rejected Registrations</div>
            <div class="stats-number">{{ $stats['rejected'] }}</div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; color: var(--primary);">Recent Registrations</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.875rem;">View All Users</a>
        </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organization</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                    <tr>
                        <td style="font-weight: 500;">{{ $user->full_name }}</td>
                        <td style="color: var(--text-muted);">{{ $user->email }}</td>
                        <td>{{ $user->organization }}</td>
                        <td>
                            <span class="badge badge-{{ $user->account_status->color() }}">
                                {{ $user->account_status->label() }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline" style="padding: 0.25rem 0.75rem; font-size: 0.75rem;">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            No recent registrations found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
