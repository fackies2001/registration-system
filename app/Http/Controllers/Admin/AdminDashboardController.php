<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AccountStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with user statistics and recent registrations.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'pending_approval' => User::pendingApproval()->count(),
            'active' => User::active()->count(),
            'rejected' => User::rejected()->count(),
        ];

        $recentRegistrations = User::query()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations'));
    }
}
