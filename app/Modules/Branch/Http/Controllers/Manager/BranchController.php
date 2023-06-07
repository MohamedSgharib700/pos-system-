<?php

namespace App\Modules\Branch\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Entities\Branch;
use App\Modules\Branch\Http\Requests\Manager\BranchRequest;
use App\Modules\Branch\Repositories\Manager\BranchRepository;
use App\Modules\Branch\Transformers\Manager\BranchResource;

class BranchController extends Controller
{
    
    /**
     * Create a new BranchController instance.
     *
     * @param  \App\Modules\Branch\Repositories\Manager\BranchRepository  $branchRepository
     * @return void
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->middleware('permission:branch-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:branch-create', ['only' => ['store']]);
        $this->middleware('permission:branch-edit', ['only' => ['update']]);
        $this->middleware('permission:branch-delete', ['only' => ['destroy']]);
    }

    /**
     * List all branches.
     *
     * @return App\Modules\Branch\Transformers\Manager\BranchResource[]
    */
    public function index()
    {
        return $this->apiResponse(BranchResource::collection($this->branchRepository->all()));
    }

    /**
     * Create new branch.
     *
     * @return App\Modules\Branch\Transformers\Manager\BranchResource
    */
    public function store(BranchRequest $request)
    {
        $branch = $this->branchRepository->create($request->validated());
        return $this->apiResponse(new BranchResource($branch));
    }

     /**
     * Show branch info.
     *
     * @param int $id
     * @return App\Modules\Branch\Transformers\Manager\BranchResource
    */
    public function show($id)
    {
        return $this->apiResponse(new BranchResource($this->branchRepository->show($id)));
    }

    /**
     * Update branch.
     *
     * @param App\Modules\Branch\Http\Requests\Manager\BranchRequest $request
     * @param int $id
     * @return App\Modules\Branch\Transformers\Manager\BranchResource
    */
    public function update(BranchRequest $request, $id)
    {
        $branch = $this->branchRepository->update($request->validated(), $id);
        return $this->apiResponse(new BranchResource($branch));
    }

    /**
     * Delete branch.
     *
     * @param int $id
     * @return array ['message' => 'text message']
    */
    public function destroy($id)
    {
        $this->branchRepository->destroy($id);
        return $this->apiResponse([['message' => __('branch::messages.deleted_successfuly')]]);
    }
}
