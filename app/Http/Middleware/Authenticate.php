<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\Dashboard\Login\LoginController;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('dashboard.unauthenticated');
        }
    }
}
