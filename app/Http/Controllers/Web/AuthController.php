<?php

namespace App\Http\Controllers\Web;

use App\Actions\MagicLinks\MarkAsAuthenticated;
use App\Http\Controllers\WebController;
use App\Models\MagicLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends WebController
{
    /**
     * @param Request $request
     * @param MagicLink $magicLink
     * @return RedirectResponse
     */
    public function getMagicLink(Request $request, MagicLink $magicLink): RedirectResponse
    {
        if (Auth::check()) {
            Session::flush();
        }

        MarkAsAuthenticated::run($magicLink, $request->ip());

        Auth::login($magicLink->user);

        if ($magicLink->intended_url != null) {
            return redirect($magicLink->intended_url);
        }

        return redirect(route('web.home.index'));
    }

    /**
     * @return View
     */
    public function getSent(): View
    {
        $this->metaTitle('Authentication Required');

        return view('web.auth.sent', [
            'user' => Session::has('auth-sent-user') ? Session::get('auth-sent-user') : null,
        ]);
    }

    /**
     * @return View
     */
    public function getSignOut(): View
    {
        $this->metaTitle('Are you sure you want to sign out?');

        return view('web.auth.sign-out', [
            'user' => $this->authUser(),
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function postSignOut(): RedirectResponse
    {
        Auth::logout();

        Session::flush();

        return redirect(route('web.home.index'));
    }
}
