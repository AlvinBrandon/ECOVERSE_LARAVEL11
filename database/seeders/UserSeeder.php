<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@material.com',
                'password' => Hash::make('secret'),
                'role' => 'admin',
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@material.com',
                'password' => Hash::make('secret'),
                'role' => 'staff',
            ],
            [
                'name' => 'Supplier',
                'email' => 'supplier@material.com',
                'password' => Hash::make('secret'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@material.com',
                'password' => Hash::make('secret'),
                'role' => 'customer',
            ],
            [
                'name' => 'Retailer',
                'email' => 'retailer@material.com',
                'password' => Hash::make('secret'),
                'role' => 'retailer',
            ],
            [
                'name' => 'Wholesaler',
                'email' => 'wholesaler@material.com',
                'password' => Hash::make('secret'),
                'role' => 'wholesaler',
            ],
        ];
        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
