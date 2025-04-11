<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(
            [
                'name' => 'create product'
            ]
        );

        Permission::create(
            [
                'name' => 'update product'
            ]
        );

        Permission::create(
            [
                'name' => 'delete product'
            ]
        );

        Permission::create(
            [
                'name' => 'list product'
            ]
        );

        Permission::create(
            [
                'name' => 'get single product'
            ]
        );

        Permission::create(
            [
                'name' => 'create order'
            ]
        );

        Permission::create(
            [
                'name' => 'list order'
            ]
        );

        Permission::create(
            [
                'name' => 'get single order'
            ]
        );

        Permission::create(
            [
                'name' => 'cancel order'
            ]
        );
    }
}
