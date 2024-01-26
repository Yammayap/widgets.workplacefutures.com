<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends WebController
{
    public function getIndex(): View
    {
        $this->metaTitle('Dashboard');

        return view('web.dashboard.index', [
            //
        ]);
    }
}
