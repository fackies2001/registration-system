<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AccountStatus;
use App\Enums\RejectionReason;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountRejectedNotification;
use App\Notifications\ApprovalCertificateNotification;
use App\Notifications\ApprovalLoginLinkNotification;
use App\Services\MagicLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserApprovalController extends Controller
{
    public function __construct(
        protected MagicLinkService $magicLinkService,
    ) {}

    /**
     * List all users with optional filtering by status and search query.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('status')) {
            $status = AccountStatus::tryFrom($request->input('status'));
            if ($status) {
                $query->where('account_status', $status);
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('organization', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a single user's detail.
     */
    public function show(User $user): View
    {
        $user->load('approvedBy');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Approve a user's registration.
     *
     * Transitions the user to active, generates a certificate token,
     * and sends both the certificate and a magic login link.
     */
    public function approve(User $user): RedirectResponse
    {
        $this->authorize('approve', $user);

        $user->update([
            'account_status' => AccountStatus::ACTIVE,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'approval_certificate_token' => Str::uuid()->toString(),
        ]);

        // Send certificate notification
        $user->notify(new ApprovalCertificateNotification());

        // Generate and send a magic login link so the user can access the system
        $loginUrl = $this->magicLinkService->generateLoginLink($user);
        $user->notify(new ApprovalLoginLinkNotification($loginUrl));

        return redirect()
            ->back()
            ->with('success', "User {$user->full_name} has been approved successfully.");
    }

    /**
     * Reject a user's registration.
     *
     * Validates the rejection reason (either a known enum value or custom text),
     * transitions the user to rejected, and sends a notification.
     */
    public function reject(Request $request, User $user): RedirectResponse
    {
        $this->authorize('reject', $user);

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
            'custom_reason' => ['nullable', 'required_if:rejection_reason,other', 'string', 'max:1000'],
        ]);

        // Determine the display reason — use the enum label or custom text
        $enumReason = RejectionReason::tryFrom($validated['rejection_reason']);
        $displayReason = $enumReason && $enumReason !== RejectionReason::OTHER
            ? $enumReason->label()
            : ($validated['custom_reason'] ?? $validated['rejection_reason']);

        $user->update([
            'account_status' => AccountStatus::REJECTED,
            'rejection_reason' => $displayReason,
        ]);

        $user->notify(new AccountRejectedNotification($displayReason));

        return redirect()
            ->back()
            ->with('success', "User {$user->full_name} has been rejected.");
    }
}
