<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected static $admin;

    public function setUp(): void
    {
        parent::setUp();
        static::$admin = Admin::first();
    }

    public function testIndexCompany()
    {
        $companies = Company::newFactory()->count(2)->create();
        $this->actingAs(static::$admin, 'admin');
        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/companies', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($companies->first()->id);
    }

    public function testStoreCompany()
    {
        $company = Company::newFactory()->raw();
        $company_data = [
            'owner_id' => Manager::newFactory()->create(['user_type' => Manager::OWNER, 'company_id' => NULL])->id,
            'finance_manager_id' => Manager::newFactory()->create(['user_type' => Manager::FINANCE_MANAGER, 'company_id' => NULL])->id,
        ];
        $company_data = $company_data + $company;

        $this->actingAs(static::$admin, 'admin');
        $this->json('POST', RouteServiceProvider::ADMIN_PREFIX . '/companies', $company_data, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testShowCompany()
    {
        $company = Company::newFactory()->create();
        $this->actingAs(static::$admin, 'admin');
        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/companies/' . $company->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($company->id);
    }

    public function testUpdateCompany()
    {
        $company = Company::newFactory()->create();
        $company_data = [
            'name' => 'new company name for test',
            'finance_manager_id' => Manager::newFactory()->create(['user_type' => Manager::FINANCE_MANAGER, 'company_id' => NULL])->id,
        ];

        $company_data = $company_data + $company->toArray();
        $this->actingAs(static::$admin, 'admin');
        $this->json('PUT', RouteServiceProvider::ADMIN_PREFIX . '/companies/' . $company->id, $company_data, ['Accept' => 'application/json'])
            ->assertStatus(200);

        $this->assertTrue($company->fresh()->name == $company_data['name']);

    }

    public function testDeleteCompany()
    {
        $company = Company::newFactory()->create();
        $this->actingAs(static::$admin, 'admin');
        $this->json('DELETE', RouteServiceProvider::ADMIN_PREFIX . '/companies/' . $company->id, [], ['Accept' => 'application/json']);
        $this->assertModelMissing($company);
    }
}
