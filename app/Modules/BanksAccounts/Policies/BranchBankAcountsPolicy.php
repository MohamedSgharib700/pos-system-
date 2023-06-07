<?php

namespace App\Modules\BanksAccounts\Policies;

use App\Models\Manager;
use App\Modules\Branch\Entities\Branch;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchBankAcountsPolicy
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

    public function view(Manager $manager, Branch $branch)
    {
        return $manager->company->branches()->where('id',$branch->id)->exists();
    }

  /**
   * Determine whether the manager can create bankaccounts on this branch.
   *
   * @param  App\Models\Manager $manager
   * @param  App\Modules\Branch\Entities\Branch $branch
   * @return bool
   */
    public function create(Manager $manager, Branch $branch)
    {
        return $branch->company_id == $manager->company->id && ($manager->user_type == Manager::OWNER || $manager->user_type == Manager::FINANCE_MANAGER);
    }

  /**
   * Determine whether the manager can update bankaccount on this branch.
   *
   * @param  App\Models\Manager $manager
   * @param  App\Modules\Branch\Entities\Branch $branch
   * @return bool
   */
    public function update(Manager $manager, Branch $branch)
    {
        return $branch->company_id == $manager->company->id && ($manager->user_type == Manager::OWNER || $manager->user_type == Manager::FINANCE_MANAGER);
    }

    /**
   * Determine whether the manager can delete bankaccount on this branch.
   *
   * @param  App\Models\Manager $manager
   * @param  App\Modules\Branch\Entities\Branch $branch
   * @return bool
   */
    public function delete(Manager $manager, Branch $branch)
    {
        return $branch->company_id == $manager->company->id && ($manager->user_type == Manager::OWNER || $manager->user_type == Manager::FINANCE_MANAGER);
    }
}
