<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@pwi.co.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Manager PWI',
                'email' => 'manager@pwi.co.id',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'Staff Gudang',
                'email' => 'gudang@pwi.co.id',
                'password' => Hash::make('password'),
                'role' => 'staff_gudang',
            ],
            [
                'name' => 'Staff Logistik',
                'email' => 'logistik@pwi.co.id',
                'password' => Hash::make('password'),
                'role' => 'staff_logistik',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
