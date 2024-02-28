<?php

namespace Feature\Http\Web\SpaceCalculator\InputsController;

use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok(): void
    {
        $this->assertGuest();

        $this->get(route('web.space-calculator.inputs.index'))
            ->assertOk()
            ->assertViewIs('web.space-calculator.inputs')
            ->assertDontSeeText([
                'Message',
                'Happy for a consultant to get in touch?'
            ]);
    }

    public function test_page_loads_ok_for_authenticated_user(): void
    {
        $this->authenticateUser();

        $this->get(route('web.space-calculator.inputs.index'))
            ->assertOk()
            ->assertViewIs('web.space-calculator.inputs')
            ->assertSeeText([
                'Message',
                'Happy for a consultant to get in touch?'
            ]);
    }
}
