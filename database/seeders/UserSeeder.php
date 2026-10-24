<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Admin',
                'email'     => 'admin@gmail.com',
                'password'  => 'admin123',
                'role'      => 'admin',
            ],
            [
                'name'      => 'superadmin',
                'email'     => 'superadmin@gmail.com',
                'password'  => 'superadmin123',
                'role'      => 'superadmin',
            ],
        ];

        foreach ($users as $item) {
            User::create($item);
        }
    }
}
