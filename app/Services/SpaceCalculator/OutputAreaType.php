<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\AreaType;

readonly class OutputAreaType
{
    /**
     * @param AreaType $areaType
     * @param int $quantity
     */
    public function __construct(
        public AreaType $areaType,
        public int $quantity,
    ) {
        //
    }
}
