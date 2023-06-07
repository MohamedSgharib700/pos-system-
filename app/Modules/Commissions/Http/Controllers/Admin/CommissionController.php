<?php

namespace App\Modules\Commissions\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use App\Modules\Commissions\Repositories\CommissionRepository;
use App\Modules\Commissions\Http\Requests\Admin\CommissionRequest;
use App\Modules\Commissions\Transformers\Admin\CommissionResource;
use App\Modules\Commissions\Http\Requests\Admin\DeleteCommissionsRequest;

class CommissionController extends Controller
{
    /**
     * Commission repository instance for query database.
     * @var \App\Modules\Commissions\Repositories\CommissionRepository
     */
    private $commission_repository;

    /**
     * Create a new CommissionController instance.
     *
     * @param  \App\Modules\Commissions\Repositories\CommissionRepository  $commission_repository
     * @return void
     */
    public function __construct(CommissionRepository $commission_repository)
    {
        $this->commission_repository = $commission_repository;
        $this->middleware('permission:commission-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:commission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:commission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:commission-delete', ['only' => ['destroy']]);
        $this->middleware('permission:commission-delete-many', ['only' => ['destroyMany']]);
    }

    /**
     * List all commissions.
     *
     * @return \App\Modules\Commissions\Transformers\Admin\CommissionResource[]
     */
    public function index()
    {
        $commissions = $this->commission_repository->all();
        $commissions = $this->commission_repository->loadRelations($commissions,['company']);
        return $this->apiResponse(CommissionResource::collection($commissions));
    }

    /**
     * Create new commission.
     * @param \App\Modules\Commissions\Http\Requests\Admin\CommissionRequest $request
     * @return \App\Modules\Commissions\Transformers\Admin\CommissionResource
     */
    public function store(CommissionRequest $request)
    {
        $commission = $this->commission_repository->create($request->validated());
        $commission = $this->commission_repository->loadRelations($commission,['company']);
        return $this->apiResponse(new CommissionResource($commission));
    }

    /**
     * Show commission info.
     * @param int $id
     * @return \App\Modules\Commissions\Transformers\Admin\CommissionResource
     */
    public function show($id)
    {
        $commission = $this->commission_repository->show($id);
        $commission = $this->commission_repository->loadRelations($commission,['company']);
        return $this->apiResponse(new CommissionResource($commission));
    }

   /**
     * Update commission.
     * @param \App\Modules\Commissions\Http\Requests\Admin\CommissionRequest $request
     * @param int $id
     * @return \App\Modules\Commissions\Transformers\Admin\CommissionResource
     */
    public function update(CommissionRequest $request, $id)
    {
        $this->commission_repository->update($request->validated(), $id);
        $commission = $this->commission_repository->show($id);
        $commission = $this->commission_repository->loadRelations($commission,['company']);
        return $this->apiResponse(new CommissionResource($commission));
    }

}
