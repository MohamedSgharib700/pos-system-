<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Notifications\SendForgetPassword;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    protected static $admin;
    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$admin = Admin::factory()->create();
            static::$setupRun = true;
        }
    }

    public function testAdminForgetPassword()
    {
        Notification::fake();
        $response = $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . '/forget_password',['email' => static::$admin->email]);
        Notification::assertSentTo(static::$admin, SendForgetPassword::class);
        $response->assertStatus(200);
    }

    public function testAdminResetPassword()
    {
        $code = random_int(100000, 999999);
        static::$admin->update(['forget_code' => $code]);
        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . '/reset_password',[
                'email' => static::$admin->email,
                'forget_code' => static::$admin->forget_code
            ])
            ->assertStatus(200);
    }

    public function testAdminUpdateForgetPassword()
    {
        $this->actingAs(static::$admin, 'admin')->post(RouteServiceProvider::ADMIN_PREFIX . '/update_forget_password',[
                'password' => 'password2',
                'password_confirmation' => 'password2'
            ])
            ->assertStatus(200);
    }

}
