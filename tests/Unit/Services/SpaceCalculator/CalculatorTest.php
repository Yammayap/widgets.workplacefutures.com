<?php

namespace Tests\Unit\Services\SpaceCalculator;

use App\Models\SpaceCalculatorInput;
use App\Services\SpaceCalculator\Calculator;
use App\Services\SpaceCalculator\Output;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    public function test_returns_output_class_from_calculate_method(): void
    {
        $calculator = app()->make(Calculator::class);

        $this->assertInstanceOf(
            Output::class,
            $calculator->calculate(
                SpaceCalculatorInput::factory()->create()->transformToCalculatorInputs(),
            )
        );

        // todo: test to be expanded upon (and more to be added)
    }
}
