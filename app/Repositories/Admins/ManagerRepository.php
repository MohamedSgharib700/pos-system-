<?php

namespace App\Repositories\Admins;

use App\Models\Manager;
use Illuminate\Validation\ValidationException;

class ManagerRepository
{
    public function all()
    {
        return $this->filter()->get();
    }

    public function filter()
    {
        $managers = Manager::query();
        $managers->when(request()->has('has_delegation') && request('has_delegation') == 1 , function($q){
                    $q->whereNotNull('delegation_file');
                })->when(request()->has('has_delegation') && request('has_delegation') == 0, function($q){
                    $q->whereNull('delegation_file');
                })->when(request()->has('has_company'), function($q){
                    request('has_company') == 1 ? $q->whereHas('company') : $q->whereDoesntHave('company');
                })->when(request()->has('is_active'), function($q){
                    $q->where('is_active',request('is_active'));
                });

        return $managers->orderBy('id', 'desc');
    }

    public function create($data)
    {
        return Manager::create($data);
    }

    public function update($data, $manager)
    {
        $manager->update($data);
        return $manager;
    }

    public function destroy($manager)
    {
        try {
            if(!$manager->company()->exists()) {
                $manager->delete();
            }
            throw new \Exception;
        } catch (\Exception $e) {
            $manager->update(['deactivated_at' => now()]);
        }
        return true;
    }

    public function DoesNotHave($relation)
    {
        return Manager::doesntHave($relation)
                      ->isActivated()
                      ->orderBy('id', 'desc')
                      ->get();
    }

    public function getBranchManagersOfCompanyDontHaveBranches($company_id)
    {
        return Manager::whereCompanyId($company_id)
                        ->whereUserType(Manager::BRANCH_MANAGER)
                        ->doesntHave('branch')
                        ->orderBy('id', 'desc')
                        ->get();
    }

}
