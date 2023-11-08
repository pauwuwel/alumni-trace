<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS createProfile');

        DB::unprepared(
            'CREATE PROCEDURE createProfile(
                IN new_id_akun INT,
                IN new_username VARCHAR(60),
                IN new_role TEXT
            )
            BEGIN

                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK TO checkpoint;
                    SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Kesalahan pada createProfile: Terdapat kesalahan pada data yang di input.";
                END;

                START TRANSACTION;
                SAVEPOINT checkpoint;

                IF new_role = "admin" THEN
                    INSERT INTO admin (id_akun, nama) VALUES (new_id_akun, new_username);
            
                ELSEIF new_role = "alumni" THEN
                    INSERT INTO alumni (id_akun, nama) VALUES (new_id_akun, new_username);
            
                ELSEIF new_role = "superAdmin" THEN
                    INSERT INTO superadmin (id_akun, nama) VALUES (new_id_akun, new_username);

                ELSE
                    SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Kesalahan pada createProfile: Role yang di input tidak terdaftar.";
                END IF;
                
                COMMIT;
            END'
        );
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS createProfile');
    }

};
