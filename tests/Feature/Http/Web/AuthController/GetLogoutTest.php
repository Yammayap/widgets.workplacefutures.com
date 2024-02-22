<?php

namespace Tests\Feature\Http\Web\AuthController;

use Tests\TestCase;

class GetLogoutTest extends TestCase
{
    public function test_can_access_route_as_authenticated_user(): void
    {
        $this->authenticateUser();

        $this->get(route('web.logout.index'))
            ->assertOk()
            ->assertViewIs('web.auth.logout');
    }

    public function test_guest_cannot_access_logout_page(): void
    {
        $this->assertGuest();

        $this->get(route('web.logout.index'))
            ->assertRedirect(route('web.home.index'));
    }
}
