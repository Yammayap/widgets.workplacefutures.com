<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use Illuminate\View\View;

class PortalController extends WebController
{
    public function getIndex(): View
    {
        $this->metaTitle('Portal');

        return view('web.portal.index', [
           //
        ]);
    }
}
