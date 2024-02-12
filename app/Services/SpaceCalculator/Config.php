<?php

namespace App\Services\SpaceCalculator;

readonly class Config
{
    /**
     * @param array<string, mixed> $rawSpaceStandards
     */
    public function __construct(
        public array $rawSpaceStandards,
    ) {
        //
    }
}
