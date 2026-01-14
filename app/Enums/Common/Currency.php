<?php

namespace App\Enums\Common;

enum Currency: string
{
    case XAF = 'XAF';
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case CAD = 'CAD';
    case CHF = 'CHF';

    public function label(): string
    {
        return match($this) {
            self::XAF => 'Franc CFA (XAF)',
            self::USD => 'Dollar américain (USD)',
            self::EUR => 'Euro (EUR)',
            self::GBP => 'Livre sterling (GBP)',
            self::CAD => 'Dollar canadien (CAD)',
            self::CHF => 'Franc suisse (CHF)',
        };
    }

    public function symbol(): string
    {
        return match($this) {
            self::XAF => 'Fr',
            self::USD => '$',
            self::EUR => '€',
            self::GBP => '£',
            self::CAD => 'C$',
            self::CHF => 'CHF',
        };
    }
}
