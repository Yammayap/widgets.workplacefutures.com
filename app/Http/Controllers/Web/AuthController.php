<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Models\MagicLink;
use Illuminate\Http\RedirectResponse;

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
}
