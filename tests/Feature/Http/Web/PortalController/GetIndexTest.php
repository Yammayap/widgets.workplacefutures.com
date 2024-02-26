<?php

namespace Tests\Feature\Http\Web\PortalController;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok(): void
    {
        $this->authenticateUser();

        $this->get(route('web.portal.index'))
            ->assertOk()
            ->assertViewIs('web.portal.index')
            ->assertSeeText('You have not made any enquiries yet');
    }

    public function test_page_loads_ok_with_enquiries(): void
    {
        $user = User::factory()->create();

        $enquiry_1 = Enquiry::factory()->create(['user_id' => $user->id]);
        $enquiry_2 = Enquiry::factory()->create(['user_id' => $user->id]);
        $enquiry_3 = Enquiry::factory()->create(['user_id' => $user->id]);

        SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry_1]);
        SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry_2]);
        SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry_3]);

        $this->authenticateUser($user);

        $this->get(route('web.portal.index'))
            ->assertOk()
            ->assertViewIs('web.portal.index')
            ->assertDontSeeText('You have not made any enquiries yet');
    }

    public function test_redirect_for_guest(): void
    {
        $this->assertGuest();

        $this->get(route('web.portal.index'))
            ->assertRedirect();
    }
}
