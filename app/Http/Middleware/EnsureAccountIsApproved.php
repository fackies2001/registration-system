<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsApproved
{
    /**
     * Handle an incoming request.
     *
     * Redirects users to the appropriate status page unless their
     * account is fully active.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        return match ($user->account_status) {
            AccountStatus::PENDING_VERIFICATION => redirect()->route('verification.notice'),
            AccountStatus::PENDING_APPROVAL     => redirect()->route('pending-approval'),
            AccountStatus::REJECTED             => redirect()->route('account-rejected'),
            AccountStatus::SUSPENDED            => redirect()->route('account-suspended'),
            AccountStatus::ACTIVE               => $next($request),
        };
    }
}
