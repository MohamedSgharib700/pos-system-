<?php

namespace App\Providers;

use App\Modules\BanksAccounts\Policies\BranchBankAcountsPolicy;
use App\Policies\Manager\BranchManagerPolicy;
use App\Policies\Manager\ManagerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'BranchBankAcountsPolicy' => BranchBankAcountsPolicy::class,
        'ManagerPolicyForOwner' => ManagerPolicy::class,
        'ManagerPolicyForBranchManager' => BranchManagerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
