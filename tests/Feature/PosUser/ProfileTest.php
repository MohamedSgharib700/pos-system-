<?php

namespace Tests\Feature\PosUser;

use App\Models\PosUser;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    protected static $posUser;
    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$posUser = PosUser::factory()->create();
            static::$setupRun = true;
        }
    }

    public function testPosUserProfile()
    {
        $this->actingAs(static::$posUser, 'pos_s')->get(RouteServiceProvider::POS_PREFIX . '/profile')
            ->assertStatus(200);
    }

    public function testPosUserUpdateProfile()
    {
        $this->actingAs(static::$posUser, 'pos_s')->post(RouteServiceProvider::POS_PREFIX . '/update_profile/'.static::$posUser->id, [
            'name'  => 'new name',
            'email'  => 'new@email.com'
        ])
            ->assertStatus(200);
    }

    public function testPosUserUpdatePassword()
    {
        $this->actingAs(static::$posUser, 'pos_s')->post(RouteServiceProvider::POS_PREFIX . '/update_password', [
            'password' => 'password2',
            'password_confirmation' => 'password2',
        ])
            ->assertStatus(200);
    }
}
