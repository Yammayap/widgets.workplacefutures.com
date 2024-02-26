<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Update your profile');

        return view('web.profile.index', [
            'user' => $this->authUser(),
        ]);
    }

    public function postIndex(): RedirectResponse
    {
        dd('in post profile');
    }
}
