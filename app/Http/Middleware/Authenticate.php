<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!Auth::guard('web')->check()) {
            return route('user.login');
        }
        if (!Auth::guard('web_admin')->check()) {
            return route('admin');
        }
        if (! $request->expectsJson()) {
            return route('welcome');
        }
    }
}
