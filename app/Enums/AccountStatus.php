<?php

namespace App\Enums;

enum AccountStatus: string
{
    case PENDING_VERIFICATION = 'pending_verification';
    case PENDING_APPROVAL = 'pending_approval';
    case ACTIVE = 'active';
    case REJECTED = 'rejected';
    case SUSPENDED = 'suspended';

    public function label(): string
    {
        return match($this) {
            self::PENDING_VERIFICATION => 'Pending Verification',
            self::PENDING_APPROVAL => 'Pending Approval',
            self::ACTIVE => 'Active',
            self::REJECTED => 'Rejected',
            self::SUSPENDED => 'Suspended',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING_VERIFICATION => 'yellow',
            self::PENDING_APPROVAL => 'orange',
            self::ACTIVE => 'green',
            self::REJECTED => 'red',
            self::SUSPENDED => 'gray',
        };
    }
}
