<?php

namespace Tests\Unit\Actions\MagicLinks;

use App\Actions\MagicLinks\LoginAction;
use App\Models\MagicLink;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;

class LoginActionTest extends TestCase
{
    public function test_user_logs_in(): void
    {
        $magicLink = MagicLink::factory()->create(['ip_requested_from' => '127.0.0.1']);

        $this->assertGuest();
        $this->assertNull($magicLink->authenticated_at);
        $this->assertNull($magicLink->ip_authenticated_from);

        $loginAction = LoginAction::run(
            '127.0.0.1',
            $magicLink,
        );

        $magicLink->refresh();
        $this->assertAuthenticated();
        $this->assertNotNull($magicLink->authenticated_at);
        $this->assertEquals('127.0.0.1', $magicLink->ip_authenticated_from);
        $this->assertInstanceOf(RedirectResponse::class, $loginAction);
    }

    public function test_logged_in_user_switches_to_other_user(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();
        $magicLink = MagicLink::factory()->create([
            'ip_requested_from' => '127.0.0.1',
            'user_id' => $user_2->id,
        ]);

        $this->authenticateUser($user_1);

        $this->assertAuthenticatedAs($user_1);
        $this->assertNull($magicLink->authenticated_at);
        $this->assertNull($magicLink->ip_authenticated_from);

        LoginAction::run(
            '127.0.0.1',
            $magicLink,
        );

        $this->assertAuthenticatedAs($user_2);
    }

    public function test_user_cannot_log_in_with_expired_magic_link(): void
    {
        $magicLink = MagicLink::factory()->expired()->create([]);

        $this->assertGuest();
        $this->assertNull($magicLink->authenticated_at);
        $this->assertNull($magicLink->ip_authenticated_from);

        $loginAction = LoginAction::run(
            '127.0.0.1',
            $magicLink,
        );

        $magicLink->refresh();
        $this->assertGuest();
        $this->assertNull($magicLink->authenticated_at);
        $this->assertNull($magicLink->ip_authenticated_from);
        $this->assertInstanceOf(RedirectResponse::class, $loginAction);
    }

    public function test_user_cannot_log_in_with_different_ip_address(): void
    {
        $magicLink = MagicLink::factory()->expired()->create(['ip_requested_from' => $this->faker->ipv4]);

        $this->assertGuest();
        $this->assertNull($magicLink->authenticated_at);
        $this->assertNull($magicLink->ip_authenticated_from);

        $loginAction = LoginAction::run(
            '127.0.0.1',
            $magicLink,
        );

        $magicLink->refresh();
        $this->assertGuest();
        $this->assertNull($magicLink->authenticated_at);
        $this->assertNull($magicLink->ip_authenticated_from);
        $this->assertInstanceOf(RedirectResponse::class, $loginAction);
    }
}
