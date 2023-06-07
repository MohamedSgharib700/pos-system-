<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use App\Modules\Permission\Entities\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Permission\Transformers\PermissionResource;
use App\Providers\RouteServiceProvider;

class PermissionTest extends TestCase
{
    protected static $admin;
    protected static $manager;

    public function setUp(): void
    {
        parent::setUp();
        static::$admin = Admin::first();
        static::$manager = Manager::first();
    }

    public function testStoreRoleForAdminGuard()
    {
        $role = Role::newFactory()->make();

        $permissions = Permission::where('guard_name',$role->guard_name)->inRandomOrder()->take(5)->get();

        $this->actingAs(static::$admin, 'admin');

        $this->json('POST', RouteServiceProvider::ADMIN_PREFIX . '/roles', $role->toArray() + ['permission'=>$permissions->pluck('name')->toArray()], ['Accept' => 'application/json'])
            ->assertStatus(200);

            $this->assertDatabaseHas('roles',[
                'slug' => $role->slug,
            ]);

    }


    public function testShowRoleForAdminGuard()
    {
        $role = Role::newFactory()->create();

         $this->actingAs(static::$admin, 'admin');

        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/roles/'.$role->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($role->id);
    }


    public function testUpdateRoleForAdminGuard()
    {
        $role = Role::newFactory()->create();

        $permissions = Permission::where('guard_name',$role->guard_name)->inRandomOrder()->take(5)->get();

        $role_data = [
            'slug' => 'admin-new_slug-'.Str::random(10),
        ];

        $role_data = $role_data + $role->toArray();

         $this->actingAs(static::$admin, 'admin');

        $this->json('PUT', RouteServiceProvider::ADMIN_PREFIX . '/roles/'.$role->id, $role_data + ['permission'=>$permissions->pluck('name')->toArray()], ['Accept' => 'application/json'])
            ->assertStatus(200);

            $this->assertTrue( ($role->fresh()->slug == $role_data['slug']
                                &&
                                $role->permissions->contains('id',$permissions->first()->id))
                            );

    }

    public function testDeleteRoleForAdminGuard()
    {
        $role = Role::newFactory()->create();

        $this->actingAs(static::$admin, 'admin');

        $this->json('DELETE', RouteServiceProvider::ADMIN_PREFIX . '/roles/'.$role->id, [], ['Accept' => 'application/json']);
        $this->assertModelMissing($role);
    }

    public function testIndexRoleForAdminGuard()
    {
        $roles = Role::newFactory()->count(2)->create();

         $this->actingAs(static::$admin, 'admin');

        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/roles', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($roles->first()->id);

    }

    public function testAllPermissionsForAdminGuard()
    {
        $permissions = Permission::where('guard_name','admin')->get();

        $perms_count = PermissionResource::collection($permissions->groupBy('order_by'))->values()->count();

        $this->actingAs(static::$admin, 'admin');

        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/permissions', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonCount($perms_count,'data');

    }

    //test methods for manager guard

    public function testStoreRoleForManagerGuard()
    {
        $role = Role::newFactory()->make(['guard_name'=>'manager']);

        $permissions = Permission::where('guard_name',$role->guard_name)->inRandomOrder()->take(5)->get();

        $this->actingAs(static::$manager, 'manager');

        $this->json('POST', RouteServiceProvider::MANAGER_PREFIX . '/roles', $role->toArray() + ['permission'=>$permissions->pluck('name')->toArray()], ['Accept' => 'application/json'])
            ->assertStatus(200);

            $this->assertDatabaseHas('roles',[
                'slug' => $role->slug,
            ]);

    }


    public function testShowRoleForManagerGuard()
    {
        $role = Role::newFactory()->create(['guard_name'=>'manager']);

         $this->actingAs(static::$manager, 'manager');

        $this->json('GET', RouteServiceProvider::MANAGER_PREFIX . '/roles/'.$role->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($role->id);
    }


    public function testUpdateRoleForManagerGuard()
    {
        $role = Role::newFactory()->create(['guard_name'=>'manager']);

        $permissions = Permission::where('guard_name',$role->guard_name)->inRandomOrder()->take(5)->get();

        $role_data = [
            'slug' => 'manager-new_slug-'.Str::random(10),
        ];

        $role_data = $role_data + $role->toArray();

         $this->actingAs(static::$manager, 'manager');

        $this->json('PUT', RouteServiceProvider::MANAGER_PREFIX . '/roles/'.$role->id, $role_data + ['permission'=>$permissions->pluck('name')->toArray()], ['Accept' => 'application/json'])
            ->assertStatus(200);

        $this->assertTrue( ($role->fresh()->slug == $role_data['slug']
                           &&
                           $role->permissions->contains('id',$permissions->first()->id)));

    }

    public function testDeleteRoleForManagerGuard()
    {
        $role = Role::newFactory()->create(['guard_name'=>'manager']);

        $this->actingAs(static::$manager, 'manager');

        $this->json('DELETE', RouteServiceProvider::MANAGER_PREFIX . '/roles/'.$role->id, [], ['Accept' => 'application/json']);
        $this->assertModelMissing($role);
    }

    public function testIndexRoleForManagerGuard()
    {
        $roles = Role::newFactory()->count(2)->create(['guard_name'=>'manager']);

         $this->actingAs(static::$manager, 'manager');

        $this->json('GET', RouteServiceProvider::MANAGER_PREFIX . '/roles', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($roles->first()->id);

    }

    public function testAllPermissionsForManagerGuard()
    {
        $permissions = Permission::where('guard_name','manager')->get();

        $perms_count = PermissionResource::collection($permissions->groupBy('order_by'))->values()->count();

        $this->actingAs(static::$manager, 'manager');

        $this->json('GET', RouteServiceProvider::MANAGER_PREFIX . '/permissions', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonCount($perms_count,'data');

    }
}
