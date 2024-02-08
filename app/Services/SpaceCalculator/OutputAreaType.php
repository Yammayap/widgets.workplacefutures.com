<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\AreaType;

class OutputAreaType
{
    /**
     * @param AreaType $areaType
     * @param int $quantity
     */
    public function __construct(
        public readonly AreaType $areaType,
        public readonly int $quantity,
    ) {
        //
    }
}
