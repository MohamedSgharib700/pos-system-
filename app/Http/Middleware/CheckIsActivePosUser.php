<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CheckIsActivePosUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if(auth('pos_s')->check() && ! auth('pos_s')->user()->is_active) {
            throw ValidationException::withMessages([
                'error' => __('general.pos_not_activated')
            ]);
        }
        return $response;
    }
}
