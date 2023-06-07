<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Manager;
use App\Modules\Company\Entities\Company;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\Commissions\Entities\Commission;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommissionTest extends TestCase
{

    protected static $admin;

    public function setUp(): void
    {
        parent::setUp();
        static::$admin = Admin::first();
    }

    public function testCommissionCreatedSuccessfully()
    {
        $company = Company::newFactory()->create();

        $commsission = Commission::newFactory()->create([
            'company_id'=>$company->id
        ]);

        $this->actingAs(static::$admin, 'admin');

        $this->json('POST', RouteServiceProvider::ADMIN_PREFIX . '/commissions', $commsission->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);

            $this->assertDatabaseHas('commissions',[
                'company_id' => $company->id,
                'value' => $commsission->value,
            ]);

    }


    public function testCommissionShowSuccessfully()
    {
        $commission = Commission::newFactory()->create();

         $this->actingAs(static::$admin, 'admin');

        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/commissions/'.$commission->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($commission->id);
    }


    public function testCommissionUpdatedSuccessfully()
    {
        $commission = Commission::newFactory()->create();

        $commsission_data = [
            'value' => rand(1,100),
        ];

        $commsission_data = $commsission_data + $commission->toArray();

         $this->actingAs(static::$admin, 'admin');

        $this->json('PUT', RouteServiceProvider::ADMIN_PREFIX . '/commissions/'.$commission->id, $commsission_data, ['Accept' => 'application/json'])
            ->assertStatus(200);

        $this->assertTrue( $commission->fresh()->value == $commsission_data['value']);

    }

    public function testCommissionShowAllSuccessfully()
    {
        $commissions = Commission::newFactory()->count(2)->create();

         $this->actingAs(static::$admin, 'admin');

        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/commissions', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($commissions->first()->id);

    }



}
