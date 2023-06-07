<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use App\Modules\Banks\Entities\Bank;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use App\Modules\Company\Entities\Company;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class BanksAccountsTest extends TestCase
{
    protected static $manager;
    protected static $bankAccount;

    protected static $migrationRun = false;

    public function setUp(): void
    {
        parent::setUp();
        static::$manager = Manager::newFactory()->create();
        static::$bankAccount = static::$manager->company->banksAccounts()->create([
            "bank_id" => Bank::factory()->create()->id ,
            "iban" => "MF". rand('1111111', '9999999')
        ]);
        if (!static::$migrationRun) {
            static::$migrationRun = true;
        }
    }

    public function testIndexBanksAccounts()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX .'/bank_accounts');
        $response->assertStatus(200);
    }

    public function testStoreBanksAccount()
    {
        $banks_account = BanksAccount::factory()->raw();
        $response = $this->actingAs(static::$manager, 'manager')->postJson(RouteServiceProvider::MANAGER_PREFIX .'/bank_accounts', $banks_account);
        $response->assertStatus(200);
    }

    public function testShowBankAccount()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX .'/bank_accounts/' . static::$bankAccount->id);
        $response->assertStatus(200);
    }

    public function testUpdateBankAccount()
    {
        $banks_account = BanksAccount::factory()->raw();
        $response = $this->actingAs(static::$manager, 'manager')->patchJson(RouteServiceProvider::MANAGER_PREFIX .'/bank_accounts/' . static::$bankAccount->id, $banks_account);
        $response->assertStatus(200);
    }

    public function testDeleteBankAccount()
    {
        $response = $this->actingAs(static::$manager, 'manager')->delete(RouteServiceProvider::MANAGER_PREFIX .'/bank_accounts/' . static::$bankAccount->id);
        $response->assertStatus(200);
    }
}
