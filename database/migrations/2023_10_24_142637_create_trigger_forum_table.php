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
    //membuat trigger sebuah logs pada forum
    //pada saat insert update delete 
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER add_logs
        BEFORE INSERT ON forum
        FOR EACH ROW
        BEGIN
            DECLARE creator_name VARCHAR(60);
            
            -- Fetch the name of the creator from the alumni table
            SELECT nama INTO creator_name FROM alumni WHERE id_akun = NEW.id_pembuat;
            
            INSERT INTO logs(tabel, nama, tanggal, jam, aksi, record)
            VALUES ("Forum", new.id_pembuat, CURDATE(), CURTIME(), "Tambah", "Sukses");
            END
    ');
    DB::unprepared('
        CREATE TRIGGER update_logs
        AFTER UPDATE ON forum
        FOR EACH ROW
        BEGIN
            DECLARE creator_name VARCHAR(60);
            
            SELECT nama INTO creator_name FROM alumni WHERE id_akun = NEW.id_pembuat;
            
            INSERT INTO logs(tabel, nama, tanggal, jam, aksi, record)
            VALUES ("Forum", new.id_pembuat, CURDATE(), CURTIME(), "Update", "Sukses");
            END
        ');

        DB::unprepared('
        CREATE TRIGGER delete_logs
        AFTER DELETE ON forum
        FOR EACH ROW
        BEGIN
            DECLARE creator_name VARCHAR(60);
            
            SELECT nama INTO creator_name FROM alumni WHERE id_akun = OLD.id_pembuat;
            
            INSERT INTO logs(tabel, nama, tanggal, jam, aksi, record)
            VALUES ("Forum", old.id_pembuat, CURDATE(), CURTIME(), "Hapus", "Sukses");
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER add_logs');
        DB::unprepared('DROP TRIGGER update_logs');
        DB::unprepared('DROP TRIGGER delete_logs');
    }
};