<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\MagicLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// -------------------------------------------------------------------------
// Public / Guest Routes
// -------------------------------------------------------------------------

Route::middleware('guest')->group(function () {
    // Registration
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('register', [RegisterController::class, 'register'])
        ->middleware('throttle:5,1');

    // Login (Magic Link)
    Route::get('login', [MagicLoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('login', [MagicLoginController::class, 'sendMagicLink'])
        ->middleware('throttle:3,1')
        ->name('magic-login.send');

    // Magic link sent confirmation page
    Route::view('magic-link-sent', 'auth.magic-link-sent')
        ->name('magic-link-sent');
});

// Magic login token authentication (accessible regardless of auth state)
Route::get('magic-login/{token}', [MagicLoginController::class, 'authenticate'])
    ->name('magic-login.authenticate');

// Email verification (signed URL — accessible without full auth)
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');

// -------------------------------------------------------------------------
// Status Pages (authenticated but not necessarily approved)
// -------------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    // Email verification notice
    Route::get('email/verify', [VerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::post('email/resend', [VerificationController::class, 'resend'])
        ->middleware('throttle:1,1')
        ->name('verification.resend');

    // Status pages
    Route::view('pending-approval', 'auth.pending-approval')
        ->name('pending-approval');
    Route::view('account-rejected', 'auth.account-rejected')
        ->name('account-rejected');
    Route::view('account-suspended', 'auth.account-suspended')
        ->name('account-suspended');

    // Logout
    Route::post('logout', [LogoutController::class, 'logout'])
        ->name('logout');
});

// -------------------------------------------------------------------------
// Authenticated + Approved Routes
// -------------------------------------------------------------------------

Route::middleware(['auth', 'account.approved'])->group(function () {
    // Dashboard router
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // User dashboard (placeholder)
    Route::view('user/dashboard', 'user.dashboard')
        ->name('user.dashboard');
});

// -------------------------------------------------------------------------
// Admin Routes (authenticated + approved + role-gated)
// -------------------------------------------------------------------------

Route::middleware(['auth', 'account.approved', 'role:admin|super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('users', [UserApprovalController::class, 'index'])
            ->name('users.index');
        Route::get('users/{user}', [UserApprovalController::class, 'show'])
            ->name('users.show');
    });

// -------------------------------------------------------------------------
// Super Admin Routes (approve / reject)
// -------------------------------------------------------------------------

Route::middleware(['auth', 'account.approved', 'role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::post('users/{user}/approve', [UserApprovalController::class, 'approve'])
            ->name('users.approve');
        Route::post('users/{user}/reject', [UserApprovalController::class, 'reject'])
            ->name('users.reject');
    });
