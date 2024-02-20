<?php

namespace App\Actions\MagicLinks;

use App\Models\MagicLink;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class LoginAction
{
    use AsFake;
    use AsObject;

    /**
     * @param string $ipAddress
     * @param MagicLink $magicLink
     * @return RedirectResponse
     */
    public function handle(string $ipAddress, MagicLink $magicLink): RedirectResponse
    {
        if (Auth::check()) {
            Session::flush();
        }

        if ($magicLink->isValid($ipAddress)) {
            $magicLink->authenticated_at = CarbonImmutable::now();
            $magicLink->ip_authenticated_from = $ipAddress;
            $magicLink->save();
            /**
             * @var User $user
             */
            $user = $magicLink->user;
            Auth::login($user);
            return redirect($magicLink->getIntendedUrl());
        }

        return redirect(route('web.home.index'));
    }
}
