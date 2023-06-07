<?php
namespace App\Modules\Cities\Repositories;

use App\Modules\Cities\Entities\City;
use Carbon\Carbon;

class CityRepository implements CityRepositoryInterface
{
    // model property on class instances
    protected $city;

    // Constructor to bind model to repo
    public function __construct(City $city)
    {
        $this->city = $city;
    }

    // Get all instances of model
    public function getCities($keys)
    {
        $cities = $this->city->query();
        !isset($keys['name']) ?: $cities->where('name', 'LIKE', "%{$keys['name']}%");
        !isset($keys['area_id']) ?:$cities->where('area_id',$keys['area_id']);
        return $cities->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->city->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->city->findOrFail($id);
        $record->update($data);
        return $record;
    }

    // remove record from the database
    public function delete($id)
    {
        $record = $this->city->findOrFail($id);
        try {
            $record->delete();
        } catch (\Exception $e) {
            $record->deactivated_at = now();
            $record->update();
        }
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->city->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->city;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->city = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->city->with($relations);
    }
}
