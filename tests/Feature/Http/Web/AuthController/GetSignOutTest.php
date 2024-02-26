<?php

namespace Tests\Feature\Http\Web\AuthController;

use App\Models\User;
use Tests\TestCase;

class GetSignOutTest extends TestCase
{
    public function test_can_access_route_as_authenticated_user(): void
    {
        $this->authenticateUser();

        $this->get(route('web.auth.sign-out'))
            ->assertOk()
            ->assertViewIs('web.auth.sign-out');
    }

    public function test_can_access_route_as_authenticated_user_with_incomplete_profile(): void
    {
        $this->authenticateUser(User::factory()->create(['has_completed_profile' => false]));

        $this->get(route('web.auth.sign-out'))
            ->assertOk()
            ->assertViewIs('web.auth.sign-out');
    }

    public function test_guest_cannot_access_sign_out_page(): void
    {
        $this->assertGuest();

        $this->get(route('web.auth.sign-out'))
            ->assertRedirect(route('web.auth.sign-in'));
    }
}
