<?php

namespace Tests\Unit\Models;

use App\Models\MagicLink;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class MagicLinkTest extends TestCase
{
    public function test_is_valid(): void
    {
        $magic_link_1 = MagicLink::factory()->create([
            'expires_at' => CarbonImmutable::now()->addMinutes(config('widgets.magic-links.expiry-minutes')),
            'ip_requested_from' => '127.0.0.1',
        ]);
        $magic_link_2 = MagicLink::factory()->expired()->create();
        $magic_link_3 = MagicLink::factory()->create([
            'expires_at' => CarbonImmutable::now()->addMinutes(config('widgets.magic-links.expiry-minutes')),
            'ip_requested_from' => $this->faker->ipv4,
        ]);

        $this->assertTrue($magic_link_1->isValid('127.0.0.1'));
        $this->assertFalse($magic_link_2->isValid('127.0.0.1'));
        $this->assertFalse($magic_link_3->isValid('127.0.0.1'));
    }

    public function test_get_intended_url(): void
    {
        $magic_link_1 = MagicLink::factory()->create();
        $magic_link_2 = MagicLink::factory()->expired()->create([
            'intended_url' => 'https://www.bbc.co.uk',
        ]);

        $this->assertEquals(route('web.home.index'), $magic_link_1->getIntendedUrl());
        $this->assertEquals('https://www.bbc.co.uk', $magic_link_2->getIntendedUrl());
    }
}
