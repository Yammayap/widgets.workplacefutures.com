<?php

namespace App\Services\TenantManager;

use App\Enums\TenantEnum;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class TenantManager
{
    /**
     * @var TenantEnum $tenant
     */
    private TenantEnum $tenant;

    public function __construct(private readonly Session $session)
    {
        //
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
     * @return TenantEnum
     */
    private function getDefaultTenant(): TenantEnum
    {
        return TenantEnum::WFG;
    }

    /**
     * @param string $tenantString
     * @return TenantEnum
     */
    private function getTenantFromString(string $tenantString): TenantEnum
    {
        $tenant = TenantEnum::tryFrom($tenantString);

        return $tenant ?? $this->getDefaultTenant();
    }

    /**
     * @return TenantEnum
     */
    public function getCurrentTenant(): TenantEnum
    {
        return $this->tenant;
    }
}
