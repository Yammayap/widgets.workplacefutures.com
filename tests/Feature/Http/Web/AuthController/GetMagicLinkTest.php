<?php

namespace Tests\Feature\Http\Web\AuthController;

use App\Models\MagicLink;
use App\Models\User;
use Tests\TestCase;

class GetMagicLinkTest extends TestCase
{
    public function test_can_access_route_as_guest(): void
    {
        $magicLink = MagicLink::factory()->create(['ip_requested_from' => '127.0.0.1']);

        $this->get($magicLink->signedUrl)
            ->assertRedirect(route('web.home.index'));

        $this->assertAuthenticated();
    }

    public function test_already_logged_in_user_is_switched_and_session_flushed(): void
    {
        $user = User::factory()->create();
        $user_2 = User::factory()->create();

        $this->authenticateUser($user);

        $magicLink = MagicLink::factory()->create([
            'user_id' => $user_2->id,
            'ip_requested_from' => '127.0.0.1'
        ]);

        $this->withSession(['theTest' => 'testVar'])
            ->get($magicLink->signedUrl)
            ->assertRedirect(route('web.home.index'))
            ->assertSessionMissing('theTest');

        $this->assertAuthenticatedAs($user_2);
    }
}
