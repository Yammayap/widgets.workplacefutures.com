<?php

namespace App\Services\SpaceCalculator;

use Illuminate\Support\Collection;

class Output
{
    /**
     * @param OutputAreaSize $areaSize
     * @param Collection<int, OutputAsset> $assets
     * @param Collection<int, OutputCapacityType> $capacityTypes
     * @param Collection<int, OutputAreaType> $areaTypes
     */
    public function __construct(
        public readonly OutputAreaSize $areaSize,
        public readonly Collection $assets,
        public readonly Collection $capacityTypes,
        public readonly Collection $areaTypes,
    ) {
    }
}
