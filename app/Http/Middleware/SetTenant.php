<?php

namespace App\Http\Middleware;

use App\Services\TenantManager\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenant
{
    public function __construct(private readonly TenantManager $tenantManager)
    {
        //
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->tenantManager->setTenantFromRequest($request);

        return $next($request);
    }
}
