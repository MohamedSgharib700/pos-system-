<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;
use Illuminate\Support\Str;

class AdminTest extends TestCase
{
    protected static $admin;
    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$admin = Admin::factory()->create()->syncRoles(['GeneralManager']);
            static::$setupRun = true;
        }
    }

    public function testIndexAdmins()
    {
        Admin::factory()->times(5)->create();
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/admins')
            ->assertStatus(200);
    }

    public function testProfileAdmin()
    {
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX.'/profile')
            ->assertStatus(200);
    }

    public function testStoreAdmin()
    {
        $this->post(RouteServiceProvider::ADMIN_PREFIX.'/admins', [
                'name' => 'admin',
                'email' => 'admin1@admin2.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                "roles" => "GeneralManager"
            ])
            ->assertStatus(200);
    }

    public function testShowAdmin()
    {
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX.'/admins/' . Admin::factory()->create()->id)
            ->assertStatus(200);
    }

    public function testUpdateAdmin()
    {
        $this->actingAs(static::$admin, 'admin')->put(RouteServiceProvider::ADMIN_PREFIX.'/admins/' . Admin::factory()->create()->id, [
                'name' => 'admin',
                'email' => 'admin1@admin3.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                "roles" => "GeneralManager"
            ])
            ->assertStatus(200);
    }

    public function testUnlock()
    {
        $admin = Admin::factory()->create([
            'blocked_key' => Str::random(20)
        ]);

        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . "/admins/unlock/{$admin->id}")
            ->assertStatus(200);

        $this->assertDatabaseHas('admins',[
            'id' => $admin->id,
            'blocked_key' => NULL,
        ]);
    }
}
