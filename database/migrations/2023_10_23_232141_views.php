<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            SELECT alumni.*, akun.role FROM alumni
            INNER JOIN akun ON akun.id_akun = alumni.id_akun'
        );
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_profile_super_admin");
        DB::statement("DROP VIEW IF EXISTS view_profile_admin");
        DB::statement("DROP VIEW IF EXISTS view_profile_alumni");
    }
};
