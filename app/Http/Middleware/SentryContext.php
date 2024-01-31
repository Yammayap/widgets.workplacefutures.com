<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\TenantManager\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sentry\State\Scope;
use Sentry\UserDataBag;
use Symfony\Component\HttpFoundation\Response;

class SentryContext
{
    public function __construct(private readonly TenantManager $tenantManager)
    {
        //
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var User|null $user
         */
        $user = Auth::user();

        if (app()->bound('sentry')) {
            \Sentry\configureScope(function (Scope $scope) use ($request, $user): void {

                $scope->setContext('tenant', [
                   'name' =>  $this->tenantManager->getCurrentTenant()->label(),
                ]);

                if ($user !== null) {
                    $userDataBag = new UserDataBag(
                        id: $user->id,
                        email: $user->email,
                        ipAddress: $request->ip(),
                    );

                    $userDataBag->setMetadata('Name', $user->name);

                    $scope->setUser($userDataBag);
                }
            });
        }

        return $next($request);
    }
}
