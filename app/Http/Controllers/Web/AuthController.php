<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Models\MagicLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends WebController
{
    /**
     * @param MagicLink $magicLink
     * @return RedirectResponse
     */
    public function getMagicLink(MagicLink $magicLink): RedirectResponse
    {
        // This is a placeholder for now - magic links will link to here

        return redirect(route('web.space-calculator.index'));
    }

    /**
     * @return View
     */
    public function getSent(): View
    {
        // todo: discuss - do we want to show any entered details here or just a generic message? (see view)

        return view('web.auth.sent');
    }
}
