<?php

namespace App\Modules\Permission\Database\Seeders;

use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class FirstRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $gMRole = Role::where('name', 'GeneralManager')->first();
        if (!$gMRole) {
            Role::create([
                'name' => 'GeneralManager',
                'guard_name' => 'admin',
                'slug' => 'المدير العام'
            ]);

            DB::table('model_has_roles')->insert([
                'role_id' => 1,
                'model_type' => Admin::class,
                'model_id' => 1
            ]);
        }
        $OwnerRole = Role::where('name', Manager::OWNER)->first();
        if (!$OwnerRole) {
           $role = Role::create([
                'name' => Manager::OWNER,
                'guard_name' => 'manager',
                'slug' => 'المدير'
            ]);

            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => Manager::class,
                'model_id' => 1
            ]);
        }

        $fMRole = Role::where('name', Manager::FINANCE_MANAGER)->first();
        if (!$fMRole) {
           $role = Role::create([
                'name' => Manager::FINANCE_MANAGER,
                'guard_name' => 'manager',
                'slug' => 'المدير المالي'
            ]);

         
        }

        $bMRole = Role::where('name', Manager::BRANCH_MANAGER)->first();
        if (!$bMRole) {
           $role = Role::create([
                'name' => Manager::BRANCH_MANAGER,
                'guard_name' => 'manager',
                'slug' => 'مدير الفرع'
            ]);
        }
    }
}
