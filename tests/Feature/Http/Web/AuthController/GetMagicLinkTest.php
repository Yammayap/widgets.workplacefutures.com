<?php

namespace Feature\Http\Web\AuthController;

use App\Models\MagicLink;
use App\Models\User;
use Tests\TestCase;

class GetMagicLinkTest extends TestCase
{
    public function test_can_access_route_as_guest(): void
    {
        $magicLink = MagicLink::factory()->create();

        $this->get($magicLink->signedUrl)
            ->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_already_logged_in_user_is_forbidden(): void
    {
        $user = User::factory()->create();

        $this->authenticateUser($user);

        $magicLink = MagicLink::factory()->create(['user_id' => $user->id]);

        $this->get($magicLink->signedUrl)
            ->assertRedirect('/');
    }
}