<?php

namespace App\Repositories\PosUser;

use App\Models\PosUser;

class PosUserRepository
{
    // model property on class instances
    protected $pos_user;

    // Constructor to bind model to repo
    public function __construct(PosUser $pos_user)
    {
        $this->pos_user = $pos_user;
    }

    // Get all instances of model
    public function all($conditions = [], $with = [])
    {
        $query = $this->pos_user;
        $query = $conditions != [] ? $query->where($conditions) : $query;
        $query = $with != [] ? $query->with($with) : $query;
        return $query->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->pos_user->create($data);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->pos_user->findOrFail($id);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $pos_user = $this->pos_user->findOrFail($id);
        return $pos_user->update($data);
    }

    // remove record from the database
    public function destroy($pos_user)
    {
        try {
            $pos_user->delete();
        } catch (\Exception $e) {
            $pos_user->update(['deactivated_at' => now()]);
        }
        return true;
    }

    // Get the associated model
    public function getModel()
    {
        return $this->pos_user;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->pos_user = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->pos_user->with($relations);
    }
}
