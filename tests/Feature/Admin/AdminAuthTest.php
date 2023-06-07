<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    public function testRegisterAdmin()
    {
        $admin_data = Admin::factory()->raw([
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response = $this->post(RouteServiceProvider::ADMIN_PREFIX . '/register', $admin_data);
        $response->assertStatus(401);
    }

    public function testLoginAdmin()
    {
        $admin_data = [
            'email' => 'test@admin.com',
            'password' => 'password',
        ];

        $admin = Admin::updateOrCreate(
            ['email' => $admin_data['email']],
            Admin::factory()->raw($admin_data)
        );
        $response = $this->postJson(RouteServiceProvider::ADMIN_PREFIX . '/login', $admin_data);
        $response->assertStatus(200);
    }

    public function testLogoutAdmin()
    {
        $response = $this->postJson(
            RouteServiceProvider::ADMIN_PREFIX . '/logout',
            [],
            ['Authorization' => 'Bearer ' . Admin::factory()->create()->createToken('admin-token')->plainTextToken]
        );
        $response->assertStatus(200);
    }
}
