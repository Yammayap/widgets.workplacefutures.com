<?php

namespace Tests\Feature\Http\Web\AuthController;

use Tests\TestCase;

class PostSignOutTest extends TestCase
{
    public function test_authenticated_user_can_sign_out(): void
    {
        $this->authenticateUser();

        $this->post(route('web.sign-out.post'))
            ->assertRedirect(route('web.home.index'))
            ->assertSessionHasNoErrors();

        $this->assertGuest();
    }
}
