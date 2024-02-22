<?php

namespace Tests\Feature\Http\Web\AuthController;

use Tests\TestCase;

class PostLogoutTest extends TestCase
{
    public function test_authenticated_user_can_logout(): void
    {
        $this->authenticateUser();

        $this->post(route('web.logout.post'))
            ->assertRedirect(route('web.home.index'))
            ->assertSessionHasNoErrors();

        $this->assertGuest();
    }
}
