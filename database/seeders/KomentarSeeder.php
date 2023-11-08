<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //melakukan insert data pada tabel komentar dengan menggunakan seeder
    public function run(): void
    {
        DB::table('komentar')->insert([
            [
                'id_komentar'=> '3',
                'id_forum'=> '1',
                'id_pembuat'=> '4',
                'komentar'=> 'ini komentar',
                'attachment' => '811c4377d59d9c29f8db04bcbc577eeb.png                ',
                'tanggal_post'=> '2023-10-31',
            ],
        ]);
    }
}
