<?php

namespace App\Services;

use App\Models\MagicLoginToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

class MagicLinkService
{
    /**
     * Token lifetime in minutes.
     */
    protected const int TOKEN_EXPIRY_MINUTES = 15;

    /**
     * Generate a magic login link for the given user.
     *
     * Creates a cryptographically-secure 64-character token, persists it,
     * and returns the full login URL.
     */
    public function generateLoginLink(User $user): string
    {
        $token = Str::random(64);

        MagicLoginToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => now()->addMinutes(self::TOKEN_EXPIRY_MINUTES),
        ]);

        return route('magic-login.authenticate', ['token' => $token]);
    }

    /**
     * Look up a valid (not expired, not used) token record.
     *
     * Returns null when the token does not exist or is no longer valid.
     */
    public function validateToken(string $token): ?MagicLoginToken
    {
        return MagicLoginToken::where('token', $token)
            ->valid()
            ->with('user')
            ->first();
    }

    /**
     * Validate and consume a token in a single transaction.
     *
     * Marks the token as used, records the request IP, and returns
     * the associated user.
     *
     * @throws InvalidArgumentException When the token is invalid or expired.
     */
    public function consumeToken(string $token, Request $request): User
    {
        return DB::transaction(function () use ($token, $request): User {
            $magicToken = MagicLoginToken::where('token', $token)
                ->valid()
                ->lockForUpdate()
                ->with('user')
                ->first();

            if (! $magicToken) {
                throw new InvalidArgumentException('The login link is invalid or has expired.');
            }

            $magicToken->markAsUsed($request->ip());

            return $magicToken->user;
        });
    }

    /**
     * Delete every token belonging to the given user.
     */
    public function invalidateUserTokens(User $user): void
    {
        $user->magicLoginTokens()->delete();
    }

    /**
     * Purge all expired tokens from the database.
     *
     * @return int The number of tokens deleted.
     */
    public function purgeExpiredTokens(): int
    {
        return MagicLoginToken::where('expires_at', '<=', now())->delete();
    }
}
