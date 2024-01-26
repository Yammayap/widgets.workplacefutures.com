<?php

namespace App\Enums;

enum TenantEnum: string
{
    case AMBIT = 'ambit';
    case MODUS = 'modus';
    case PLATFFORM = 'platfform';
    case TWO = 'two';
    case WFG = 'wfg';

    public function label(): string
    {
        return match ($this) {
            self::AMBIT      => 'Ambit',
            self::MODUS      => 'Modus',
            self::PLATFFORM  => 'Platfform',
            self::TWO        => 'Two',
            default          => 'Workplace Futures Group',
        };
    }
}
