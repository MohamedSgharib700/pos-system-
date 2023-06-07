<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    protected static $manager;
    protected static $manager_data;
    protected static $setupRun = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setupRun) {
            static::$manager_data = [
                'email' => 'profile@manager.com',
                'password' => 'password',
            ];

            static::$manager = Manager::updateOrCreate(
                ['email' => static::$manager_data['email']],
                Manager::factory()->raw(static::$manager_data)
            );
            static::$setupRun = true;
        }
    }

    public function testShowManager()
    {
        $response = $this->actingAs(static::$manager, 'manager')->get('/' . RouteServiceProvider::MANAGER_PREFIX . '/profile');
        $response->assertStatus(200);
    }

    public function testUpdateManager()
    {
        $response = $this->actingAs(static::$manager, 'manager')->put('/' . RouteServiceProvider::MANAGER_PREFIX . '/profile/' . static::$manager->id, Manager::factory()->raw([
            'phone' => '+0985951648',
        ]));
        $response->assertStatus(200);
    }

    public function testChangePasswordManager()
    {
        $response = $this->actingAs(static::$manager, 'manager')->post('/' . RouteServiceProvider::MANAGER_PREFIX . '/change_password', [
            'old_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);
        $response->assertStatus(200);
    }
}
