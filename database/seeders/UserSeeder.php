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
            ],
            [
                'username' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('admin')
            ],
            [
                'username' => 'abdimalik',
                'role' => 'alumni',
                'password' => Hash::make('abdimalik')
            ],
            [
                'username' => 'banna',
                'role' => 'alumni',
                'password' => Hash::make('banna')
            ],
            [
                'username' => 'dinda',
                'role' => 'alumni',
                'password' => Hash::make('dinda')
            ],
            [
                'username' => 'dila',
                'role' => 'alumni',
                'password' => Hash::make('dila')
            ],
            [
                'username' => 'manda',
                'role' => 'alumni',
                'password' => Hash::make('manda')
            ],
            [
                'username' => 'dwiki',
                'role' => 'alumni',
                'password' => Hash::make('dwiki')
            ],
            [
                'username' => 'parel',
                'role' => 'alumni',
                'password' => Hash::make('parel'),
            ],
            [
                'username' => 'gahtan',
                'role' => 'alumni',
                'password' => Hash::make('gahtan')
            ],
            [
                'username' => 'radit',
                'role' => 'alumni',
                'password' => Hash::make('radit')
            ],
            [
                'username' => 'motik',
                'role' => 'alumni',
                'password' => Hash::make('motik')
            ],
            [
                'username' => 'subkan',
                'role' => 'alumni',
                'password' => Hash::make('subkan')
            ]
        ];

        // Melakukan looping data dengan foreach
        foreach ($userData as $user => $val) {
            Akun::create($val);
        }
    }
}
