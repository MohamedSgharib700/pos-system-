<?php

namespace App\Modules\Permission\Http\Controllers\Manager;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Resources\Manager\ManagerResource;
use App\Modules\Permission\Transformers\RoleResource;
use App\Modules\Permission\Transformers\PermissionResource;

class RoleController extends Controller
{
    /**
     * Create a new RoleController instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:role-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * List all roles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Modules\Permission\Transformers\RoleResource[]
     */
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->where('guard_name','manager')->get();
        return $this->apiResponse(RoleResource::collection($roles));
    }

    /**
     * List all permissions.
     *
     * @return \App\Modules\Permission\Transformers\PermissionResource[]
    */
    public function allPermissions()
    {
        $permissions = Permission::where('guard_name','manager')->get();
        return $this->apiResponse(PermissionResource::collection($permissions->groupBy('order_by'))->values());
    }

    /**
     * Create new role.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Modules\Permission\Transformers\RoleResource
    */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'slug' => 'required|string|max:255|unique:roles,slug',
            'permission' => 'required|array',
            'permission.*' => 'required|string|exists:permissions,name,guard_name,manager',
        ], [
            'slug.required' => __('permission::validation.slug.required'),
            'slug.string' => __('permission::validation.slug.string'),
            'slug.max' => __('permission::validation.slug.max'),
            'slug.unique' => __('permission::validation.slug.unique'),
            'permission.required' => __('permission::validation.permission.required'),
            'permission.array' => __('permission::validation.permission.array'),
            'permission.*.required' => __('permission::validation.permission.*.required'),
            'permission.*.string' => __('permission::validation.permission.*.string'),
            'permission.*.exists' => __('permission::validation.permission.*.exists'),
        ]);
        $role = Role::create([
            'guard_name' => 'manager',
            'name' => "role-".time(),
            'slug' => $request->slug
        ]);
        $role->syncPermissions($request->input('permission'));
        return $this->apiResponse(['roles' => new RoleResource($role)]);

    }

    /**
     * Show role info.
     *
     * @param int $id
     * @return \App\Modules\Permission\Transformers\RoleResource
    */
    public function show($id)
    {
        $role = Role::with('permissions')
                    ->where('guard_name','manager')
                    ->findOrFail($id);
        return $this->apiResponse(['roles' => new RoleResource($role)]);
    }


    /**
     * Update role.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \App\Modules\Permission\Transformers\RoleResource
    */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'slug' => 'required|string|max:255|unique:roles,slug,'.$id.',id',
            'permission' => 'required|array',
            'permission.*' => 'required|string|exists:permissions,name,guard_name,manager',
        ], [
            'slug.required' => __('permission::validation.slug.required'),
            'slug.string' => __('permission::validation.slug.string'),
            'slug.max' => __('permission::validation.slug.max'),
            'slug.unique' => __('permission::validation.slug.unique'),
            'permission.required' => __('permission::validation.permission.required'),
            'permission.array' => __('permission::validation.permission.array'),
            'permission.*.required' => __('permission::validation.permission.*.required'),
            'permission.*.string' => __('permission::validation.permission.*.string'),
            'permission.*.exists' => __('permission::validation.permission.*.exists'),
        ]);
        $role = Role::where('guard_name','manager')->findOrFail($id);
        $role->slug = $request->slug;
        $role->save();

        $role->syncPermissions($request->input('permission'));
        return $this->apiResponse(['roles' => new RoleResource($role)]);

    }

    /**
     * Delete role.
     *
     * @param int $id
     * @return array ['message' => 'text message']
    */
    public function destroy($id)
    {
        return DB::transaction(function() use($id){
            Role::where('guard_name','manager')
            ->findOrFail($id)
            ->delete();
            DB::table("model_has_roles")->where('role_id', $id)->delete();
            return $this->apiResponse(['message'=>__('messages.deleted_successfuly')]);
        });

    }

    /**
     * Get all managers has specific role by roleName.
     *
     * @param string $roleName
     * @return \App\Http\Resources\Manager\ManagerResource[]
    */
    public function ManagersHasRole($roleName)
    {
        $managers= Manager::role($roleName)->get();
        return $this->apiResponse(ManagerResource::collection($managers));
    }
}
