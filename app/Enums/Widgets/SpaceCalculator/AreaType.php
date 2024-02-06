<?php

namespace App\Enums\Widgets\SpaceCalculator;

use App\Enums\Contracts\HasLabel;

enum AreaType: string implements HasLabel
{
    case FOCUS = 'focus';
    case COLLABORATION = 'collaboration';
    case FRONT_OF_HOUSE = 'front-of-house';
    case FACILITIES = 'facilities';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::FOCUS => 'Focus',
            self::COLLABORATION => 'Collaboration',
            self::FRONT_OF_HOUSE => 'Front of House',
            self::FACILITIES => 'Facilities',
        };
    }
}
