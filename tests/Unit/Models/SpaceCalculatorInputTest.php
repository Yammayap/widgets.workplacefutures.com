<?php

namespace Tests\Unit\Models;

use App\Models\SpaceCalculatorInput;
use App\Services\SpaceCalculator\Inputs;
use Tests\TestCase;

class SpaceCalculatorInputTest extends TestCase
{
    public function test_transform_to_inputs(): void
    {
        $model = SpaceCalculatorInput::factory()->create();

        $inputs = $model->transformToCalculatorInputs();

        $this->assertInstanceOf(Inputs::class, $inputs);
        $this->assertEquals($model->workstyle, $inputs->workstyle);
        $this->assertEquals($model->total_people, $inputs->totalPeople);
        $this->assertEquals($model->growth_percentage, $inputs->growthPercentage);
        $this->assertEquals($model->desk_percentage, $inputs->deskPercentage);
        $this->assertEquals($model->hybrid_working, $inputs->hybridWorking);
        $this->assertEquals($model->mobility, $inputs->mobility);
        $this->assertEquals($model->collaboration, $inputs->collaboration);
    }
}
