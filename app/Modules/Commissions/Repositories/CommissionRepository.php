<?php
namespace App\Modules\Commissions\Repositories;

use App\Modules\Commissions\Entities\Commission;


class CommissionRepository implements CommissionRepositoryInterface
{
    // model property on class instances
    protected $commission;

    // Constructor to bind model to repo
    public function __construct(Commission $commission)
    {
        $this->commission = $commission;
    }

    // Get all instances of model
    public function all()
    {
        return $this->commission->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->commission->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->commission->findOrFail($id);
        return $record->update($data);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->commission->findOrFail($id);
    }

     // Eager load database relationships
    public function loadRelations($model, array $relations)
    {
        return $model->load($relations);
    }


}
