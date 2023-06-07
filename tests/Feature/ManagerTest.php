<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Manager;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use App\Modules\Company\Entities\Company;

class ManagerTest extends TestCase
{
    protected static $manager;

    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            $company = Company::newFactory()->create();
            static::$manager = Manager::factory()->create(['company_id' => $company->id, 'user_type' => Manager::OWNER])->syncRoles([Manager::OWNER]);
            static::$setupRun = true;
        }
    }

    public function testIndexManager()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX . '/managers');
        $response->assertStatus(200);
    }

    public function testStoreFinanceManager()
    {
        $manager = Manager::factory()->raw([
            'password'  => 'password',
            'password_confirmation' => 'password',
            'user_type' => Manager::FINANCE_MANAGER
        ]);

        $response = $this->actingAs(static::$manager, 'manager')->postJson(RouteServiceProvider::MANAGER_PREFIX . '/managers', $manager);
        $response->assertStatus(200);
    }

    public function testPreventOwnerFromStoreMoreThanFinanceManager()
    {
        $manager = Manager::factory()->raw([
            'password'  => 'password',
            'password_confirmation' => 'password',
            'user_type' => Manager::FINANCE_MANAGER
        ]);

        $response = $this->actingAs(static::$manager, 'manager')->postJson(RouteServiceProvider::MANAGER_PREFIX . '/managers', $manager);
        $response->assertStatus(422);
    }

    public function testStoreBranchManager()
    {
        $manager = Manager::factory()->raw([
            'password'  => 'password',
            'password_confirmation' => 'password',
            'user_type' => Manager::BRANCH_MANAGER
        ]);

        $response = $this->actingAs(static::$manager, 'manager')->postJson(RouteServiceProvider::MANAGER_PREFIX . '/managers', $manager);
        $response->assertStatus(200);
    }

    public function testShowManager()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX . '/managers/' . Manager::inRandomOrder()->where('company_id', static::$manager->company_id)->first()->id);
        $response->assertStatus(200);
    }

    public function testUpdateBranchManager()
    {
        $manager = Manager::factory()->create([
            'user_type' => Manager::BRANCH_MANAGER,
            'company_id' => static::$manager->company_id
        ]);

        $response = $this->actingAs(static::$manager, 'manager')->patchJson(RouteServiceProvider::MANAGER_PREFIX . '/managers/' . $manager->id, $manager->toArray() + ['name'=>'new name']);
        $response->assertStatus(200);
    }

    public function testUpdateFinanceManager()
    {
        $manager = Manager::inRandomOrder()->where('user_type', Manager::BRANCH_MANAGER)->where('company_id', static::$manager->company_id)->first();

        $response = $this->actingAs(static::$manager, 'manager')->patchJson(RouteServiceProvider::MANAGER_PREFIX . '/managers/' . $manager->id, $manager->toArray() + ['name'=>'new finance manager name']);

        $response->assertStatus(200);
    }


    public function testDestroyManager()
    {
        $response = $this->actingAs(static::$manager, 'manager')->delete(RouteServiceProvider::MANAGER_PREFIX . '/managers/' . Manager::factory()->create(['company_id' => static::$manager->company_id])->id);
        $response->assertStatus(200);
    }

    public function testPreventManagerWithoutCompanyFromCreateBankAccounts()
    {
        $manager = Manager::factory()->create()->syncRoles([Manager::OWNER]);

        $this->actingAs($manager, 'manager');

        $this->json('POST', RouteServiceProvider::MANAGER_PREFIX . '/bank_accounts', [], ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    public function testUnlock()
    {
        $manager = Manager::factory()->create([
            'user_type' => Manager::BRANCH_MANAGER,
            'company_id' => static::$manager->company_id,
            'blocked_key' => Str::random(20)
        ]);
       
        $this->actingAs(static::$manager, 'manager')->post(RouteServiceProvider::MANAGER_PREFIX  . "/managers/unlock/{$manager->id}")
            ->assertStatus(200);

        $this->assertDatabaseHas('managers',[
            'id' => $manager->id,
            'blocked_key' => NULL,
        ]);
    }
}
