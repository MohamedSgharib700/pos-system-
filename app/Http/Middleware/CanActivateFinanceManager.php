<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\Manager\ManagerRepository;

class CanActivateFinanceManager
{
    private $managerRepository;

    public function __construct(ManagerRepository $managerRepository)
    {
        $this->managerRepository = $managerRepository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $manager = $this->managerRepository->show($request->route('manager'));
        if($request->is_active == true && $manager->is_finance_manager && auth('manager')->user()->company()->whereHas('financeManager',function($q){$q->whereIsActive(true);})->exists()) {
            throw ValidationException::withMessages([
                'error' => __('general.owner_cannot_activate_finanace_manager')
            ]);
        }
        return $next($request);
    }
}
