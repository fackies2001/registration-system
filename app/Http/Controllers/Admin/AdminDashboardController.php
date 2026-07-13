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
            'total' => User::count(),
            'pending' => User::pendingApproval()->count(),
            'approved' => User::active()->count(),
            'rejected' => User::rejected()->count(),
        ];

        $recentUsers = User::query()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
