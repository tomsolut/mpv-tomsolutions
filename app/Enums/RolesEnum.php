<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'Super Admin';
    case ADMIN = 'Admin';
    case DOCTOR = 'Doctor';
    case EMPLOYEE = 'Employee';

    public static function toArray(): array
    {
        return [
            self::SUPER_ADMIN,
            self::ADMIN,
            self::DOCTOR,
            self::EMPLOYEE,
        ];
    }

    public function color(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'primary',
            self::ADMIN => 'info',
            self::DOCTOR => 'success',
            self::EMPLOYEE => 'warning',
        };
    }
}
