<?php

namespace App\Http\Controllers\Web;

use App\Actions\MagicLinks\LoginAction;
use App\Http\Controllers\WebController;
use App\Models\MagicLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return LoginAction::run($request->ip(), $magicLink);
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
}
