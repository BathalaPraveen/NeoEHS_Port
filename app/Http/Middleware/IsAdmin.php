<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin {

    public function handle($request, Closure $next) {

        if (! (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_IT_ADMIN) || CheckUserRole(ROLE_IT_ADMIN)  || CheckUserRole(ROLE_HSE_ADMIN)) ) {

          return redirect(url('nopermission'));

        }
        return $next($request);
    }

}
