@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container" style="padding-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 style="color: var(--primary);">User Management</h1>
    </div>

    <div class="card" style="padding: 1rem; margin-bottom: 1.5rem; background: var(--background);">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label class="form-label" style="margin-bottom: 0.25rem;">Search</label>
                <input type="text" name="search" class="form-input" placeholder="Name, email, or organization..." value="{{ request('search') }}">
            </div>
            <div style="min-width: 200px;">
                <label class="form-label" style="margin-bottom: 0.25rem;">Status Filter</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(App\Enums\AccountStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="margin-left: 0.5rem;">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card" style="padding: 0;">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Organization</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td style="font-weight: 500;">{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->organization }}<br><small style="color: var(--text-muted);">{{ $user->designation }}</small></td>
                        <td>{{ $user->country }}</td>
                        <td>
                            <span class="badge badge-{{ $user->account_status->color() }}">
                                {{ $user->account_status->label() }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.875rem;">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline" style="padding: 0.25rem 0.75rem; font-size: 0.75rem;">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <div class="icon-large" style="opacity: 0.2;">👥</div>
                            <p>No users found matching your criteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $users->links() }}
    </div>
</div>
@endsection
