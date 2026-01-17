<?php

declare(strict_types=1);

namespace App\Enums\Developer;

enum SkillLevel: string
{
    case JUNIOR = 'junior';
    case INTERMEDIATE = 'intermediate';
    case SENIOR = 'senior';
    case EXPERT = 'expert';

    public function label(): string
    {
        return match ($this) {
            self::JUNIOR => 'Junior',
            self::INTERMEDIATE => 'Intermédiaire',
            self::SENIOR => 'Senior',
            self::EXPERT => 'Expert',
        };
    }

    public function stars(): int
    {
        return match ($this) {
            self::JUNIOR => 1,
            self::INTERMEDIATE => 2,
            self::SENIOR => 3,
            self::EXPERT => 4,
        };
    }
}
