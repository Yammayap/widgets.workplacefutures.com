<?php

namespace Feature\Http\Web\SpaceCalculator\LandingController;

use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok_for_guest(): void
    {
        $this->assertGuest();

        $response = $this->get(route('web.space-calculator.index'));

        $response->assertOk()
            ->assertViewIs('web.space-calculator.landing')
            ->assertDontSeeText('Get Started');
    }

    public function test_page_loads_ok_for_auth_user(): void
    {
        $this->authenticateUser();

        $response = $this->get(route('web.space-calculator.index'));

        $response->assertOk()
            ->assertViewIs('web.space-calculator.landing')
            ->assertSeeText('Get Started');
    }
}
