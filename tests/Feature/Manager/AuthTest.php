<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testRegisterManager()
    {
        $manager_data = Manager::factory()->raw([
            'password' => 'password',
            'password_confirmation' => 'password',
            'user_type'=>Manager::OWNER,
            'tax_number'=>(string) mt_rand(000000000, 111111111),
            'commercial_registration_number'=> '1010619975',
            'identification_number'=>1057174490
        ]);
        $response = $this->post('/' . RouteServiceProvider::MANAGER_PREFIX . '/register', $manager_data);
        $response->assertStatus(200);
    }

    public function testLoginManager()
    {
        $manager_data = [
            'email' => 'login@manager.com',
            'password' => 'password',
        ];

        $manager = Manager::updateOrCreate(
            ['email' => $manager_data['email']],
            Manager::factory()->raw($manager_data)
        );
        $response = $this->postJson('/' . RouteServiceProvider::MANAGER_PREFIX . '/login', $manager_data);
        $response->assertStatus(200);
    }

    public function testLogoutManager()
    {
        $response = $this->get(
            '/' . RouteServiceProvider::MANAGER_PREFIX . '/logout',
            ['Authorization' => 'Bearer ' . Manager::factory()->create()->createToken('manager-token')->plainTextToken]
        );
        $response->assertStatus(200);
    }
}
