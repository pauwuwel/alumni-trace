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
            'CREATE OR REPLACE VIEW view_profile_super_admin AS 
            SELECT super_admin.*, akun.role FROM super_admin
            INNER JOIN akun ON akun.id_akun = super_admin.id_akun'
        );

        DB::unprepared(
            'CREATE OR REPLACE VIEW view_profile_admin AS 
            SELECT admin.*, akun.role FROM admin
            INNER JOIN akun ON akun.id_akun = admin.id_akun'
        );

        DB::unprepared(
            'CREATE OR REPLACE VIEW view_profile_alumni AS 
            SELECT alumni.*, akun.role, alamat.jalan, alamat.gang, alamat.blok, alamat.nomor_rumah, alamat.rt, alamat.rw, alamat.kelurahan, alamat.kecamatan, alamat.kota, alamat.kodepos FROM alumni
            INNER JOIN akun ON akun.id_akun = alumni.id_akun
            INNER JOIN alamat ON alumni.id_alumni = alamat.id_alumni'
        );

        DB::unprepared(
            'CREATE OR REPLACE VIEW view_forum_data AS 

            SELECT forum.*, alumni.nama as nama_pembuat FROM forum
            INNER JOIN akun ON forum.id_pembuat = akun.id_akun
            INNER JOIN alumni ON akun.id_akun = alumni.id_akun
            
            UNION

            SELECT forum.*, admin.nama as nama_pembuat FROM forum
            INNER JOIN akun ON forum.id_pembuat = akun.id_akun
            INNER JOIN admin ON akun.id_akun = admin.id_akun'
        );

        DB::unprepared(
            'CREATE OR REPLACE VIEW view_komentar_data AS 

            SELECT komentar.*, alumni.nama as nama_pembuat FROM komentar
            INNER JOIN forum ON komentar.id_forum = forum.id_forum
            INNER JOIN akun ON komentar.id_pembuat = akun.id_akun
            INNER JOIN alumni ON akun.id_akun = alumni.id_akun
            
            UNION

            SELECT komentar.*, admin.nama as nama_pembuat FROM komentar
            INNER JOIN forum ON komentar.id_forum = forum.id_forum
            INNER JOIN akun ON komentar.id_pembuat = akun.id_akun
            INNER JOIN admin ON akun.id_akun = admin.id_akun'
        );

        DB::unprepared(
            'CREATE OR REPLACE VIEW view_karir_alumni AS 

            SELECT karir.* FROM karir
            INNER JOIN alumni ON karir.id_alumni = alumni.id_alumni'
        );

        DB::unprepared(
            'CREATE VIEW view_total_karir AS

            SELECT
                COUNT(DISTINCT CASE WHEN jenis_karir = "kuliah" THEN id_alumni END) as total_kuliah,
                COUNT(DISTINCT CASE WHEN jenis_karir = "kerja" THEN id_alumni END) as total_kerja,
                COUNT(DISTINCT CASE WHEN jenis_karir = "wirausaha" THEN id_alumni END) as total_wirausaha
            FROM karir'
        );
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_profile_super_admin");
        DB::statement("DROP VIEW IF EXISTS view_profile_admin");
        DB::statement("DROP VIEW IF EXISTS view_profile_alumni");
        DB::statement("DROP VIEW IF EXISTS view_forum_data");
        DB::statement("DROP VIEW IF EXISTS view_komentar_data");
        DB::statement("DROP VIEW IF EXISTS view_karir_alumni");
        DB::statement("DROP VIEW IF EXISTS view_total_karir");
    }
};
