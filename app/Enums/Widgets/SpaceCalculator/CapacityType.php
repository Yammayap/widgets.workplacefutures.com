<?php

namespace App\Enums\Widgets\SpaceCalculator;

use App\Enums\Contracts\HasLabel;

enum CapacityType: string implements HasLabel
{
    case LONG_DWELL_WORKSTATION = 'long-dwell-workstation';
    case SHORT_DWELL_WORKSTATION = 'short-dwell-workstation';
    case FOCUS_SPACE = 'focus-space';
    case BREAKOUT = 'breakout';
    case RECREATION = 'recreation';
    case TEAM_MEETING = 'team-meeting';
    case FRONT_OF_HOUSE = 'front-of-house';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::LONG_DWELL_WORKSTATION => 'Long Dwell Workstation',
            self::SHORT_DWELL_WORKSTATION => 'Short Dwell Workstation',
            self::FOCUS_SPACE => 'Focus Space',
            self::BREAKOUT => 'Breakout',
            self::RECREATION => 'Recreation',
            self::TEAM_MEETING => 'Team Meeting',
            self::FRONT_OF_HOUSE => 'Front of House',
        };
    }
}
