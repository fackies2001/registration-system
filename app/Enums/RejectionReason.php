<?php

namespace App\Enums;

enum RejectionReason: string
{
    case DUMMY_ACCOUNT = 'dummy_account';
    case BOT = 'bot_registration';
    case FAKE_EMAIL = 'fake_manipulated_email';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::DUMMY_ACCOUNT => 'Dummy/Fake Account',
            self::BOT => 'Bot Registration',
            self::FAKE_EMAIL => 'Fake or Manipulated Email Address',
            self::OTHER => 'Other',
        };
    }
}
