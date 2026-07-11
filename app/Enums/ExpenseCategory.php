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
    
    // New Labour/Site related expenses
    case GROUP_LABOUR = 'group_labour';
    case SINGLE_LABOUR = 'single_labour';
    case ACCOMMODATION = 'accommodation';
    case TRANSPORTATION = 'transportation';

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
            
            self::GROUP_LABOUR => 'Group Labour Payment',
            self::SINGLE_LABOUR => 'Single Labour Payment',
            self::ACCOMMODATION => 'Accommodation',
            self::TRANSPORTATION => 'Transportation',
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
            
            self::GROUP_LABOUR => 'bi-people',
            self::SINGLE_LABOUR => 'bi-person',
            self::ACCOMMODATION => 'bi-house',
            self::TRANSPORTATION => 'bi-truck',
        };
    }
}
