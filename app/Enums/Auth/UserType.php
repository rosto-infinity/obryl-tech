<?php

declare(strict_types=1);

namespace App\Enums\Auth;

enum UserType: string
{
    case CLIENT = 'client';
    case DEVELOPER = 'developer';
    case ADMIN = 'admin';
    case SURPER_ADMIN = 'super_admin';

    public function label(): string
    {
        return match ($this) {
            self::CLIENT => 'Client',
            self::DEVELOPER => 'Développeur',
            self::ADMIN => 'Administrateur',
            self::SURPER_ADMIN => 'super_admin',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CLIENT => 'blue',
            self::DEVELOPER => 'green',
            self::ADMIN => 'red',
            self::SURPER_ADMIN => 'yellow',

        };
    }
}
