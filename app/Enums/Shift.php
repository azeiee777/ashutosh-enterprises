<?php

namespace App\Enums;

enum Shift: string
{
    case DAY = 'day';
    case NIGHT = 'night';
    case GENERAL = 'general';

    public function label(): string
    {
        return match ($this) {
            self::DAY => 'Day Shift',
            self::NIGHT => 'Night Shift',
            self::GENERAL => 'General',
        };
    }
}
