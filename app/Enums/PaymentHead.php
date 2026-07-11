<?php

namespace App\Enums;

enum PaymentHead: string
{
    case FOOD = 'food';
    case GROUP = 'group';
    case SINGLE_LABOUR = 'single_labour';
    case TRANSPORTATION = 'transportation';
    case ACCOMMODATION = 'accommodation';
    case ADVANCE = 'advance';
    case MISCELLANEOUS = 'miscellaneous';

    public function label(): string
    {
        return match ($this) {
            self::FOOD => 'Food Payment',
            self::GROUP => 'Group Payment',
            self::SINGLE_LABOUR => 'Single Labour Payment',
            self::TRANSPORTATION => 'Transportation',
            self::ACCOMMODATION => 'Accommodation',
            self::ADVANCE => 'Advance',
            self::MISCELLANEOUS => 'Miscellaneous',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::FOOD => 'bi-cup-hot',
            self::GROUP => 'bi-people',
            self::SINGLE_LABOUR => 'bi-person',
            self::TRANSPORTATION => 'bi-truck',
            self::ACCOMMODATION => 'bi-house',
            self::ADVANCE => 'bi-cash-stack',
            self::MISCELLANEOUS => 'bi-three-dots',
        };
    }
}
