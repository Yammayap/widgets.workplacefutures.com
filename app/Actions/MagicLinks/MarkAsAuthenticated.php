<?php

namespace App\Actions\MagicLinks;

use App\Models\MagicLink;
use Carbon\CarbonImmutable;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class MarkAsAuthenticated
{
    use AsFake;
    use AsObject;

    /**
     * @param string $ipAddress
     * @param MagicLink $magicLink
     * @return void
     */
    public function handle(MagicLink $magicLink, string $ipAddress): void
    {
        $magicLink->authenticated_at = CarbonImmutable::now();
        $magicLink->ip_authenticated_from = $ipAddress;
        $magicLink->save();
    }
}
