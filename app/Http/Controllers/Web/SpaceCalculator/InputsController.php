<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Http\Controllers\WebController;
use Illuminate\View\View;

class InputsController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        // todo: discuss meta title - probably defer, this is ok for now but doesn't seem like a final title
        $this->metaTitle('Space Calculator Inputs');

        return view('web.space-calculator.inputs', [
            //
        ]);
    }
}
