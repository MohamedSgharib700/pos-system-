<?php

namespace App\Modules\ServicesProviders\Repositories\Admin;

use App\Modules\ServicesProviders\Entities\ServicesProvider;

class ServicesProviderRepository
{
    // model property on class instances
    protected $servicesProvider;

    // Constructor to bind model to repo
    public function __construct(ServicesProvider $servicesProvider)
    {
        $this->servicesProvider = $servicesProvider;
    }

    // Get all instances of model
    public function all()
    {
        return $this->servicesProvider->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->servicesProvider->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->servicesProvider->findOrFail($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($servicesProvider)
    {
        try {
            $servicesProvider->delete();
        } catch (\Exception $e) {
            $servicesProvider->update(['deactivated_at' => now()]);
        }
        return true;
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->servicesProvider->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->servicesProvider;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->servicesProvider = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->servicesProvider->with($relations);
    }

    // more
}
