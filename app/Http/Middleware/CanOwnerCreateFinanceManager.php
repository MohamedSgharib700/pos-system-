<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CanOwnerCreateFinanceManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user_type == Manager::FINANCE_MANAGER && auth('manager')->user()->company()->whereHas('financeManager',function($q){$q->whereIsActive(true);})->exists()) {
            throw ValidationException::withMessages([
                'error' => __('general.owner_cannot_create_finanace_manager')
            ]);
        }

        return $next($request);
    }
}
