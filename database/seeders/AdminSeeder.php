<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $adminUser = Role::firstOrCreate(['name'=>'Admin']);

            User::firstOrCreate([
             'name' => 'Super Admin',
             'email' => 'admin@example.com',
             'password' => Hash::make('password123'),
             'role_id' => $adminUser->id
            ]);
    }
}
