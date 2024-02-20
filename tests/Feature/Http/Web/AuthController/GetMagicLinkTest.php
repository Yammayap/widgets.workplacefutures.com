<?php

namespace Tests\Feature\Http\Web\AuthController;

use App\Actions\MagicLinks\LoginAction;
use App\Models\MagicLink;
use Tests\TestCase;

class GetMagicLinkTest extends TestCase
{
    public function test_can_access_route_as_guest_with_different_intended_url(): void
    {
        $magicLink = MagicLink::factory()->create([
            'ip_requested_from' => '127.0.0.1',
            'intended_url' => route('web.space-calculator.inputs.index'),
        ]);

        LoginAction::shouldRun()
            ->once()
            ->with(
                '127.0.0.1',
                $this->mockArgModel($magicLink),
            )
            ->andReturn(redirect($magicLink->getIntendedUrl()));

        $this->get($magicLink->signedUrl)
            ->assertRedirect(route('web.space-calculator.inputs.index'));
    }
}
