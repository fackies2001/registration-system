<?php

namespace App\Models;

use App\Enums\AccountStatus;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['salutation', 'first_name', 'middle_name', 'last_name', 'suffix', 'sex', 'nationality', 'place_of_birth', 'date_of_birth', 'participant_type', 'ministry_agency', 'office_subunit', 'email', 'organization', 'designation', 'address', 'contact_number', 'meeting_link', 'approval_note'])]
#[Hidden(['remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'account_status' => AccountStatus::class,
            'approved_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->suffix,
        ])));
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * The admin who approved this user.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Magic login tokens belonging to this user.
     */
    public function magicLoginTokens(): HasMany
    {
        return $this->hasMany(MagicLoginToken::class);
    }

    // -------------------------------------------------------------------------
    // Status helpers
    // -------------------------------------------------------------------------

    public function isActive(): bool
    {
        return $this->account_status === AccountStatus::ACTIVE;
    }

    public function isPendingApproval(): bool
    {
        return $this->account_status === AccountStatus::PENDING_APPROVAL;
    }

    public function isPendingVerification(): bool
    {
        return $this->account_status === AccountStatus::PENDING_VERIFICATION;
    }

    public function isRejected(): bool
    {
        return $this->account_status === AccountStatus::REJECTED;
    }

    public function isSuspended(): bool
    {
        return $this->account_status === AccountStatus::SUSPENDED;
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Scope to users pending admin approval.
     */
    public function scopePendingApproval(Builder $query): Builder
    {
        return $query->where('account_status', AccountStatus::PENDING_APPROVAL);
    }

    /**
     * Scope to active users.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('account_status', AccountStatus::ACTIVE);
    }

    /**
     * Scope to rejected users.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('account_status', AccountStatus::REJECTED);
    }

    // -------------------------------------------------------------------------
    // Certificate
    // -------------------------------------------------------------------------

    /**
     * Get a signed URL for the user's approval certificate.
     */
    public function getApprovalCertificateUrl(): string
    {
        return URL::signedRoute('certificate.show', [
            'user' => $this->id,
            'token' => $this->approval_certificate_token,
        ]);
    }
}
