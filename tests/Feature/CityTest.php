<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Modules\Areas\Entities\Area;
use App\Modules\Cities\Entities\City;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class CityTest extends TestCase
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

    public function testShowAllCities()
    {
        City::factory()->times(5)->create();
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/cities')
            ->assertStatus(200);
    }

    public function testCanCreateCity()
    {
        $this->actingAs(static::$admin, 'admin')
            ->post(RouteServiceProvider::ADMIN_PREFIX . '/cities', [
                'name' => ["en" => 'city1', "ar" => 'محافظة1'],
                'area_id' => Area::factory()->create()->id,
            ])
            ->assertStatus(200);
    }

    public function testCanShowCity()
    {
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/cities/' . City::factory()->create()->id)
            ->assertStatus(200);
    }

    public function testCanUpdateCity()
    {
        $city = City::factory()->create();
        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . '/cities/' . $city->id, [
            'name' => ["en" => 'city2', "ar" => 'محافظة2'],
            'area_id' => Area::factory()->create()->id,
            '_method' => 'PUT',
        ])
            ->assertStatus(200);
    }

    public function testCanDeleteCity()
    {
        $city = City::factory()->create();
        $this->actingAs(static::$admin, 'admin')->delete(RouteServiceProvider::ADMIN_PREFIX . '/cities/' . $city->id)
            ->assertStatus(200);
    }

    public function testCanExportExcelSheetOfCities()
    {
        $city = City::factory()->create();
        $this->actingAs(static::$admin, 'admin')->get(RouteServiceProvider::ADMIN_PREFIX . '/export_cities/')
            ->assertStatus(200);
    }
}
