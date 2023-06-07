<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Modules\Banks\Entities\Bank;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class BanksTest extends TestCase
{
    protected static $admin;

    protected static $migrationRun = false;

    public function setUp(): void
    {
        parent::setUp();
        static::$admin = Admin::first();
        if (!static::$migrationRun) {
            static::$migrationRun = true;
        }
    }

    public function test_index_banks()
    {
        $response = $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/banks');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_store_banks()
    {
        $bank = Bank::factory()->raw();
        $response = $this->actingAs(static::$admin, 'admin')->postJson(RouteServiceProvider::ADMIN_PREFIX . '/banks', $bank);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_show_banks()
    {
        $response = $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/banks/' . Bank::inRandomOrder()->first()->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_update_banks()
    {
        $bank = Bank::factory()->raw();
        $response = $this->actingAs(static::$admin, 'admin')->patchJson(RouteServiceProvider::ADMIN_PREFIX . '/banks/' . Bank::inRandomOrder()->first()->id, $bank);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_delete_banks()
    {
        $response = $this->actingAs(static::$admin, 'admin')->delete(RouteServiceProvider::ADMIN_PREFIX . '/banks/' . Bank::inRandomOrder()->first()->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
