<?php

namespace Tests\Feature\Manager\Branch;

use App\Models\Manager;
use App\Modules\BanksAccounts\Entities\BanksAccount;
use App\Modules\Banks\Entities\Bank;
use App\Modules\Branch\Entities\Branch;
use App\Modules\Company\Entities\Company;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class BankAccountTest extends TestCase
{
    protected static $manager;
    protected static $branch;
    protected static $bankAccount;

    protected static $migrationRun = false;

    public function setUp(): void
    {
        parent::setUp();
        static::$manager = Manager::newFactory()->create(["user_type" => Manager::BRANCH_MANAGER]);
        static::$branch = Branch::newFactory()->create([
            "manager_id" => static::$manager->id,
            "company_id" => static::$manager->company->id,
        ]);
        static::$bankAccount = static::$branch->banksAccounts()->create([
            "bank_id" => Bank::factory()->create()->id,
            "iban" => "MF" . rand('1111111', '9999999'),
        ]);
        if (!static::$migrationRun) {
            static::$migrationRun = true;
        }
    }

    public function testIndexBanksAccounts()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX . '/branch/bank_accounts?branch_id='. static::$branch->id);
        $response->assertStatus(200);
    }

    public function testStoreBanksAccount()
    {
        $banks_account = BanksAccount::factory()->raw(["branch_id" => static::$branch->id]);
        $response = $this->actingAs(static::$manager, 'manager')->postJson(RouteServiceProvider::MANAGER_PREFIX . '/branch/bank_accounts', $banks_account);
        $response->assertStatus(200);
    }

    public function testShowBankAccount()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get(RouteServiceProvider::MANAGER_PREFIX . '/branch/bank_accounts/' . static::$bankAccount->id . '?branch_id=' . static::$branch->id);
        $response->assertStatus(200);
    }

    public function testUpdateBankAccount()
    {
        $banks_account = BanksAccount::factory()->raw(["branch_id" => static::$branch->id]);
        $response = $this->actingAs(static::$manager, 'manager')->patchJson(RouteServiceProvider::MANAGER_PREFIX . '/branch/bank_accounts/' . static::$bankAccount->id, $banks_account);
        $response->assertStatus(200);
    }

    public function testDeleteBankAccount()
    {
        $response = $this->actingAs(static::$manager, 'manager')->delete(RouteServiceProvider::MANAGER_PREFIX . '/branch/bank_accounts/' . static::$bankAccount->id . '?branch_id=' . static::$branch->id);
        $response->assertStatus(200);
    }
}
