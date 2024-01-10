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
                DECLARE newActor varchar(60);
                SELECT username INTO newActor FROM akun WHERE id_akun = 1;

                INSERT INTO logs (actor, action, `table`, row, `date`)
                VALUES (newActor, "INSERT", "akun", NEW.id_akun, NOW());
            END'
        );

        DB::unprepared(
            'CREATE TRIGGER updateAkun
            AFTER UPDATE ON akun
            FOR EACH ROW
            BEGIN
                DECLARE oldActor varchar(60);
                SELECT username INTO oldActor FROM akun WHERE id_akun = 1;

                INSERT INTO logs (actor, action, `table`, row, `date`)
                VALUES (oldActor, "UPDATE", "akun", OLD.id_akun, NOW());
            END'
        );

        DB::unprepared(
            'CREATE TRIGGER deleteAkun
            AFTER DELETE ON akun
            FOR EACH ROW
            BEGIN
                DECLARE oldActor varchar(60);
                SELECT username INTO oldActor FROM akun WHERE id_akun = 1;

                INSERT INTO logs (actor, action, `table`, row, `date`)
                VALUES (oldActor, "UPDATE", "akun", OLD.id_akun, NOW());
            END'
        );

        DB::unprepared(
            'CREATE TRIGGER craeteForum
            AFTER INSERT ON forum
            FOR EACH ROW
            BEGIN
                DECLARE newActor varchar(60);
                SELECT username INTO newActor FROM akun WHERE id_akun = NEW.id_pembuat;

                INSERT INTO logs (actor, action, `table`, row, `date`)
                VALUES (newActor, "INSERT", "forum", NEW.id_forum, NOW());
            END'
        );
        
        DB::unprepared(
            'CREATE TRIGGER updateForum
            AFTER UPDATE ON forum
            FOR EACH ROW
            BEGIN
                DECLARE oldActor varchar(60);     
                SELECT username INTO oldActor FROM akun WHERE id_akun = OLD.id_pembuat;
            
                IF NEW.status = "accepted" AND OLD.status <> NEW.status THEN
                    SELECT username INTO oldActor FROM akun WHERE id_akun = NEW.reviewedBy;
            
                    INSERT INTO logs (actor, action, `table`, row, `date`)
                    VALUES (oldActor, "ACCEPT", "forum", OLD.id_forum, NOW());
                ELSEIF NEW.status = "rejected" THEN 
                    SELECT username INTO oldActor FROM akun WHERE id_akun = NEW.reviewedBy;
            
                    INSERT INTO logs (actor, action, `table`, row, `date`)
                    VALUES (oldActor, "REJECT", "forum", OLD.id_forum, NOW());
                ELSEIF NEW.status = "deleted" THEN
                    SELECT username INTO oldActor FROM akun WHERE id_akun = NEW.reviewedBy;
            
                    INSERT INTO logs (actor, action, `table`, row, `date`)
                    VALUES (oldActor, "DELETE", "forum", OLD.id_forum, NOW());
                ELSEIF OLD.status = "accepted" AND OLD.status = NEW.status THEN
                    INSERT INTO logs (actor, action, `table`, row, `date`)
                    VALUES (oldActor, "UPDATE", "forum", OLD.id_forum, NOW());
                END IF;
            END'
        );

        DB::unprepared(
            'CREATE TRIGGER createKomen
            AFTER INSERT ON komentar
            FOR EACH ROW
            BEGIN
                DECLARE newActor varchar(60);
                SELECT username INTO newActor FROM akun WHERE id_akun = NEW.id_pembuat;

                INSERT INTO logs (actor, action, `table`, row, `date`)
                VALUES (newActor, "INSERT", "komentar", NEW.id_komentar, NOW());
            END'
        );

        DB::unprepared(
            'CREATE TRIGGER updateKomen
            AFTER UPDATE ON komentar
            FOR EACH ROW
            BEGIN
                DECLARE oldActor varchar(60);     
                SELECT username INTO oldActor FROM akun WHERE id_akun = NEW.deletedBy;
            
                INSERT INTO logs (actor, action, `table`, row, `date`)
                VALUES (oldActor, "DELETE", "komentar", OLD.id_komentar, NOW());
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
