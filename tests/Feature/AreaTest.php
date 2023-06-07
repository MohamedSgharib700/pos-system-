<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Modules\Areas\Entities\Area;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaTest extends TestCase
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

    public function testShowAllAreas()
    {
        Area::factory()->times(5)->create();
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/areas')
            ->assertStatus(200);
    }

    public function testCanCreateArea()
    {
        $this->actingAs(static::$admin, 'admin')
            ->post(RouteServiceProvider::ADMIN_PREFIX . '/areas', [
                'name' => ["en" => 'area1', "ar" => 'المنطفة1']
            ])
            ->assertStatus(200);
    }

    public function testCanShowArea()
    {
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/areas/' . Area::factory()->create()->id)
            ->assertStatus(200);
    }

    public function testCanUpdateArea()
    {
        $area = Area::factory()->create();
        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . '/areas/' . $area->id, [
            'name' => ["en" => 'area 2', "ar" => 'منطقة 2'],
            '_method' => 'PUT',
        ])
            ->assertStatus(200);
    }

    public function testCanDeleteArea()
    {
        $area = Area::factory()->create();
        $this->actingAs(static::$admin, 'admin')->delete(RouteServiceProvider::ADMIN_PREFIX . '/areas/' . $area->id)
            ->assertStatus(200);
    }

    public function testCanExpoAreas()
    {
        $area = Area::factory()->create();
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/export_areas/')
            ->assertStatus(200);
    }
}
