<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use Illuminate\View\View;

class PortalController extends WebController
{
    public function getIndex(): View
    {
        dd('Portal - This is a placeholder route - contents to be decided later');
    }
}
