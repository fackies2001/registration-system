<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccountStatus;
use App\Events\UserEmailVerified;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice(): View
    {
        return view('auth.verify-email');
    }

    /**
     * Handle an email verification link click.
     *
     * Validates the signed URL, marks the email as verified,
     * transitions the account to pending_approval, and fires the event.
     */
    public function verify(Request $request, int $id, string $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403, 'Invalid verification link.');
        }

        if (! $request->hasValidSignature()) {
            abort(403, 'This verification link has expired.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            $user->update([
                'account_status' => AccountStatus::PENDING_APPROVAL,
            ]);

            $user->notify(new \App\Notifications\PendingRegistrationNotification());

            event(new UserEmailVerified($user));
        }

        return redirect()
            ->route('pending-approval')
            ->with('success', 'Your email has been verified! Your account is now pending admin approval.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('pending-approval');
        }

        $user->notify(new VerifyEmailNotification());

        return back()->with('success', 'A new verification link has been sent to your email address.');
    }
}
