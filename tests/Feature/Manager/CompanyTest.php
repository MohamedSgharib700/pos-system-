<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    protected static $manager;

    public function setUp(): void
    {
        parent::setUp();
        static::$manager = Manager::factory()->create(['user_type' => Manager::OWNER, 'company_id' => NULL])->syncRoles([Manager::OWNER]);
    }

    public function testStoreCompany()
    {
        $company = Company::newFactory()->raw();
        $company_data = [
            'finance_manager_id' => Manager::newFactory()->create(['user_type' => Manager::FINANCE_MANAGER, 'company_id' => NULL])->id,
        ];
        $company_data = $company_data + $company;

        $this->actingAs(static::$manager, 'manager');
        $this->json('POST', RouteServiceProvider::MANAGER_PREFIX . '/my/company', $company_data, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testUpdateCompany()
    {
        $company = Company::newFactory()->create();
        static::$manager->update(['company_id' => $company->id]);
        $company_data = [
            'name' => 'new company name for test',
            'finance_manager_id' => Manager::newFactory()->create(['user_type' => Manager::FINANCE_MANAGER, 'company_id' => NULL])->id,
        ];
        $company_data = $company_data + $company->toArray();
        $this->actingAs(static::$manager, 'manager');
        $this->json('PUT', RouteServiceProvider::MANAGER_PREFIX . '/my/company', $company_data, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testShowCompany()
    {
        $company = Company::newFactory()->create();
        static::$manager->update(['company_id' => $company->id]);
        $this->actingAs(static::$manager, 'manager');
        $this->json('get', RouteServiceProvider::MANAGER_PREFIX . '/my/company')
            ->assertStatus(200);
    }
}
