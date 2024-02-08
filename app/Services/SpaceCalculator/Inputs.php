<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;

readonly class Inputs
{
    public function __construct(
        public Workstyle $workstyle,
        public int $totalPeople,
        public int $growthPercentage,
        public int $deskPercentage,
        public HybridWorking $hybridWorking,
        public Mobility $mobility,
        public Collaboration $collaboration,
    ) {
    }
}
