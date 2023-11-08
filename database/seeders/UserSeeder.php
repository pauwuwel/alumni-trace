<?php

namespace Database\Seeders;

use App\Models\Akun;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $userData = [
            [
                'username' => 'superadmin',
                'role' => 'superAdmin',
                'password' => Hash::make('superadmin')
            ]
        ];

        foreach ($userData as $user) {
            $akun = Akun::create($user);
            SuperAdmin::create([
                'id_akun' => $akun->id_akun,
                'nama' => $akun->username,
            ]);
        }
    }
}
