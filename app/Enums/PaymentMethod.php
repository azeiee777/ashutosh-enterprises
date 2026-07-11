<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case BANK = 'bank';
    case UPI = 'upi';
    case CHEQUE = 'cheque';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::BANK => 'Bank Transfer',
            self::UPI => 'UPI',
            self::CHEQUE => 'Cheque',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::CASH => 'bi-cash',
            self::BANK => 'bi-bank',
            self::UPI => 'bi-phone',
            self::CHEQUE => 'bi-file-earmark-text',
        };
    }
}
