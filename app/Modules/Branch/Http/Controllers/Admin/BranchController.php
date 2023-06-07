<?php

namespace App\Modules\Branch\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Entities\Branch;
use App\Modules\Branch\Http\Requests\Admin\BranchRequest;
use App\Modules\Branch\Repositories\Admin\BranchRepository;
use App\Modules\Branch\Transformers\Admin\BranchResource;

class BranchController extends Controller
{
    /**
     * The branch repository instance for query database.
     *
     * @var \App\Modules\Branch\Repositories\Admin\BranchRepository
     */
    private $branchRepository;

     /**
     * Create a new BranchController instance.
     *
     * @param  \App\Modules\Branch\Repositories\Admin\BranchRepository  $branchRepository
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
     * @return App\Modules\Branch\Transformers\Admin\BranchResource[]
     */
    public function index()
    {
        return $this->apiResponse(BranchResource::collection($this->branchRepository->all()));
    }

    /**
     * Create a new branch.
     *
     * @param  App\Modules\Branch\Http\Requests\Admin\BranchRequest $request
     * @return App\Modules\Branch\Transformers\Admin\BranchResource
     */
    public function store(BranchRequest $request)
    {
        $branch = $this->branchRepository->create($request->validated());
        return $this->apiResponse(new BranchResource($branch));
    }

     /**
     * Show branch info.
     *
     * @param  App\Modules\Branch\Entities\Branch $branch
     * @return App\Modules\Branch\Transformers\Admin\BranchResource
     */
    public function show(Branch $branch)
    {
        return $this->apiResponse(new BranchResource($branch));
    }

    /**
     * Update branch info.
     *
     * @param  App\Modules\Branch\Http\Requests\Admin\BranchRequest $request
     * @param  App\Modules\Branch\Entities\Branch $branch
     * @return App\Modules\Branch\Transformers\Admin\BranchResource
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        $this->branchRepository->update($request->validated(), $branch);
        return $this->apiResponse(new BranchResource($branch));
    }

     /**
     * Delete branch.
     *
     * @param  App\Modules\Branch\Entities\Branch $branch
     * @return array ['message' => 'text message']
     */
    public function destroy(Branch $branch)
    {
        $this->branchRepository->destroy($branch);
        return $this->apiResponse([['message'=>__('branch::messages.deleted_successfuly')]]);
    }
}
