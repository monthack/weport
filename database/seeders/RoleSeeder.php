<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'administrator']);
        $role2 = Role::create(['name' => 'empleado']);

        Permission::create(['name' => 'home'])->syncRoles([$role2]);
        Permission::create(['name' => 'admin.users'])->syncRoles($role1);
    }
}
