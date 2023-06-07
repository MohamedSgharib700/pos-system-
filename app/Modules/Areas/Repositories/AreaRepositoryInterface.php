<?php
namespace App\Modules\Areas\Repositories;

interface AreaRepositoryInterface
{
    public function getAreas($keys);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}
