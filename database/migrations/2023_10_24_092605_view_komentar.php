<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //melakukan pengambilan data dari tabel sql dengan menggunakan view sql
    //menggunakan inner join dari tabel komentar ke tabel akun
    public function up(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS view_komentar;");
        DB::unprepared("
        CREATE VIEW view_komentar AS SELECT
            k.id_komentar AS id_komentar,
            k.id_forum AS id_forum,
            k.id_pembuat AS id_pembuat,
            k.komentar AS komentar,
            k.attachment AS attachment,
            k.tanggal_post AS tanggal_post,
            a.id_akun AS id_akun,
            a.username AS username
        FROM komentar k
        JOIN akun a ON k.id_pembuat = a.id_akun  
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       DB::unprepared("DROP VIEW IF EXISTS view_komentar;"); 
    }
};
