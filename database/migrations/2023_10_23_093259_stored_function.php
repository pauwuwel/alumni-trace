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
    //melakukan pengambilan total jumlah data isi komentar dengan penggunaan stored function
    public function up(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getTotalForum');

        DB::unprepared('
        CREATE FUNCTION getTotalForum() RETURNS INT
        BEGIN
            DECLARE total INT;
            SELECT COUNT(*) INTO total FROM forum;
            RETURN total;
        END
       ');
    //melakukan pengambilan total jumlah data isi komentar dengan penggunaan stored function
       DB::unprepared('DROP FUNCTION IF EXISTS getTotalKomentar');

       DB::unprepared('
       CREATE FUNCTION getTotalKomentar() RETURNS INT
       BEGIN
           DECLARE total INT;
           SELECT COUNT(*) INTO total FROM komentar;
           RETURN total;
       END
      ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getTotalForum');
        DB::unprepared('DROP FUNCTION IF EXISTS getTotalKomentar');
    }
};
