<?php

namespace App\Repositories\Manager;

use App\Models\Manager;
use App\Modules\Branch\Entities\Branch;

class ManagerRepository
{
    // model property on class instances
    protected $manager;

    // Constructor to bind model to repo
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    // Get all instances of model
    public function all()
    {
        return $this->manager->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->manager->create($data);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->manager->findOrFail($id);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->manager->findOrFail($id);
        $record->update($data);
        return $record;
    }

    // remove record from the database
    public function destroy($manager)
    {
        try {
            $manager->delete();
        } catch (\Exception $e) {
            $manager->update(['deactivated_at' => now()]);
        }
        return true;
    }


    // Get the associated model
    public function getModel()
    {
        return $this->manager;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->manager = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->manager->with($relations);
    }

    public function getMySubManagers($company_id)
    {
        return $this->manager->where('company_id', $company_id)
                             ->where('id','<>',auth('manager')->id())
                             ->get();
    }

    public function getBranchManagersDontHaveBranch($keys)
    {
        $managers = $this->manager->whereCompanyId(auth()->user()->company_id)
                        ->whereUserType(Manager::BRANCH_MANAGER)
                        ->doesnthave('branch')->get();

        if (isset($keys['branch_id'])) {
            $manager = $this->manager->whereHas('branch', function ($q) use($keys){
                return $q->whereId($keys['branch_id']);
            })->first();
            $managers->push($manager);
        }
        return $managers->sortByDesc('id');
    }
}
