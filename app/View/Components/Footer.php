<?php

namespace App\View\Components;

use App\Services\TenantManager\TenantManager;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private readonly TenantManager $tenantManager)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.footer', [
            'tenant' => $this->tenantManager->getCurrentTenant(),
        ]);
    }
}
