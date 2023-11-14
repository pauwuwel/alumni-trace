<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Akun::create([
            'id_akun' => 1,
            'username' => 'superadmin',
            'password'=> Hash::make('123'),
            'role'=> 'superAdmin',
        ]);
        \App\Models\Akun::create([
            'id_akun' => 2,
            'username' => 'admin',
            'password'=> Hash::make('123'),
            'role'=> 'admin',
        ]);
        \App\Models\Akun::create([
            'id_akun' => 3,
            'username' => 'alumni',
            'password'=> Hash::make('123'),
            'role'=> 'alumni',
        ]);
        \App\Models\SuperAdmin::create([
            'id_akun'=> 1,
            'nama'=> 'parel',
        ]);
        \App\Models\Admin::create([
            'id_akun'=> 2,
            'nama'=> 'gahtan',
        ]);
        \App\Models\Alumni::create([
            'id_akun'=> 3,
            'nama'=> 'banskuy',
        ]);
        \App\Models\Forum::create([
            'id_pembuat'=> 2,
            'judul'=> 'example forum admin',
            'content'=> 'lorem ipsum',
            'status'=> 'accepted',
            'tanggal_post'=> Carbon::now(),
        ]);
        \App\Models\Forum::create([
            'id_pembuat'=> 3,
            'judul'=> 'example forum alumni',
            'content'=> 'lorem ipsum',
            'status'=> 'pending',
            'tanggal_post'=> Carbon::now(),
        ]);
    }
}
