<?php

namespace Tests\Feature\Http\Web\AuthController;

use App\Actions\MagicLinks\MarkAsAuthenticated;
use App\Models\MagicLink;
use App\Models\User;
use Tests\TestCase;

class GetMagicLinkTest extends TestCase
{
    public function test_can_access_route_and_be_authenticated(): void
    {
        $this->assertGuest();

        $magicLink = MagicLink::factory()->create([
            'ip_requested_from' => '127.0.0.1',
        ]);

        MarkAsAuthenticated::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($magicLink),
                '127.0.0.1',
            );

        $this->get($magicLink->signedUrl)
            ->assertRedirect(route('web.home.index'));

        $this->assertAuthenticated();
    }

    public function test_can_access_route_and_be_authenticated_with_different_intended_url(): void
    {
        $this->assertGuest();

        $magicLink = MagicLink::factory()->create([
            'ip_requested_from' => '127.0.0.1',
            'intended_url' => route('web.space-calculator.inputs.index')
        ]);

        MarkAsAuthenticated::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($magicLink),
                '127.0.0.1',
            );

        $this->get($magicLink->signedUrl)
            ->assertRedirect(route('web.space-calculator.inputs.index'));

        $this->assertAuthenticated();
    }

    public function test_switches_already_authenticated_user_to_target_user(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $this->authenticateUser($user_1);

        $magicLink = MagicLink::factory()->create([
            'ip_requested_from' => '127.0.0.1',
            'user_id' => $user_2->id
        ]);

        MarkAsAuthenticated::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($magicLink),
                '127.0.0.1',
            );

        $this->get($magicLink->signedUrl)
            ->assertRedirect(route('web.home.index'));

        $this->assertAuthenticatedAs($user_2);
    }
}
