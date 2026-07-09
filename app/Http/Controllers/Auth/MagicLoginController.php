<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\MagicLoginNotification;
use App\Services\MagicLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use InvalidArgumentException;

class MagicLoginController extends Controller
{
    public function __construct(
        protected MagicLinkService $magicLinkService,
    ) {}

    /**
     * Display the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Send a magic login link to the user's email.
     *
     * Only active users receive a link; the generic success message is
     * shown regardless to prevent user enumeration.
     */
    public function sendMagicLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user && $user->isActive()) {
            $loginUrl = $this->magicLinkService->generateLoginLink($user);
            $user->notify(new MagicLoginNotification($loginUrl));
        }

        // Always show the same message to prevent user enumeration
        return redirect()
            ->route('magic-link-sent')
            ->with('success', 'If an active account exists for that email, a login link has been sent.');
    }

    /**
     * Authenticate the user via a magic login token.
     */
    public function authenticate(Request $request, string $token): RedirectResponse
    {
        try {
            $user = $this->magicLinkService->consumeToken($token, $request);

            Auth::login($user, remember: true);

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        } catch (InvalidArgumentException) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'The login link is invalid or has expired. Please request a new one.']);
        }
    }
}
