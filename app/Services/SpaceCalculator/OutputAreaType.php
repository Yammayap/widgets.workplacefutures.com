<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\AreaType;

readonly class OutputAreaType
{
    /**
     * @param AreaType|string $areaType
     * @param float $quantity
     * @param bool $isEnum
     */
    public function __construct(
        public AreaType|string $areaType,
        public float $quantity,
        public bool $isEnum,
    ) {
        //
    }
}
