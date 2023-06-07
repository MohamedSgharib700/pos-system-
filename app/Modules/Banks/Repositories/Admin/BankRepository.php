<?php

namespace App\Modules\Banks\Repositories\Admin;

use App\Modules\Banks\Entities\Bank;

class BankRepository
{
    // model property on class instances
    protected $bank;

    // Constructor to bind model to repo
    public function __construct(Bank $bank)
    {
        $this->bank = $bank;
    }

    // Get all instances of model
    public function all()
    {
        return $this->bank->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->bank->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->bank->findOrFail($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($bank)
    {
        try {
            $bank->delete();
        } catch (\Exception $e) {
            $bank->update(['deactivated_at' => now()]);
        }
        return true;
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->bank->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->bank;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->bank = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->bank->with($relations);
    }

    // more
}
