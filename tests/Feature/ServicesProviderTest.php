<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Modules\Banks\Entities\Bank;
use App\Modules\ServicesProviders\Entities\ServicesProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Tests\TestCase;

class ServicesProviderTest extends TestCase
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
        $this->withoutMiddleware(
            ThrottleRequests::class
        );

    }

    public function test_index_services_providers()
    {
        $response = $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/servicesproviders');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_store_services_providers()
    {
        $services_provider = ServicesProvider::factory()->raw();
        $response = $this->actingAs(static::$admin, 'admin')->postJson(RouteServiceProvider::ADMIN_PREFIX . '/servicesproviders', $services_provider);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_show_services_providers()
    {
        $response = $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/servicesproviders/' . ServicesProvider::inRandomOrder()->first()->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_update_services_providers()
    {
        $services_provider = ServicesProvider::factory()->raw();
        $response = $this->actingAs(static::$admin, 'admin')->patchJson(RouteServiceProvider::ADMIN_PREFIX . '/servicesproviders/' . ServicesProvider::inRandomOrder()->first()->id, $services_provider);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    public function test_delete_services_providers()
    {
        $response = $this->actingAs(static::$admin, 'admin')->delete(RouteServiceProvider::ADMIN_PREFIX . '/servicesproviders/' . ServicesProvider::inRandomOrder()->first()->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
