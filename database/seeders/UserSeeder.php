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
                'username' => 'superadmin1',
                'role' => 'superAdmin',
                'password' => Hash::make('superadmin1')
            ],
            [
                'username' => 'admin1',
                'role' => 'admin',
                'password' => Hash::make('admin1')
            ],
            [
                'username' => 'alumni1',
                'role' => 'alumni',
                'password' => Hash::make('alumni1')
            ]
        ];

        // Melakukan looping data dengan foreach
        foreach ($userData as $user => $val) {
            Akun::create($val);
        }
    }
}