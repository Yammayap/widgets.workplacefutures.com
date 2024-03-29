<?php

namespace Tests\Unit\Services\TenantManager;

use App\Enums\Tenant;
use App\Services\TenantManager\TenantManager;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Tests\TestCase;

class TenantManagerTest extends TestCase
{
    public function test_get_default_tenant_from_request(): void
    {
        $this->mock(Session::class)
            ->shouldReceive('has')
            ->andReturn(false);

        $tenantManager = app()->make(TenantManager::class);

        $tenantManager->setTenantFromRequest(request());

        $this->assertEquals(Tenant::WFG, $tenantManager->getCurrentTenant());
    }

    public function test_get_ambit_tenant_from_request(): void
    {
        $this->mock(Session::class)
            ->shouldReceive('has')
            ->andReturn(false)
            ->shouldReceive('put')
            ->with('tenant', Tenant::AMBIT);

        $tenantManager = app()->make(TenantManager::class);

        $tenantManager->setTenantFromRequest(new Request(['ref' => Tenant::AMBIT->value]));

        $this->assertEquals(Tenant::AMBIT, $tenantManager->getCurrentTenant());
    }

    public function test_defaults_to_wfg_if_incorrect_ref_var_is_used_after_session_set_to_ambit(): void
    {
        $this->mock(Session::class)
            ->shouldReceive('has')
            ->andReturn(false)
            ->shouldReceive('put')
            ->with('tenant', Tenant::AMBIT)
            ->shouldReceive('put')
            ->with('tenant', Tenant::WFG);

        $tenantManager = app()->make(TenantManager::class);

        $tenantManager->setTenantFromRequest(new Request(['ref' => Tenant::AMBIT->value]));
        $this->assertEquals(Tenant::AMBIT, $tenantManager->getCurrentTenant());

        $tenantManager->setTenantFromRequest(new Request(['ref' => 'ambitmoat']));
        $this->assertEquals(Tenant::WFG, $tenantManager->getCurrentTenant());
    }

    public function test_doesnt_set_session_again_if_already_set_and_ref_not_set_but_does_change_when_ref_is_set_again(): void
    {
        $this->withSession(['tenant' => Tenant::AMBIT]);

        $tenantManager = app()->make(TenantManager::class);

        $tenantManager->setTenantFromRequest(new Request());
        $this->assertEquals(Tenant::AMBIT, $tenantManager->getCurrentTenant());

        $tenantManager->setTenantFromRequest(new Request(['ref' => Tenant::MODUS->value]));
        $this->assertEquals(Tenant::MODUS, $tenantManager->getCurrentTenant());
    }
}
