<?php

namespace App\Actions\MagicLinks;

use App\Models\MagicLink;
use App\Models\User;
use App\Notifications\MagicLinkNotification;
use Carbon\CarbonImmutable;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class SendAction
{
    use AsFake;
    use AsObject;

    /**
     * @param User $user
     * @param string $ipAddress
     * @param string|null $intendedUrl
     * @return void
     */
    public function handle(User $user, string $ipAddress, string $intendedUrl = null): void
    {
        $magicLink = new MagicLink();
        $magicLink->user_id = $user->id;
        $magicLink->requested_at = CarbonImmutable::now();
        $magicLink->expires_at = CarbonImmutable::now()->addMinutes(config('widgets.auth.magic-links.expiry-minutes'));
        $magicLink->ip_requested_from = $ipAddress;
        $magicLink->intended_url = $intendedUrl;
        $magicLink->save();

       $user->notify(new MagicLinkNotification($magicLink));
    }
}
