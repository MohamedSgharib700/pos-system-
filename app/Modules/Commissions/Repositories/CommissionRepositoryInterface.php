<?php
namespace App\Modules\Commissions\Repositories;

interface CommissionRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function show($id);
}