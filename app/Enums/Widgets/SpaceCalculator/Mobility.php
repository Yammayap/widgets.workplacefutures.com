<?php

namespace App\Enums\Widgets\SpaceCalculator;

use App\Enums\Contracts\HasLabel;

enum Mobility: string implements HasLabel
{
    case SPECIFIC_DESKS = 'specific_desks';
    case COMPUTER_MIXTURE = 'computer_mixture';
    case LAPTOPS_DOCKING = 'laptops_docking';
    case LAPTOPS_TOUCHDOWN = 'laptops_touchdown';
    case LAPTOPS_ANYWHERE = 'laptops_anywhere';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::SPECIFIC_DESKS => 'We have specialist kit which means we must use specific desks',
            self::COMPUTER_MIXTURE => 'We use a mixture of laptops and desktops and do a lot of our work at regular desks',
            self::LAPTOPS_DOCKING => 'Everything is on our laptops but we prefer to use docking stations on regular desks if available',
            self::LAPTOPS_TOUCHDOWN => 'Everything is on our laptops but we prefer to work at desks or touchdown points',
            self::LAPTOPS_ANYWHERE => 'Everything is on our laptops and we can work anywhere',
        };
    }
}
