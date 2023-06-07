<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use App\Models\PosUser;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class PosUserTest extends TestCase
{
    protected static $manager;

    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$manager = Manager::factory()->create()->syncRoles([Manager::OWNER]);
            static::$setupRun = true;
        }
    }

    public function testIndexPosUser()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX . '/pos-users');
        $response->assertStatus(200);
    }

    public function testStorePosUser()
    {
        $pos_user = PosUser::factory()->raw([
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response = $this->actingAs(static::$manager, 'manager')->postJson(RouteServiceProvider::MANAGER_PREFIX . '/pos-users', $pos_user);
        $response->assertStatus(200);
    }

    public function testShowPosUser()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX . '/pos-users/' . PosUser::inRandomOrder()->first()->id);
        $response->assertStatus(200);
    }

    public function testUpdatePosUser()
    {
        $pos_user = PosUser::factory()->raw([
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response = $this->actingAs(static::$manager, 'manager')->patchJson(RouteServiceProvider::MANAGER_PREFIX . '/pos-users/' . PosUser::inRandomOrder()->first()->id, $pos_user);
        $response->assertStatus(200);
    }

    public function testDestroyPosUser()
    {
        $response = $this->actingAs(static::$manager, 'manager')->delete(RouteServiceProvider::MANAGER_PREFIX . '/pos-users/' . PosUser::inRandomOrder()->first()->id);
        $response->assertStatus(200);
    }
}
