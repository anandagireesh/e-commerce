<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());

        $customerRole = Role::create(['name' => 'Customer']);
        $customerRole->givePermissionTo(['create order','list order','get single order','cancel order']);
    }
}
