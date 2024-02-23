<?php

namespace Tests\Feature\Http\Web\AuthController;

use App\Models\User;
use Tests\TestCase;

class GetSignInTest extends TestCase
{
    public function test_can_access_route_as_guest(): void
    {
        $this->get(route('web.auth.sign-in'))
            ->assertOk()
            ->assertViewIs('web.auth.sign-in')
            ->assertSeeTextInOrder([
                'Sign In',
                'Email address',
                'Get my sign in link',
                'Back to portal'
            ]);
    }

    public function test_cannot_access_route_as_auth_user(): void
    {
        $user = User::factory()->create();

        $this->authenticateUser($user);

        $this->get(route('web.auth.sign-in'))
            ->assertRedirect(route('web.home.index'));
    }
}
