<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccountStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display the registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * Creates the user with pending_verification status, assigns the
     * default "user" role, and dispatches a queued verification email.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = DB::transaction(function () use ($request): User {
            $user = User::create([
                ...$request->validated(),
                'account_status' => AccountStatus::PENDING_VERIFICATION,
            ]);

            $user->assignRole('user');

            return $user;
        });

        $user->notify(new VerifyEmailNotification());

        return redirect()
            ->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }
}
