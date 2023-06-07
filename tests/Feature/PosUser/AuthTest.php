<?php

namespace Tests\Feature\PosUser;

use App\Models\PosUser;
use App\Modules\Branch\Entities\Branch;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    protected static $posUser;
    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$posUser = PosUser::factory()->create(['is_active' => 1]);
            static::$setupRun = true;
        }
    }

    public function testPosUserRegister()
    {
        $branch = Branch::factory()->create();
        $this->post(RouteServiceProvider::POS_PREFIX . '/register', [
            'branch_id' => $branch->id,
            'company_id' => $branch->company->id,
            'name' => 'pos_user_name',
            'email' => 'pos@email.com',
            'email_verified_at' => now(),
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '01111111111',
            'serial_number' => '1',
            'is_active' => true,
            'serial_code' => '2',
            'identification_number' => '3',
            'remember_token' => Str::random(10),
        ])
            ->assertStatus(200);
    }

    public function testPosUserLogin()
    {
        $this->post(RouteServiceProvider::POS_PREFIX . '/login', [
            'email' => 'pos@email.com',
            'password' => "password",
        ])
            ->assertStatus(200);
    }

    public function testPosUserLogout()
    {
        $token = static::$posUser->createToken('pos-token')->plainTextToken;
        $header = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $this->actingAs(static::$posUser, 'pos_s')->post(RouteServiceProvider::POS_PREFIX . '/logout', [], $header)
            ->assertStatus(200);
    }
}
