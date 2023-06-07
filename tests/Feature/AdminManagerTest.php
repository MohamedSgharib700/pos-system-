<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;

class AdminManagerTest extends TestCase
{
    protected static $admin;
    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$admin = Admin::first();
            static::$setupRun = true;
        }
    }

    public function testIndexManager()
    {
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/managers')
            ->assertStatus(200);
    }

    public function testStoreManager()
    {
        $manager = Manager::factory()->raw([
            'user_type' => Manager::OWNER,
            'password'  => 'password',
            'password_confirmation' => 'password',
        ]);
        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . '/managers', $manager)
            ->assertStatus(200);
    }

    public function testShowManager()
    {
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/managers/' . Manager::inRandomOrder()->first()->id)
            ->assertStatus(200);
    }

    public function testUpdateManager()
    {
        $manager = Manager::factory()->raw([
            'user_type' => Manager::OWNER,
            'password'  => 'password',
            'password_confirmation' => 'password',
        ]);
        $this->actingAs(static::$admin, 'admin')->patch(RouteServiceProvider::ADMIN_PREFIX . '/managers/' . Manager::inRandomOrder()->first()->id, $manager)
            ->assertStatus(200);
    }

    public function testDestroyManager()
    {
        $this->actingAs(static::$admin, 'admin')->delete(RouteServiceProvider::ADMIN_PREFIX . '/managers/' . Manager::whereNotIn('id', [1])->inRandomOrder()->first()->id)
            ->assertStatus(200);
    }

    public function testChangeStatus()
    {
        $manager = Manager::factory()->create([
            'user_type' => Manager::OWNER,
        ]);

        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . "/managers/{$manager->id}/change-status", ['is_active' => true])
            ->assertStatus(200);

        $this->assertDatabaseHas('managers',[
            'id' => $manager->id,
            'is_active' => true,
        ]);
    }

    public function testUnlock()
    {
        $manager = Manager::factory()->create([
            'user_type' => Manager::OWNER,
            'blocked_key' => Str::random(20)
        ]);

        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . "/managers/unlock/{$manager->id}")
            ->assertStatus(200);

        $this->assertDatabaseHas('managers',[
            'id' => $manager->id,
            'blocked_key' => NULL,
        ]);
    }
}
