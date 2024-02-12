<?php

namespace App\Services\SpaceCalculator;

readonly class Config
{
    /**
     * @param array<string, mixed> $rawSpaceStandards
     * @param array<string, mixed> $workstyleParameters
     * @param array<string, mixed> $circulationAllowances
     * @param array<string, mixed> $assetParameters
     */
    public function __construct(
        public array $rawSpaceStandards,
        public array $workstyleParameters,
        public array $circulationAllowances,
        public array $assetParameters,
    ) {
        //
    }
}
