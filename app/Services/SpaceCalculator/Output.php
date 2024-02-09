<?php

namespace App\Services\SpaceCalculator;

use Illuminate\Support\Collection;

readonly class Output
{
    /**
     * @param OutputAreaSize $areaSize
     * @param Collection<int, OutputAsset> $assets
     * @param Collection<int, OutputCapacityType> $capacityTypes
     * @param Collection<int, OutputAreaType> $areaTypes
     */
    public function __construct(
        public OutputAreaSize $areaSize,
        public Collection $assets,
        public Collection $capacityTypes,
        public Collection $areaTypes,
    ) {
    }
}
