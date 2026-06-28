<?php

namespace App\Enums;

enum UserRole: int
{
    case User  = 1;
    case Agent = 2;
    case Admin = 3;

    public function label(): string
    {
        return match ($this) {
            self::User  => 'User',
            self::Agent => 'Team Member',
            self::Admin => 'Admin',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::User  => 'Regular customer. Can submit and view their own tickets.',
            self::Agent => 'Support team member. Can be assigned tickets but has no admin console access.',
            self::Admin => 'Full admin access. Can manage all tickets, users, and settings.',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::User  => 'bg-slate-100 text-slate-700 border-slate-200',
            self::Agent => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            self::Admin => 'bg-violet-50 text-violet-700 border-violet-200',
        };
    }

    public function dotClasses(): string
    {
        return match ($this) {
            self::User  => 'bg-slate-400',
            self::Agent => 'bg-indigo-500',
            self::Admin => 'bg-violet-500',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $role) => [$role->value => $role->label()])
            ->all();
    }
}
