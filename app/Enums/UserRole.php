<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case ACCOUNTANT = 'accountant';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::MANAGER => 'Manager',
            self::ACCOUNTANT => 'Accountant',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'danger',
            self::ADMIN => 'primary',
            self::MANAGER => 'info',
            self::ACCOUNTANT => 'warning',
        };
    }
}
