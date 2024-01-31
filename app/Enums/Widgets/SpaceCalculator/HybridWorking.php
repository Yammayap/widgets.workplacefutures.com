<?php

namespace App\Enums\Widgets\SpaceCalculator;

use App\Enums\Contracts\HasLabel;

enum HybridWorking: string implements HasLabel
{
    case OFFICE = 'office_based';
    case ONE_DAY = 'one_day';
    case TWO_DAYS = 'two_days';
    case THREE_DAYS = 'three_days';
    case FOUR_DAYS = 'four_days';
    case HOME = 'home';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::OFFICE => 'Based at the office',
            self::ONE_DAY => 'WFH no more than one day/week',
            self::TWO_DAYS => 'WFH no more than two days/week',
            self::THREE_DAYS => 'WFH no more than three days/week',
            self::FOUR_DAYS => 'WFH no more than four days/week',
            self::HOME => 'Only come to the office if necessary',
        };
    }
}
