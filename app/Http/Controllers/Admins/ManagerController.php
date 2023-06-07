<?php

namespace App\Http\Controllers\Admins;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\Admins\ManagerRequest;
use App\Http\Resources\Admins\OwnerResource;
use App\Http\Resources\Admins\ManagerResource;
use App\Repositories\Admins\ManagerRepository;
use App\Http\Requests\Admins\ChangeManagerStatus;

class ManagerController extends Controller
{
    /**
     * @var ManagerRepository
     */
    private $managerRepository;

    /**
     *
     * @param ManagerRepository $managerRepository
     */
    public function __construct(ManagerRepository $managerRepository)
    {
        $this->managerRepository = $managerRepository;
        $this->middleware('permission:manager-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:manager-create', ['only' => ['store']]);
        $this->middleware('permission:manager-edit', ['only' => ['update']]);
        $this->middleware('permission:manager-delete', ['only' => ['destroy']]);
        $this->middleware('permission:manager-activate', ['only' => ['changeStatus']]);
        $this->middleware('permission:manager-unlock', ['only' => ['unlock']]);
    }

    /**
     * Get all managers.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->apiResponse(ManagerResource::collection($this->managerRepository->all()));
    }

    /**
     * Create a manager.
     *
     * @param ManagerRequest $request
     * @return JsonResponse
     */
    public function store(ManagerRequest $request): JsonResponse
    {
        $manager = $this->managerRepository->create($request->validated());
        return $this->apiResponse(new ManagerResource($manager));
    }

    /**
     * Show a manager information.
     *
     * @param Manager $manager
     * @return JsonResponse
     */
    public function show(Manager $manager): JsonResponse
    {
        return $this->apiResponse(new ManagerResource($manager));
    }

    /**
     * Update a manager information.
     *
     * @param ManagerRequest $request
     * @param Manager $manager
     * @return JsonResponse
     */
    public function update(ManagerRequest $request, Manager $manager) :JsonResponse
    {
        $this->managerRepository->update($request->validated(), $manager);
        return $this->apiResponse(new ManagerResource($manager));
    }

    /**
     * Delete a manager.
     *
     * @param Manager $manager
     * @return JsonResponse
     */
    public function destroy(Manager $manager) :JsonResponse
    {
        $this->managerRepository->destroy($manager);
        return $this->apiResponse(['message'=>__('messages.deleted_successfuly')]);
    }

    /**
     * Get owners don't belong to any company.
     *
     * @return JsonResponse
     */
    public function getOwnersDoesntHaveCompany(): JsonResponse
    {
        $owners = $this->managerRepository->DoesNotHave('company');
        return $this->apiResponse(OwnerResource::collection($owners));
    }

    /**
     * Change manager status.
     *
     * @param Manager $manager
     * @param ChangeManagerStatus $request
     * @return JsonResponse
     */
    public function changeStatus(Manager $manager, ChangeManagerStatus $request): JsonResponse
    {
        $this->managerRepository->update(['is_active'=>$request->is_active], $manager);
        return $this->apiResponse(['message'=>trans('general.manager_activated')]);
    }

    /**
     * Get all branch managers of a company which haven't any branches.
     *
     * @param $company_id
     * @return JsonResponse
     */
    public function getBranchManagersOfCompanyDontHaveBranches($company_id): JsonResponse
    {
        $managers = $this->managerRepository->getBranchManagersOfCompanyDontHaveBranches($company_id);
        return $this->apiResponse(ManagerResource::collection($managers));
    }

    /**
     * Unlock an manager .
     *
     * @param Manager $manager
     * @return JsonResponse
     */
    public function unlock(Manager $manager) :JsonResponse
    {
        RateLimiter::clear($manager->blocked_key);
        $manager->update(['blocked_key' => NULL]);
        return $this->apiResponse(['message' => trans('general.manager_unlocked')]);
    }
}
