<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;

class Inputs
{
    /**
     * @var Workstyle $workstyle
     */
    public readonly Workstyle $workstyle;

    /**
     * @var int $totalPeople
     */
    public readonly int $totalPeople;

    /** @var int $growthPercentage */
    public readonly int $growthPercentage;

    /**
     * @var int $deskPercentage
     */
    public readonly int $deskPercentage;

    /**
     * @var HybridWorking $hybridWorking
     */
    public readonly HybridWorking $hybridWorking;

    /**
     * @var Mobility $mobility
     */
    public readonly Mobility $mobility;

    /**
     * @var Collaboration $collaboration
     */
    public readonly Collaboration $collaboration;

    public function __construct(
        Workstyle $workstyle,
        int $totalPeople,
        int $growthPercentage,
        int $deskPercentage,
        HybridWorking $hybridWorking,
        Mobility $mobility,
        Collaboration $collaboration,
    ) {
        $this->workstyle = $workstyle;
        $this->totalPeople = $totalPeople;
        $this->growthPercentage = $growthPercentage;
        $this->deskPercentage = $deskPercentage;
        $this->hybridWorking = $hybridWorking;
        $this->mobility = $mobility;
        $this->collaboration = $collaboration;

        /* todo: discuss - should we be passing in enums or strings?
        Depends how much of a "black box" this should be... (The enums are defined in the Laravel app)
        */
    }
}
