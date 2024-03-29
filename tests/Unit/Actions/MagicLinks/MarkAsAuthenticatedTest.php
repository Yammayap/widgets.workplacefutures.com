<?php

namespace Tests\Unit\Actions\MagicLinks;

use App\Actions\MagicLinks\MarkAsAuthenticated;
use App\Models\MagicLink;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class MarkAsAuthenticatedTest extends TestCase
{
    public function test_user_logs_in(): void
    {
        $magicLink = MagicLink::factory()->create();

        MarkAsAuthenticated::run(
            $magicLink,
            '127.0.0.1',
        );

        $magicLink->refresh();
        $this->freezeSecond();
        $this->assertEquals(CarbonImmutable::now(), $magicLink->authenticated_at);
        $this->assertEquals('127.0.0.1', $magicLink->ip_authenticated_from);
    }
}
