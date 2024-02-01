<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Http\Controllers\WebController;
use Illuminate\View\View;

class LandingController extends WebController
{
    /**
     * @return View
     */
    public function getLanding(): View
    {
        // todo: discuss - redefine meta title (defer for now)
        $this->metaTitle('Space Calculator Landing Page');

        return view('web.space-calculator.landing', [
            //
        ]);
    }
}
