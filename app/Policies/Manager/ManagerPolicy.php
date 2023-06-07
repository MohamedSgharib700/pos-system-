<?php

namespace App\Policies\Manager;

use App\Models\User;
use App\Models\Manager;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManagerPolicy
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

  /**
   * Determine whether the owner manager can show this sub manager.
   *
   * @param  App\Models\Manager $owner
   * @param  App\Models\Manager $new_manager
   * @return bool
   */
    public function view(Manager $owner, Manager $new_manager)
    {
        return $new_manager->company_id === $owner->company_id;
    }

  /**
   * Determine whether the owner manager can update this sub manager.
   *
   * @param  App\Models\Manager $owner
   * @param  App\Models\Manager $new_manager
   * @return bool
   */
    public function update(Manager $owner, Manager $new_manager)
    {
        return $new_manager->company_id === $owner->company_id;
    }

    /**
   * Determine whether the owner manager can delete this sub manager.
   *
   * @param  App\Models\Manager $owner
   * @param  App\Models\Manager $new_manager
   * @return bool
   */
    public function delete(Manager $owner, Manager $new_manager)
    {
        return $new_manager->company_id === $owner->company_id;
    }
}
