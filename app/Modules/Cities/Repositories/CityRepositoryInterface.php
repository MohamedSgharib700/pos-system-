<?php
namespace App\Modules\Cities\Repositories;

interface CityRepositoryInterface
{
    public function getCities($keys);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}
