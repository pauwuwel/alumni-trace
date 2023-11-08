<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        DB::unprepared(
            
            'CREATE TRIGGER craeteAkun
            AFTER INSERT ON akun
            FOR EACH ROW
            BEGIN
                DECLARE actor varchar(60);
                SELECT username INTO actor FROM akun WHERE id_akun = 1;

                INSERT INTO logs (logs)
                VALUES (CONCAT(actor, " membuat akun dengan username ", NEW.username , " pada ", CURDATE()));
            END'

        );

        DB::unprepared(
            
            'CREATE TRIGGER updateAkun
            AFTER UPDATE ON akun
            FOR EACH ROW
            BEGIN
                DECLARE actor varchar(60);
                SELECT username INTO actor FROM akun WHERE id_akun = 1;

                INSERT INTO logs (logs)
                VALUES (CONCAT(actor, " melakukan perubahan pada akun dengan username ", OLD.username , " pada ", CURDATE()));
            END'

        );

        DB::unprepared(
            
            'CREATE TRIGGER deleteAkun
            AFTER DELETE ON akun
            FOR EACH ROW
            BEGIN
                DECLARE actor varchar(60);
                SELECT username INTO actor FROM akun WHERE id_akun = 1;

                INSERT INTO logs (logs)
                VALUES (CONCAT(actor, " menghapus akun dengan username ", OLD.username , " pada ", CURDATE()));
            END'

        );

    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS createAkun');
        DB::unprepared('DROP TRIGGER IF EXISTS updateAkun');
        DB::unprepared('DROP TRIGGER IF EXISTS deleteAkun');
    }

};
