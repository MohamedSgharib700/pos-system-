<?php

namespace App\Modules\Branch\Repositories\Admin;

use App\Modules\Branch\Entities\Branch;
use App\Modules\Branch\Http\Requests\Admin\BranchRequest;
use App\Modules\Branch\Transformers\Admin\BranchResource;

class BranchRepository
{
    public function all()
    {
        return Branch::with('posUsers')->orderBy('id', 'desc')->get();
    }

    public function filter()
    {
        $branches = Branch::query();
        return $branches->orderBy('id', 'desc')->get();
    }

    public function create($data)
    {
        return Branch::create($data);
    }

    public function update($data, $branch)
    {
        $branch->update($data);
        return $branch;
    }

    public function destroy($branch)
    {
        try {
            $branch->delete();
        } catch (\Exception $e) {
            $branch->update(['deactivated_at' => now()]);
        }
        return true;
    }

}
