<?php

namespace App\Enums\Widgets\SpaceCalculator;

use App\Enums\Contracts\HasLabel;

enum WorkstationType: string implements HasLabel
{
    case PRIVATE_OFFICES = 'private-offices';
    case OPEN_PLAN_DESKS = 'open-plan-desks';
    case OPEN_PLAN_TOUCHDOWN_DESKS = 'open-plan-touchdown-desks';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PRIVATE_OFFICES => 'Private Offices',
            self::OPEN_PLAN_DESKS => 'Open Plan Desks',
            self::OPEN_PLAN_TOUCHDOWN_DESKS => 'Open Plan Touchdown Desks',
        };
    }
}
