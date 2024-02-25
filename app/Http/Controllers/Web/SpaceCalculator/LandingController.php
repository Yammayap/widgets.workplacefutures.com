<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Http\Controllers\WebController;
use Illuminate\View\View;

class LandingController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Space calculator');

        return view('web.space-calculator.landing');
    }
}
