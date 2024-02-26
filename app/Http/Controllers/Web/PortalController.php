<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use Illuminate\View\View;

class PortalController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Welcome to your portal');

        $enquiries = $this->authUser()
            ->enquiries()
            ->with('spaceCalculatorInput')
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('web.portal.index', [
            'enquiries' => $enquiries,
        ]);
    }
}
