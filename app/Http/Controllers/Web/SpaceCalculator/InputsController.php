<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Http\Controllers\WebController;
use App\Http\Requests\Web\SpaceCalculator\PostIndexRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InputsController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Space Calculator Inputs');

        return view('web.space-calculator.inputs', [
            //
        ]);
    }

    /**
     * @param PostIndexRequest $request
     * @return RedirectResponse
     */
    public function postIndex(PostIndexRequest $request): RedirectResponse
    {
        dd('in the post function', $request->all());
    }
}
