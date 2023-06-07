<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\PosUser\StoreRequest;
use App\Http\Requests\PosUser\UpdateRequest;
use App\Http\Resources\Pos_users\PosUserResource;
use App\Models\PosUser;
use App\Repositories\PosUser\PosUserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;

class PosUserController extends Controller
{
    /**
     * The posUser repository instance.
     *
     * @var App\Repositories\PosUser\PosUserRepository
     */
    private $posUserRepository;

     /**
     * The current logged in manager.
     *
     * @var App\Models\Manager
     */
    private $manager;

    /**
     * Create a new PosUserController instance.
     *
     * @param  App\Repositories\PosUser\PosUserRepository  $posUserRepository
     * @return void
     */
    public function __construct(PosUserRepository $posUserRepository)
    {
        $this->posUserRepository = $posUserRepository;
        $this->manager = auth('manager')->user();
        $this->middleware('permission:pos_user-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:pos_user-create', ['only' => ['store']]);
        $this->middleware('permission:pos_user-edit', ['only' => ['update']]);
        $this->middleware('permission:pos_user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:pos_user-unlock', ['only' => ['unlock']]);
    }

    /**
     * list all pos users.
     * @return App\Http\Resources\Pos_users\PosUserResource[]
    */
    public function index()
    {
        (! $this->manager->is_branch_manager) ?: $this->manager->load('branch');
        return $this->apiResponse(PosUserResource::collection($this->posUserRepository->all(
            $this->manager->is_branch_manager ? ['branch_id' => $this->manager->branch->id] : ['company_id' => $this->manager->company_id]
        )));
    }

    /**
     * create new posuser.
     * @param  App\Http\Requests\PosUser\StoreRequest $request
     * @return App\Http\Resources\Pos_users\PosUserResource
     */
    public function store(StoreRequest $request)
    {
        $pos_user = $this->posUserRepository->create($request->validated());
        return $this->apiResponse(new PosUserResource($pos_user));
    }

    /**
     * show posuser.
     * @param  App\Models\PosUser $pos_user
     * @return App\Http\Resources\Pos_users\PosUserResource
     */
    public function show(PosUser $pos_user)
    {
        return $this->apiResponse(new PosUserResource($pos_user));
    }

    /**
     * update posuser.
     * @param  App\Http\Requests\PosUser\UpdateRequest $request
     * @param int $id
     * @return App\Http\Resources\Pos_users\PosUserResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $this->posUserRepository->update($request->except(['email', 'password']), $id);
        $pos_user = $this->posUserRepository->show($id);
        return $this->apiResponse(new PosUserResource($pos_user));
    }

     /**
     * delete posuser.
     * @param App\Models\PosUser $pos_user
     * @return array ['message' => 'text message']
     */
    public function destroy(PosUser $pos_user)
    {
        $this->posUserRepository->destroy($pos_user);
        return $this->apiResponse(['message' => __('messages.deleted_successfuly')]);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function unlock($id) :JsonResponse
    {
        $pos_user = $this->manager->company->posUsers()->findOrFail($id);
        $this->authorize('unlock', ['ManagerPolicyForBranchManager', $pos_user->branch_id, $this->manager]);
        RateLimiter::clear($pos_user->blocked_key);
        $pos_user->update(['blocked_key' => NULL]);
        return $this->apiResponse(['message' => trans('general.pos_user_unlocked')]);
    }
}
