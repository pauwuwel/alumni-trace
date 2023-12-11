<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        DB::unprepared(
            
            'CREATE TRIGGER createKarir
            AFTER INSERT ON karir
            FOR EACH ROW
            BEGIN
                DECLARE actor varchar(60);
                SELECT username INTO actor FROM akun WHERE id_akun = 3;

                INSERT INTO logs (logs)
                VALUES (CONCAT(actor, " telah menambah riwayat karir ", " pada ", CURDATE()));
            END'

        );

        DB::unprepared(
            
            'CREATE TRIGGER updateKarir
            AFTER UPDATE ON karir
            FOR EACH ROW
            BEGIN
                DECLARE actor varchar(60);
                SELECT username INTO actor FROM akun WHERE id_akun = 3;

                INSERT INTO logs (logs)
                VALUES (CONCAT(actor, " telah mengupdate riwayat karir ", " pada ", CURDATE()));
            END'

        );

        DB::unprepared(
            
            'CREATE TRIGGER deleteKarir
            AFTER DELETE ON karir
            FOR EACH ROW
            BEGIN
                DECLARE actor varchar(60);
                SELECT username INTO actor FROM akun WHERE id_akun = 3;

                INSERT INTO logs (logs)
                VALUES (CONCAT(actor, " telah menghapus riwayat karir ", " pada ", CURDATE()));
            END'

        );

    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS createAkun');
        DB::unprepared('DROP TRIGGER IF EXISTS updateAkun');
        DB::unprepared('DROP TRIGGER IF EXISTS deleteAkun');
        DB::unprepared('DROP TRIGGER IF EXISTS createKarir');
        DB::unprepared('DROP TRIGGER IF EXISTS updateKarir');
        DB::unprepared('DROP TRIGGER IF EXISTS deleteKarir');
    }

};
