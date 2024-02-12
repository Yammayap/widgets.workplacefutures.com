<?php

namespace Tests\Unit\Actions\MagicLinks;

use App\Actions\MagicLinks\SendAction;
use App\Models\MagicLink;
use App\Models\User;
use App\Notifications\MagicLinkNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendActionTest extends TestCase
{
    public function test_magic_link_is_created(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $ipAddress = $this->faker->ipv4;
        $intendedUrl = $this->faker->url;

        $this->assertEquals(0, MagicLink::query()->count());

        SendAction::run(
            $user,
            $ipAddress,
            $intendedUrl,
        );

        $this->assertEquals(1, MagicLink::query()->count());

        /**
         * @var MagicLink $magicLink
         */
        $magicLink = MagicLink::query()->first();

        $this->assertEquals($user->id, $magicLink->user_id);
        $this->assertNotNull($magicLink->requested_at);
        $this->assertNotNull($magicLink->expires_at);
        $this->assertNull($magicLink->authenticated_at);
        $this->assertEquals($ipAddress, $magicLink->ip_requested_from);
        $this->assertNull($magicLink->ip_authenticated_from);
        $this->assertEquals($intendedUrl, $magicLink->intended_url);

        Notification::assertCount(1);
        Notification::assertSentTo(
            $user,
            MagicLinkNotification::class,
        );
    }

    public function test_magic_link_is_created_without_intended_url(): void
    {
        Notification::fake();

        $this->assertEquals(0, MagicLink::query()->count());

        SendAction::run(
            User::factory()->create(),
            $this->faker->ipv4,
        );

        $this->assertEquals(1, MagicLink::query()->count());

        /**
         * @var MagicLink $magicLink
         */
        $magicLink = MagicLink::query()->first();

        $this->assertNull($magicLink->intended_url);

        Notification::assertCount(1);
        Notification::assertSentTo(
            $magicLink->user,
            MagicLinkNotification::class,
        );
    }
}
