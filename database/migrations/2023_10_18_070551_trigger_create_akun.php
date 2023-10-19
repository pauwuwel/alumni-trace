<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up()
    {
        DB::unprepared(
            'CREATE TRIGGER trgCreateAkun AFTER INSERT ON akun
            FOR EACH ROW
            BEGIN
                DECLARE akun_id INT;
                DECLARE uname VARCHAR(60);
                DECLARE role_akun TEXT;
                
                SET akun_id = NEW.id_akun;
                SET uname = NEW.username;
                SET role_akun = NEW.role;

                IF role_akun = "admin" THEN
                    INSERT INTO admin (id_akun, nama) VALUES (akun_id, uname);
                END IF;

                IF role_akun = "alumni" THEN
                    INSERT INTO alumni (id_akun, nama) VALUES (akun_id, uname);
                END IF;

                IF role_akun = "superAdmin" THEN
                    INSERT INTO super_admin (id_akun, nama) VALUES (akun_id, uname);
                END IF;
                
            END'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DROP Trigger on Rollback
        DB::unprepared('DROP TRIGGER IF EXISTS trgCreateAkun'); //
    }
};