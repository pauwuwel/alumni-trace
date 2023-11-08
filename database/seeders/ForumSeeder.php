<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //melakukan insert data pada tabel forum dengan seeder
    public function run(): void
    {
        DB::table('forum')->insert([
            [
               'id_pembuat' => '4',
                'judul' => 'informasi mencari pekerjaan',
                'content' => 'lowongan pekerjaan',
                'attachment' => 'pp.png
                ',
                'status' => 'accepted',
                'tanggal_post' => '2023-10-24',
            ],
        ]);
    }
}
