<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use App\Notifications\SendForgetPassword;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    protected static $manager;
    protected static $manager_data;
    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$manager = Manager::factory()->create();
            static::$setupRun = true;
        }
    }

    public function testManagerForgetPassword()
    {
        Notification::fake();
        $response = $this->actingAs(static::$manager, 'manager')->post(RouteServiceProvider::MANAGER_PREFIX . '/forget_password',['email' => static::$manager->email]);
        Notification::assertSentTo(static::$manager, SendForgetPassword::class);
        $response->assertStatus(200);
    }

    public function testManagerResetPassword()
    {
        $code = random_int(100000, 999999);
        static::$manager->update(['forget_code' => $code]);
        $this->actingAs(static::$manager, 'manager')->post(RouteServiceProvider::MANAGER_PREFIX . '/reset_password',[
                'email' => static::$manager->email,
                'forget_code' => static::$manager->forget_code
            ])
            ->assertStatus(200);
    }

    public function testManagerUpdateForgetPassword()
    {
        $this->actingAs(static::$manager, 'manager')->post(RouteServiceProvider::MANAGER_PREFIX . '/update_forget_password',[
                'password' => 'password2',
                'password_confirmation' => 'password2'
            ])
            ->assertStatus(200);
    }
}
