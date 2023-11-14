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
            'id_pembuat'=> 3,
            'judul'=> 'Ayo Ramaikan Clubing!!',
            'content'=> 'Abang Tukang Bakso, cepat dong, kemari Sudah tak tahan lagi Satu mangkok saja, 5000 perak Yang banyak baksonya Tidak pakai saus, tidak pakai sambal Tapi minta pakai kol',
            'status'=> 'accepted',
            'tanggal_post'=> Carbon::now(),
        ]);
        \App\Models\Forum::create([
            'id_pembuat'=> 3,
            'judul'=> 'Tutorial Laravel 10 By Banskuyy',
            'content'=> 'Cicak-cicak di dinding Diam-diam merayap Datang seekor nyamuk Hap! Lalu ditangkap Cicak-cicak di dinding Diam-diam merayap Datang seekor nyamuk Hap! Lalu ditangkap Cicak-cicak di dinding Diam-diam merayap Datang seekor nyamuk Hap! Lalu ditangkap Cicak-cicak di dinding Diam-diam merayap Datang seekor nyamuk Hap! Lalu ditangkap',
            'status'=> 'accepted',
            'tanggal_post'=> Carbon::now()->subMonth(),
        ]);
        \App\Models\Komentar::create([
            'id_pembuat'=> 3,
            'id_forum'=> 1,
            'komentar'=> 'aku komentar',
            'tanggal_post'=> Carbon::now(),
        ]);
        \App\Models\Komentar::create([
            'id_pembuat'=> 2,
            'id_forum'=> 1,
            'komentar'=> 'aku kaya',
            'tanggal_post'=> Carbon::now(),
        ]);
        \App\Models\Komentar::create([
            'id_pembuat'=> 1,
            'id_forum'=> 2,
            'komentar'=> 'loh kok',
            'tanggal_post'=> Carbon::now(),
        ]);
    }
}
