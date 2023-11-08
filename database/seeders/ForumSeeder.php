<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //Membuat seeder Untuk table forum
    public function run(): void
    {
        DB::table('forum')->insert([
            [
                'id_pembuat' => '2',
                'judul' => 'informasi pekerjaan',
                'content' => 'Saya membutuhkan lowongan pekerjaan',
                'attachment' => 'aku.png',
                'status' => 'accepted',
                'tanggal_post' => '2023-10-24',
            ],
        ]);
    }
}
