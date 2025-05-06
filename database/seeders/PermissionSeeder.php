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
        $permissions = [
            'role-list',
            'role-create',
            'role-delete',
            'role-edit','view products','create products','edit products','delete products','manage inventory',
            'view orders','create orders','edit orders','delete orders','process payments',
            'view users','create users','edit users','delete users','assign roles',
            
        ];

        foreach($permissions as $key => $permission){
            Permission::create(['name' => $permission]);
        }

    }
}
