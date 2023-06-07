<?php

namespace Tests\Feature\PosUser;

use App\Models\PosUser;
use App\Notifications\SendForgetPassword;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
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

    public function testPosUserForgetPassword()
    {
        Notification::fake();
        $response = $this->actingAs(static::$posUser, 'pos_s')->post(RouteServiceProvider::POS_PREFIX . '/forget_password',['email' => static::$posUser->email]);
        Notification::assertSentTo(static::$posUser, SendForgetPassword::class);
        $response->assertStatus(200);
    }

    public function testPosUserResetPassword()
    {
        $code = random_int(100000, 999999);
        static::$posUser->update(['forget_code' => $code]);
        $this->actingAs(static::$posUser, 'pos_s')->post(RouteServiceProvider::POS_PREFIX . '/reset_password',[
                'email' => static::$posUser->email,
                'forget_code' => static::$posUser->forget_code
            ])
            ->assertStatus(200);
    }

    public function testPosUserUpdateForgetPassword()
    {
        $this->actingAs(static::$posUser, 'pos_s')->post(RouteServiceProvider::POS_PREFIX . '/update_forget_password',[
                'password' => 'password2',
                'password_confirmation' => 'password2'
            ])
            ->assertStatus(200);
    }

}
