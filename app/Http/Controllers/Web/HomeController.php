<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use Illuminate\Http\RedirectResponse;

class HomeController extends WebController
{
    /**
     * @return RedirectResponse
     */
    public function getIndex(): RedirectResponse
    {
        return redirect()->to(route('web.space-calculator.index'));
    }
}
