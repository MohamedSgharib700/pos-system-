<?php

namespace App\Policies\Manager;

use App\Models\Manager;
use App\Models\PosUser;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchManagerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function unlock(Manager $manager, $branch_id): bool
    {
        return ( $manager->user_type == Manager::BRANCH_MANAGER && $manager->branch->id == $branch_id);
    }
}
