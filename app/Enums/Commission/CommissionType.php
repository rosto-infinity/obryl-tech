<?php

namespace App\Enums\Commission;

enum CommissionType: string
{
    case PROJECT_COMPLETION = 'project_completion';
    case MILESTONE = 'milestone';
    case REFERRAL = 'referral';
    case BONUS = 'bonus';

    public function label(): string
    {
        return match($this) {
            self::PROJECT_COMPLETION => 'Complément de projet',
            self::MILESTONE => 'Jalon',
            self::REFERRAL => 'Parrainage',
            self::BONUS => 'Bonus',
        };
    }
}
