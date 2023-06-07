<?php
namespace App\Modules\Areas\Repositories;

use App\Modules\Areas\Entities\Area;
class AreaRepository implements AreaRepositoryInterface
{
    // model property on class instances
    protected $area;

    // Constructor to bind model to repo
    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    // Get all instances of model
    public function getAreas($keys)
    {
        $areas = $this->area->query();
        !isset($keys['name']) ?: $areas->where('name', 'LIKE', "%{$keys['name']}%");
        return $areas->orderBy('id', 'desc')->get();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->area->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->area->findOrFail($id);
        $record->update($data);
        return $record;
    }

    // remove record from the database
    public function delete($id)
    {
        $record = $this->area->findOrFail($id);
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
        return $this->area->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->area;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->area = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->area->with($relations);
    }
}
