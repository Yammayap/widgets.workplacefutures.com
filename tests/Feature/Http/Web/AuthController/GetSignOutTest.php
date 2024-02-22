<?php

namespace Tests\Feature\Http\Web\AuthController;

use Tests\TestCase;

class GetSignOutTest extends TestCase
{
    public function test_can_access_route_as_authenticated_user(): void
    {
        $this->authenticateUser();

        $this->get(route('web.sign-out.index'))
            ->assertOk()
            ->assertViewIs('web.auth.sign-out');
    }

    public function test_guest_cannot_access_sign_out_page(): void
    {
        $this->assertGuest();

        $this->get(route('web.sign-out.index'))
            ->assertRedirect(route('web.home.index'));
    }
}
