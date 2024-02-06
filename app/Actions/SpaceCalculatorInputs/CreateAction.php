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
     * @param int $total_people
     * @param int $growth_percentage
     * @param int $desk_percentage
     * @param HybridWorking $hybrid_working
     * @param Mobility $mobility
     * @param Collaboration $collaboration
     * @param Enquiry $enquiry
     * @return void
     */
    public function handle(
        Workstyle $workstyle,
        int $total_people,
        int $growth_percentage,
        int $desk_percentage,
        HybridWorking $hybrid_working,
        Mobility $mobility,
        Collaboration $collaboration,
        Enquiry $enquiry
    ): void {
        $input = new SpaceCalculatorInput();
        $input->enquiry_id = $enquiry->id;
        $input->workstyle = $workstyle;
        $input->total_people = $total_people;
        $input->growth_percentage = $growth_percentage;
        $input->desk_percentage = $desk_percentage;
        $input->hybrid_working = $hybrid_working;
        $input->mobility = $mobility;
        $input->collaboration = $collaboration;
        $input->save();
    }
}
