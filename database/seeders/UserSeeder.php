<?php

namespace Database\Seeders;

use App\Models\Akun;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'username' => 'superadmin',
                'role' => 'superAdmin',
                'password' => Hash::make('superadmin')
            ]
            // ,
            // [
            //     'username' => 'admin',
            //     'role' => 'admin',
            //     'password' => Hash::make('admin')
            // ],
            // [
            //     'username' => 'alumni',
            //     'role' => 'alumni',
            //     'password' => Hash::make('alumni')
            // ]
        ];

        // Melakukan looping data dengan foreach
        foreach ($userData as $user => $val) {
            Akun::create($val);
        }
    }
}