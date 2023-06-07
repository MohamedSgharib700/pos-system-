<?php

namespace App\Modules\BanksAccounts\Repositories\Admin;

use App\Modules\BanksAccounts\Entities\BanksAccount;

class BanksAccountRepository
{
    // model property on class instances
    protected $banks_account;

    // Constructor to bind model to repo
    public function __construct(BanksAccount $banks_account)
    {
        $this->banks_account = $banks_account;
    }

    // Get all instances of model
    public function all()
    {
        return $this->banks_account->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->banks_account->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->banks_account->findOrFail($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($banks_account)
    {
        try {
            $banks_account->delete();
        } catch (\Exception $e) {
            $banks_account->update(['deactivated_at' => now()]);
        }
        return true;
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->banks_account->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->banks_account;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->banks_account = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->banks_account->with($relations);
    }
}
