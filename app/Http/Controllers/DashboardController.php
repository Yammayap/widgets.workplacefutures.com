<?php

namespace App\Http\Controllers;

use App\Services\TenantManager\TenantManager;
use Illuminate\View\View;

class DashboardController extends WebController
{
    public function getIndex(TenantManager $tenantManager): View
    {
        $this->metaTitle('Dashboard');

        $tenant = $tenantManager->getCurrentTenant();

        return view('web.dashboard.index', [
            'tenant' => $tenant,
        ]);
    }
}
