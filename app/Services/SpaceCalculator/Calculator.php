<?php

namespace App\Services\SpaceCalculator;

use Illuminate\Support\Arr;
use Mattiasgeniar\Percentage\Percentage;

class Calculator
{
    public function __construct(private readonly Config $config)
    {
        //
    }

    /**
     * @param Inputs $inputs
     * @return Output
     */
    public function calculate(Inputs $inputs): Output
    {
        // step one: calculations here - workstations sheet

        $peopleWorkingPlusGrowth = round(
            $inputs->totalPeople + Percentage::of($inputs->growthPercentage, $inputs->totalPeople)
        );

        // todo: discuss - not sure if this needs to be rounded up here or not? (I don't think so?)
        $percentageToAccommodate = Arr::get(
            Arr::get(
                $this->config->workstyleParameters,
                $inputs->workstyle->value
            ),
            'hybrid-working.' . $inputs->hybridWorking->value
        );

        $undiversifiedAllocation = round(Percentage::of($inputs->deskPercentage, $peopleWorkingPlusGrowth));

        // todo: discuss - should we round up $percentageToAccommodate here?
        $diversifiedAllocation = round(
            Percentage::of(
                $percentageToAccommodate,
                $peopleWorkingPlusGrowth - $undiversifiedAllocation
            )
        );

        // end of calculations - empty outputs returned below

        $areaSize = new OutputAreaSize(0, 0, 0, 0, 0, 0);
        $assets = collect();
        $capacityTypes = collect();
        $areaTypes = collect();

        return new Output(
            areaSize: $areaSize,
            assets: $assets,
            capacityTypes: $capacityTypes,
            areaTypes: $areaTypes,
        );
    }
}
