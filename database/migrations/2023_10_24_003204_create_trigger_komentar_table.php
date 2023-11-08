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
    // melakukan pencatatan logs dengan trigger pada saat insert komentar, edit komentar
    // dan delete komentar
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER add_logs
        BEFORE INSERT ON komentar
        FOR EACH ROW
        BEGIN
            DECLARE creator_name VARCHAR(60);
            
            SELECT nama INTO creator_name FROM alumni WHERE id_akun = NEW.id_pembuat;
            
            INSERT INTO logs(tabel, nama, tanggal, jam, aksi, record)
            VALUES ("komentar", creator_name, CURDATE(), CURTIME(), "Tambah", "Sukses");
            END
    ');
    DB::unprepared('
        CREATE TRIGGER update_logs
        AFTER UPDATE ON komentar
        FOR EACH ROW
        BEGIN
            DECLARE creator_name VARCHAR(60);
            
            SELECT nama INTO creator_name FROM alumni WHERE id_akun = NEW.id_pembuat;
            
            INSERT INTO logs(tabel, nama, tanggal, jam, aksi, record)
            VALUES ("komentar", creator_name, CURDATE(), CURTIME(), "Update", "Sukses");
            END
        ');

        DB::unprepared('
        CREATE TRIGGER delete_logs
        AFTER DELETE ON komentar
        FOR EACH ROW
        BEGIN
            DECLARE creator_name VARCHAR(60);
            
            SELECT nama INTO creator_name FROM alumni WHERE id_akun = OLD.id_pembuat;
            
            INSERT INTO logs(tabel, nama, tanggal, jam, aksi, record)
            VALUES ("komentar", creator_name, CURDATE(), CURTIME(), "Hapus", "Sukses");
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