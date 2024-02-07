<?php

namespace App\Actions\SpaceCalculatorInputs;

use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAction
{
    use AsFake;
    use AsObject;

    /**
     * @param Workstyle $workstyle
     * @param int $totalPeople
     * @param int $growthPercentage
     * @param int $deskPercentage
     * @param HybridWorking $hybridWorking
     * @param Mobility $mobility
     * @param Collaboration $collaboration
     * @param Enquiry $enquiry
     * @return void
     */
    public function handle(
        Enquiry $enquiry,
        Workstyle $workstyle,
        int $totalPeople,
        int $growthPercentage,
        int $deskPercentage,
        HybridWorking $hybridWorking,
        Mobility $mobility,
        Collaboration $collaboration,
    ): void {
        $input = new SpaceCalculatorInput();
        $input->enquiry()->associate($enquiry);
        $input->workstyle = $workstyle;
        $input->total_people = $totalPeople;
        $input->growth_percentage = $growthPercentage;
        $input->desk_percentage = $deskPercentage;
        $input->hybrid_working = $hybridWorking;
        $input->mobility = $mobility;
        $input->collaboration = $collaboration;
        $input->save();
    }
}
