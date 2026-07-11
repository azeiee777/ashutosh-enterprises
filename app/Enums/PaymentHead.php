<?php

namespace App\Enums;

enum PaymentHead: string
{
    case ADVANCE_FROM_CLIENT = 'advance_from_client';
    case PART_PAYMENT = 'part_payment';
    case FULL_SETTLEMENT = 'full_settlement';
    case ON_ACCOUNT = 'on_account';
    case REFUND = 'refund';
    case MISCELLANEOUS = 'miscellaneous';

    public function label(): string
    {
        return match ($this) {
            self::ADVANCE_FROM_CLIENT => 'Advance from Client',
            self::PART_PAYMENT => 'Part Payment / Against Invoice',
            self::FULL_SETTLEMENT => 'Full Settlement',
            self::ON_ACCOUNT => 'On Account Payment',
            self::REFUND => 'Refund to Client',
            self::MISCELLANEOUS => 'Miscellaneous',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::ADVANCE_FROM_CLIENT => 'bi-cash-stack',
            self::PART_PAYMENT => 'bi-pie-chart',
            self::FULL_SETTLEMENT => 'bi-check-circle',
            self::ON_ACCOUNT => 'bi-wallet2',
            self::REFUND => 'bi-arrow-return-left',
            self::MISCELLANEOUS => 'bi-three-dots',
        };
    }
}
