<?php

namespace Feature\Http\Web\AuthController;

use Tests\TestCase;

class GetSentTest extends TestCase
{
    public function test_can_access_route_as_guest(): void
    {
        // todo: expand on this later when content finalised
        $this->get(route('web.auth.sent'))
            ->assertViewIs('web.auth.sent');
    }
}
