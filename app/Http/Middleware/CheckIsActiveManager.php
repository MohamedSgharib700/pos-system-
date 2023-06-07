<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckIsActiveManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if(auth('manager_s')->check() && ! auth('manager_s')->user()->is_active) {
            throw ValidationException::withMessages([
                'error' => __('general.manager_not_activated')
            ]);
        }
        return $response;
    }
}
