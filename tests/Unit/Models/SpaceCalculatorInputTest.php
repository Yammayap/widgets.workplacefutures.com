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

        $inputs = $model->transformToInputs();

        $this->assertInstanceOf(Inputs::class, $inputs);
    }
}
