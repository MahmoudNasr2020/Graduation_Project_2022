<?php

namespace App\Http\Middleware;

use App\Http\Traits\ApiTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Rule
{
   use ApiTrait;
    public function handle(Request $request, Closure $next,$permission)
    {
        if( !Auth::guard('api-admin')->user()->rule || Auth::guard('api-admin')->user()->rule->$permission == 'disable')
        {
            return $this->response('you do not have permission','success',403);
        }
        return $next($request);
    }
}
