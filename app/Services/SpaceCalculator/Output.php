<?php

namespace App\Services\SpaceCalculator;

use Illuminate\Support\Collection;

class Output
{
    /**
     * @param OutputAreaSize $areaSize
     * @param Collection<int, OutputAsset> $assets
     */
    public function __construct(
        public readonly OutputAreaSize $areaSize,
        public readonly Collection $assets,
    ) {
    }
}
