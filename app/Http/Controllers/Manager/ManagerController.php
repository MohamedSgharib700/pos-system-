<?php

namespace App\Http\Controllers\Manager;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreRequest;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\Manager\UpdateRequest;
use App\Http\Requests\Manager\ManagerRequest;
use App\Http\Resources\Manager\ManagerResource;
use App\Repositories\Manager\ManagerRepository;
use App\Http\Requests\Manager\ChangeManagerStatus;
use App\Http\Requests\Manager\BranchManagerRequest;

class ManagerController extends Controller
{
    /**
     * The manager repository instance.
     *
     * @var App\Repositories\Manager\ManagerRepository
     */
    private $managerRepository;
    /**
     * current authenticated manager instance.
     *
     * @var App\Models\Manager
     */
    private $owner;

    /**
     * Create a new ManagerController instance.
     *
     * @param  App\Repositories\Manager\ManagerRepository  $managerRepository
     * @return void
     */
    public function __construct(ManagerRepository $managerRepository)
    {
        $this->owner = auth('manager')->user();
        $this->managerRepository = $managerRepository;
        $this->middleware('permission:manager-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:manager-create', ['only' => ['store']]);
        $this->middleware('permission:manager-edit', ['only' => ['update']]);
        $this->middleware('permission:manager-delete', ['only' => ['destroy']]);
        $this->middleware('permission:manager-activate', ['only' => ['changeStatus']]);
        $this->middleware('permission:manager-unlock', ['only' => ['unlock']]);
        $this->middleware('can.owner.create.financialManager')->only('store');
        $this->middleware('can.activate.financialManager')->only('changeStatus');
    }

    /**
     * list all managers for followed to currenct authenticated manager.
     * @return App\Http\Resources\Manager\ManagerResource[]
    */
    public function index()
    {
        $this->owner->load('company');
        $managers = $this->managerRepository->getMySubManagers($this->owner->company->id);
        return $this->apiResponse(ManagerResource::collection($managers));
    }

    /**
     * create new finance or branch manager for current authenticated manager.
     * @param  App\Http\Requests\Manager\StoreRequest $request
     * @return App\Http\Resources\Manager\ManagerResource
     */
    public function store(StoreRequest $request)
    {
        return DB::transaction(function() use($request){
                    $this->owner->load('company');
                    $manager = $this->managerRepository->create($request->validated() + ['is_active'=>true, 'company_id'=>$this->owner->company->id]);
                    $manager->assignRole($request->user_type);
                    return $this->apiResponse(new ManagerResource($manager));
               });
    }

    /**
     * Show finance or branch manager for current authenticated manager.
     * @param  int $id
     * @return App\Http\Resources\Manager\ManagerResource
     */
    public function show($id)
    {
        $manager = $this->managerRepository->show($id);
        $this->authorize('view', ['ManagerPolicyForOwner', $manager, $this->owner]);
        return $this->apiResponse(new ManagerResource($manager));
    }

    /**
     * Update finance or branch manager for current authenticated manager.
     * @param  App\Http\Requests\Manager\UpdateRequest $request
     * @param  int $id
     * @return App\Http\Resources\Manager\ManagerResource
     */
    public function update(UpdateRequest $request, $id)
    {
        return DB::transaction(function() use($request, $id){
            $manager = $this->managerRepository->show($id);
            $this->authorize('update', ['ManagerPolicyForOwner', $manager, $this->owner]);
            $manager = $this->managerRepository->update($request->validated(), $id);
            $manager->syncRoles([$request->user_type]);
            return $this->apiResponse(new ManagerResource($manager));
       });
    }

     /**
     * Delete finance or branch manager for current authenticated manager.
     * @param  int $id
     * @return array ['message' => 'text message']
     */
    public function destroy($id)
    {
        $manager = $this->managerRepository->show($id);
        $this->authorize('delete', ['ManagerPolicyForOwner', $manager, $this->owner]);
        $this->managerRepository->destroy($manager);
        return $this->apiResponse(['message'=>__('messages.deleted_successfuly')]);
    }

    /**
     * Change status finance or branch manager for current authenticated manager.
     * @param  int $id
     * @param  App\Http\Requests\Manager\ChangeManagerStatus $request
     * @return array ['message' => 'text message']
     */
    public function changeStatus($id, ChangeManagerStatus $request)
    {
        $manager = $this->managerRepository->show($id);
        $this->authorize('update', ['ManagerPolicyForOwner', $manager, $this->owner]);
        $this->managerRepository->update(['is_active' => $request->is_active], $manager->id);
        return $this->apiResponse(['message'=>trans('general.manager_activated')]);
    }

    /**
     * list all branch managers doesnot have branch followed to current authenticated manager.
     * @return App\Http\Resources\Manager\ManagerResource[]
     */
    public function getBranchManagersdontHaveBranches(BranchManagerRequest $request)
    {
        $manager = $this->managerRepository->getBranchManagersDontHaveBranch($request->validated());
        return $this->apiResponse(ManagerResource::collection($manager));
    }

    /**
     * Unlock an manager .
     *
     * @param int $id
     * @return array ['message' => 'text message']
     */
    public function unlock($id)
    {
        $manager = $this->managerRepository->show($id);
        $this->authorize('view', ['ManagerPolicyForOwner', $manager, $this->owner]);
        RateLimiter::clear($manager->blocked_key);
        $manager->update(['blocked_key' => NULL]);
        return $this->apiResponse(['message' => trans('general.manager_unlocked')]);
    }
}
