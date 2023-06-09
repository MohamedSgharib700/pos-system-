<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Admin::count()) {
            Admin::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@rasid.com',
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
