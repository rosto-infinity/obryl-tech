<?php

namespace App\Enums\Auth;

enum UserType: string
{
    case CLIENT = 'client';
    case DEVELOPER = 'developer';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match($this) {
            self::CLIENT => 'Client',
            self::DEVELOPER => 'Développeur',
            self::ADMIN => 'Administrateur',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::CLIENT => 'blue',
            self::DEVELOPER => 'green',
            self::ADMIN => 'red',
        };
    }
}
