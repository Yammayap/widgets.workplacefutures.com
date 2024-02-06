<?php

namespace App\Enums\Widgets\SpaceCalculator;

use App\Enums\Contracts\HasLabel;
use App\Enums\Traits\ProvidesSelectOptions;

enum Collaboration: string implements HasLabel
{
    use ProvidesSelectOptions;

    case INDIVIDUAL_FOCUS = 'individual-focus';
    case SOME_MEETINGS = 'some-meetings';
    case MANY_MEETINGS = 'many-meetings';
    case AGILE = 'agile';
    case ALL_COLLABORATION = 'all-collaboration';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::INDIVIDUAL_FOCUS => 'We spend a great deal of time on individual focus work',
            self::SOME_MEETINGS => 'Most of our work is individual focus, but we do have some meetings during the day',
            self::MANY_MEETINGS => 'A lot of our time is spent in meetings or on calls',
            self::AGILE => 'We\'re very agile in the office, a lot of team work with some focus time',
            self::ALL_COLLABORATION => 'When we\'re in the office, it\'s all about collaboration',
        };
    }
}
