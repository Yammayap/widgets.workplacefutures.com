<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;

class Inputs
{
    public function __construct(
        public readonly Workstyle $workstyle,
        public readonly int $totalPeople,
        public readonly int $growthPercentage,
        public readonly int $deskPercentage,
        public readonly HybridWorking $hybridWorking,
        public readonly Mobility $mobility,
        public readonly Collaboration $collaboration,
    ) {
    }
}
