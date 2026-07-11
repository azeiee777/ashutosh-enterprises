<?php

namespace App\Enums;

enum ExpenseCategory: string
{
    case FUEL = 'fuel';
    case OFFICE = 'office';
    case RENT = 'rent';
    case FOOD = 'food';
    case TRAVEL = 'travel';
    case UTILITIES = 'utilities';
    case MISCELLANEOUS = 'miscellaneous';

    public function label(): string
    {
        return match ($this) {
            self::FUEL => 'Fuel',
            self::OFFICE => 'Office Expense',
            self::RENT => 'Rent',
            self::FOOD => 'Food',
            self::TRAVEL => 'Travel',
            self::UTILITIES => 'Utilities',
            self::MISCELLANEOUS => 'Miscellaneous',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::FUEL => 'bi-fuel-pump',
            self::OFFICE => 'bi-building',
            self::RENT => 'bi-house-door',
            self::FOOD => 'bi-cup-hot',
            self::TRAVEL => 'bi-car-front',
            self::UTILITIES => 'bi-lightning',
            self::MISCELLANEOUS => 'bi-three-dots',
        };
    }
}
