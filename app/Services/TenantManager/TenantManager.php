<?php

namespace App\Services\TenantManager;

use App\Enums\Tenant;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class TenantManager
{
    /**
     * @var Tenant $tenant
     */
    private Tenant $tenant;

    public function __construct(private readonly Session $session)
    {
        //
    }

    /**
     * @return Tenant
     */
    public function getCurrentTenant(): Tenant
    {
        return $this->tenant;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function setTenantFromRequest(Request $request): void
    {
        if ($request->filled('ref')) {
            $this->tenant = $this->getTenantFromString($request->input('ref', ''));
            $this->session->put('tenant', $this->tenant);
            return;
        }

        if ($this->session->has('tenant')) {
            $this->tenant = $this->session->get('tenant');
            return;
        }

        $this->tenant = $this->getDefaultTenant();
    }

    /**
     * @return Tenant
     */
    private function getDefaultTenant(): Tenant
    {
        return Tenant::WFG;
    }

    /**
     * @param string $tenantString
     * @return Tenant
     */
    private function getTenantFromString(string $tenantString): Tenant
    {
        $tenant = Tenant::tryFrom($tenantString);

        return $tenant ?? $this->getDefaultTenant();
    }
}
