<?php

namespace App\Http\Controllers\Admins;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\AdminRequest;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Resources\Admins\AdminResource;

/**
 *
 */
class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:admin-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
        $this->middleware('permission:admin-unlock', ['only' => ['unlock']]);
    }

    /**
     * show all admins in descending order.
     *
     * @return JsonResponse
     */
    public function index() :JsonResponse
    {
        $admins = Admin::orderBy('id', 'desc')->get();
        return $this->apiResponse(AdminResource::collection($admins));
    }

    /**
     * show current login admin information.
     *
     * @return JsonResponse
     */
    public function profile() :JsonResponse
    {
        $admin = Auth('admin-api')->user();
        return $this->apiResponse(new AdminResource($admin));
    }

    /**
     * create a new admin.
     *
     * @return JsonResponse
     */
    public function store(AdminRequest $request) :JsonResponse
    {
        $data = $request->all();
        $admin = Admin::create($data);
        $admin->syncRoles(request('roles'));
        return $this->apiResponse(new AdminResource($admin));
    }

    /**
     * show an admin information which has this id parameter.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id) :JsonResponse
    {
        $admin = Admin::find($id);
        return $this->apiResponse(new AdminResource($admin));
    }

    /**
     * update an admin information which has this id parameter.
     *
     * @param AdminRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(AdminRequest $request, $id) :JsonResponse
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $admin = Admin::find($id);
        $admin->update($data);
        $admin->syncRoles(request('roles'));
        return $this->apiResponse(new AdminResource($admin));
    }

    /**
     * delete an admin which has this id parameter.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id) :JsonResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->update(['deactivated_at' => now()]);
        return $this->apiResponse(['message'=>__('messages.deleted_successfuly')]);
    }

    /**
     * Unlock an admin .
     *
     * @param $id
     * @return JsonResponse
     */
    public function unlock($id) :JsonResponse
    {
        $admin = Admin::findOrFail($id);
        RateLimiter::clear($admin->blocked_key);
        $admin->update(['blocked_key' => NULL]);
        return $this->apiResponse(['message' => trans('general.admin_unlocked')]);
    }

}
