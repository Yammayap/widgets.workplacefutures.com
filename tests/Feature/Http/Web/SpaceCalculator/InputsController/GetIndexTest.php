<?php

namespace Feature\Http\Web\SpaceCalculator\InputsController;

use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok(): void
    {
        $response = $this->get(route('web.space-calculator.inputs'));

        $response->assertOk()
            ->assertViewIs('web.space-calculator.inputs');
    }
}
