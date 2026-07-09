@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Overview of system registrations and activity</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        {{-- Total Users --}}
        <div class="stats-card stats-card-blue animate-slide-up">
            <div class="stats-card-icon">👥</div>
            <div class="stats-card-content">
                <div class="stats-number">{{ $totalUsers ?? 0 }}</div>
                <div class="stats-label">Total Users</div>
            </div>
        </div>

        {{-- Pending Approval --}}
        <div class="stats-card stats-card-yellow animate-slide-up delay-100">
            <div class="stats-card-icon">⏳</div>
            <div class="stats-card-content">
                <div class="stats-number">{{ $pendingCount ?? 0 }}</div>
                <div class="stats-label">Pending Approval</div>
            </div>
        </div>

        {{-- Approved --}}
        <div class="stats-card stats-card-green animate-slide-up delay-200">
            <div class="stats-card-icon">✅</div>
            <div class="stats-card-content">
                <div class="stats-number">{{ $approvedCount ?? 0 }}</div>
                <div class="stats-label">Approved</div>
            </div>
        </div>

        {{-- Rejected --}}
        <div class="stats-card stats-card-red animate-slide-up delay-300">
            <div class="stats-card-icon">🚫</div>
            <div class="stats-card-content">
                <div class="stats-number">{{ $rejectedCount ?? 0 }}</div>
                <div class="stats-label">Rejected</div>
            </div>
        </div>
    </div>

    {{-- Recent Registrations Table --}}
    <div class="card animate-slide-up delay-400">
        <div class="card-header flex items-center justify-between" style="flex-wrap: wrap; gap: var(--space-4);">
            <div>
                <h2 class="card-title">Recent Registrations</h2>
                <p class="card-subtitle">Latest 10 user registrations</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">
                View All Users →
            </a>
        </div>

        <div class="table-wrapper" style="border: none; box-shadow: none;">
            <table class="table">
                <thead>
                    <tr class="table-header">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organization</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers ?? [] as $user)
                        <tr class="table-row">
                            <td>
                                <div class="font-semi">{{ $user->full_name }}</div>
                            </td>
                            <td>
                                <span class="text-muted text-sm">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span class="text-sm">{{ $user->organization }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-badge-{{ $user->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-sm text-muted">{{ $user->created_at->format('M j, Y') }}</span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-ghost btn-sm">
                                        View
                                    </a>
                                    @if(auth()->user()->role === 'super_admin' && $user->status === 'pending_approval')
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this user?')">
                                                Approve
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="table-empty">
                                    <div class="table-empty-icon">📋</div>
                                    <div class="table-empty-title">No registrations yet</div>
                                    <p class="text-sm text-muted">New user registrations will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
