<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class BanksAccountsTest extends TestCase
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

    public function test_index_banks_accounts()
    {
        $response = $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/banks_accounts');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_store_banks_accounts()
    {
        $banks_account = BanksAccount::factory()->raw();
        $response = $this->actingAs(static::$admin, 'admin')->postJson(RouteServiceProvider::ADMIN_PREFIX . '/banks_accounts', $banks_account);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_show_banks_accounts()
    {
        $response = $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/banks_accounts/' . BanksAccount::inRandomOrder()->first()->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_update_banks_accounts()
    {
        $banks_account = BanksAccount::factory()->raw();
        $response = $this->actingAs(static::$admin, 'admin')->patchJson(RouteServiceProvider::ADMIN_PREFIX . '/banks_accounts/' . BanksAccount::inRandomOrder()->first()->id, $banks_account);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_delete_banks_accounts()
    {
        $response = $this->actingAs(static::$admin, 'admin')->delete(RouteServiceProvider::ADMIN_PREFIX . '/banks_accounts/' . BanksAccount::inRandomOrder()->first()->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
