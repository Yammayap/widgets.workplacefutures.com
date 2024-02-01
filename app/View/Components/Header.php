<?php

namespace App\View\Components;

use App\Services\TenantManager\TenantManager;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
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
    public function render(): View|Closure|string
    {
        return view('components.header', [
            'tenant' => $this->tenantManager->getCurrentTenant(),
        ]);
    }
}
