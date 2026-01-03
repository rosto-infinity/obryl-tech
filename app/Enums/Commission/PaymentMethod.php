<?php

namespace App\Enums\Commission;

enum PaymentMethod: string
{
    case BANK_TRANSFER = 'bank_transfer';
    case MOBILE_MONEY = 'mobile_money';
    case WALLET = 'wallet';
    case CRYPTO = 'crypto';

    public function label(): string
    {
        return match($this) {
            self::BANK_TRANSFER => 'Virement bancaire',
            self::MOBILE_MONEY => 'Mobile Money',
            self::WALLET => 'Portefeuille',
            self::CRYPTO => 'Cryptomonnaie',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::BANK_TRANSFER => '🏦',
            self::MOBILE_MONEY => '📱',
            self::WALLET => '💳',
            self::CRYPTO => '₿',
        };
    }
}
