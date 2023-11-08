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
    //membuat join table admin ke table forum
    public function up(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS view_admin_forum;");
        DB::unprepared("
            CREATE VIEW view_admin_forum AS SELECT
            f.*,a.nama AS admin_nama
            FROM forum
            INNER JOIN akun ak ON f.id_pembuat=ak.id_akun
            INNER JOIN admin a ON ak.id_akun=a.id_akun;
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS view_admin_forum;");
    }
};
