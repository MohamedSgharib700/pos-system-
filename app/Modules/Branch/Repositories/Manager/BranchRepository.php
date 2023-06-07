<?php

namespace App\Modules\Branch\Repositories\Manager;

use App\Modules\Branch\Entities\Branch;

class BranchRepository
{
    public function all()
    {
        return auth()->user()->company->branches()->with('posUsers')->orderBy('id', 'desc')->get();
    }

    public function show($id)
    {
        return auth()->user()->company->branches()->findOrFail($id);
    }

    public function create($data)
    {
        return auth()->user()->company->branches()->create($data);
    }

    public function update($data, $id)
    {
        $branch = auth()->user()->company->branches()->findOrFail($id);
        $branch->update($data);
        $branch->refresh();
        return $branch;
    }

    public function destroy($id)
    {
        $branch = auth()->user()->company->branches()->findOrFail($id);
        try {
            $branch->delete();
        } catch (\Exception $e) {
            $branch->update(['deactivated_at' => now()]);
        }
        return true;
    }
}
