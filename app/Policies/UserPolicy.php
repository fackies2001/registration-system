<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the list of users.
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can view a specific user's details.
     */
    public function view(User $authUser, User $model): bool
    {
        return $authUser->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can approve a registration.
     */
    public function approve(User $authUser, User $model): bool
    {
        return $authUser->hasRole('super_admin');
    }

    /**
     * Determine whether the user can reject a registration.
     */
    public function reject(User $authUser, User $model): bool
    {
        return $authUser->hasRole('super_admin');
    }
}
